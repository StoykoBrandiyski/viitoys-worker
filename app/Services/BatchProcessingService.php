<?php

namespace App\Services;

use App\Jobs\ProcessProductJob;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class BatchProcessingService
{
    /**
     * Process all pending products in batch
     * This is called by the scheduler every 10 minutes
     */
    public function processPendingProducts(): void
    {
        try {
            // Find products waiting in queue (pending status)
            $waitingProducts = Product::where('status', 'pending')->get();

            if ($waitingProducts->isEmpty()) {
                Log::info("BatchProcessingService: No pending products to process");
                return;
            }

            Log::info("BatchProcessingService: Found {$waitingProducts->count()} pending product(s)");

            $processed = 0;
            $skipped = 0;

            foreach ($waitingProducts as $product) {
                // Get all images for this product
                $images = $product->images()->get();

                if ($images->isEmpty()) {
                    Log::warning("BatchProcessingService: Skipping product {$product->id} - no images found");
                    $skipped++;
                    continue;
                }

                try {
                    // Update status to 'processing' before dispatching
                    $product->update(['status' => 'processing']);

                    // Dispatch job with product, images array, and profile ID
                    ProcessProductJob::dispatch($product, $images, $product->processing_profile_id);

                    $processed++;
                    Log::info("BatchProcessingService: Dispatched job for product {$product->id}");
                } catch (\Exception $e) {
                    Log::error("BatchProcessingService: Error processing product {$product->id}", [
                        'error' => $e->getMessage(),
                    ]);
                    $product->update(['status' => 'failed']);
                }
            }

            Log::info("BatchProcessingService: Batch complete - {$processed} processed, {$skipped} skipped");
        } catch (\Exception $e) {
            Log::error("BatchProcessingService: Critical error", [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
