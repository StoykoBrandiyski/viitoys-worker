<?php

namespace App\Jobs;

use App\Models\ProcessingProfile;
use App\Models\Product;
use GuzzleHttp\Client;
use HosseinHezami\LaravelGemini\Facades\Gemini;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Gemini\Data\Blob;
use Gemini as GeminiType;
use Gemini\Enums\MimeType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class ProcessProductJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 1800; // 10 minutes

    /**
     * Create a new job instance.
     * @param Product $product
     * @param Collection $images
     * @param int $profileId
     */
    public function __construct(
        private Product $product,
        private Collection  $images,
        private int $profileId
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $profile = ProcessingProfile::with('engine')->find($this->profileId);

            if (!$profile) {
                Log::error("ProcessProductJob: Profile not found. ID: {$this->profileId}");
                $this->product->update(['status' => 'failed']);
                return;
            }

            // Get the AI engine (property access, not method call)
            $engine = $profile->engine;

            if (!$engine) {
                Log::error("ProcessProductJob: AI Engine not found for profile. Profile ID: {$this->profileId}, Engine ID: {$profile->ai_engine_id}");
                $this->product->update(['status' => 'failed']);
                return;
            }

            if (!$engine->is_active) {
                Log::error("ProcessProductJob: AI Engine is not active. Engine ID: {$engine->id}");
                $this->product->update(['status' => 'failed']);
                return;
            }

            // Step 1: Process images with Python (RemBG + Resize + Watermark)
            foreach ($this->images as $image) {
                $inputPath = storage_path('app/public/' . $image->original_path);
                $processePath = 'processed/' . Str::random(20) . '.png';
                $outputPath = storage_path('app/public/'. $processePath );

                $process = Process::run([
                    base_path('python_env/bin/python3'),
                    storage_path('app/python/remove_bg.py'),
                    $inputPath,
                    $outputPath,
                    $profile->width,
                    $profile->height,
                    $profile->watermark_path ?? ''
                ]);

                if (!$process->successful()) {
                    $this->product->update(['status' => 'failed']);
                    return;
                }

                $image->update(['processed_path' => $processePath]);
            }

            // Step 2: Send to Gemini API for AI description
            $firstImagePath = null;
            foreach ($this->images as $image) {
                $firstImagePath = $image->original_path;
                break;  // Use only first image
            }

            if (!$firstImagePath) {
                Log::error("ProcessProductJob: No image path found for product {$this->product->id}");
                $this->product->update(['status' => 'failed']);
                return;
            }

            $imageFullPath = storage_path('app/public/' . $firstImagePath);
            if (!file_exists($imageFullPath)) {
                Log::error("ProcessProductJob: Image file not found: {$imageFullPath}");
                $this->product->update(['status' => 'failed']);
                return;
            }

            // Step 2: Send to Gemini API for AI description
            try {
                Log::info("ProcessProductJob: Calling Gemini API for product {$this->product->id}");

                // Initialize Gemini client with API key
                $httpClient = new Client([
                    'timeout'         => $engine->max_timeout ?? 30,
                    'connect_timeout' => 15,
                    'verify'          => false,
                ]);

                $client = GeminiType::factory()
                    ->withApiKey(base64_decode($engine->auth_token))
                    ->withHttpClient($httpClient) // Tell Gemini to use our "unsecure" client
                    ->make();

                $result = $client
                    ->generativeModel(model: $engine->model_name ?? 'gemini-2.0-flash')

                    ->generateContent([
                        $engine->system_prompt ?? 'Analyze this product image and provide a detailed description.',
                        new Blob(
                            MimeType::IMAGE_PNG,
                            base64_encode(
                                file_get_contents($imageFullPath)
                            )
                        )
                    ]);

                $content = $result->text();

                if (!$content) {
                    Log::error("ProcessProductJob: No content in API response for product {$this->product->id}");
                    $this->product->update(['status' => 'failed']);
                    return;
                }

                // Step 3: Update product with results
                $this->product->update([
                    'description' => $content,
                    'ai_raw_response' => json_encode([
                        'content' => $content,
                        'model' => $engine->model_name,
                        'timestamp' => now(),
                    ]),
                    'status' => 'processed'
                ]);

                Log::info("ProcessProductJob: Successfully processed product {$this->product->id}");

            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                Log::error("ProcessProductJob: API Connection Error", [
                    'product_id' => $this->product->id,
                    'message' => $e->getMessage(),
                ]);
                $this->product->update(['status' => 'failed']);
                return;
            } catch (\Exception $e) {
                Log::error("ProcessProductJob: Error", [
                    'product_id' => $this->product->id,
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
                $this->product->update(['status' => 'failed']);
                return;
            }
        } catch (\Exception $e) {
            Log::error("ProcessProductJob: Critical Error", [
                'product_id' => $this->product->id,
                'exception' => get_class($e),
                'message' => $e->getMessage(),
            ]);
            $this->product->update(['status' => 'failed']);
        }
    }
}
