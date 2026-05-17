<?php

namespace App\Console\Commands;

use App\Models\AiEngine;
use HosseinHezami\LaravelGemini\Facades\Gemini;
use Illuminate\Console\Command;

class TestGeminiCommand extends Command
{
    protected $signature = 'gemini:test {--engine-id=1 : The AI Engine ID to test}';

    protected $description = 'Test Gemini API connection with an AI Engine';

    public function handle(): int
    {
        $engineId = $this->option('engine-id');

        $engine = AiEngine::find($engineId);

        if (!$engine) {
            $this->error("AI Engine with ID {$engineId} not found.");
            return self::FAILURE;
        }

        $this->info("Testing Gemini API connection...");
        $this->line("Engine: {$engine->model_name}");
        $this->line("API Key: " . (strlen($engine->api_key) > 20 ? substr($engine->api_key, 0, 10) . '...' : '***'));
        $this->line("Status: " . ($engine->is_active ? 'Active' : 'Inactive'));
        $this->line('---');

        if (!$engine->is_active) {
            $this->warn("⚠ Engine is not active!");
            return self::FAILURE;
        }

        try {
            $this->info("Sending test request to Gemini API...");

            // Correct API chain: setApiKey -> text() -> model() -> prompt() -> generate()
            $response = Gemini::setApiKey($engine->api_key)
                ->text()
                ->model($engine->model_name)
                ->prompt('Say hello and confirm you are working correctly.')
                ->generate();

            if (!$response) {
                $this->error("✗ API returned null response");
                return self::FAILURE;
            }

            $content = $response->content();

            $this->info("✓ Connection successful!");
            $this->line('---');
            $this->line("Response preview:");
            $this->line(substr($content, 0, 200) . (strlen($content) > 200 ? '...' : ''));

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("✗ Connection failed!");
            $this->error("Error: " . $e->getMessage());
            $this->error("Exception: " . get_class($e));

            if (method_exists($e, 'getResponse')) {
                $response = $e->getResponse();
                if ($response) {
                    $this->error("Response body: " . $response->getBody());
                }
            }

            return self::FAILURE;
        }
    }
}
