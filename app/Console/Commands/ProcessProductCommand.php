<?php

namespace App\Console\Commands;

use App\Jobs\ProcessProductJob;
use App\Models\Product;
use Illuminate\Console\Command;

class ProcessProductCommand extends Command
{
    protected $signature = 'product:process {productId : The ID of the product to process}';

    protected $description = 'Process a product job manually for testing purposes';

    public function handle(): int
    {
        $productId = $this->argument('productId');

        $product = Product::find($productId);

        if (!$product) {
            $this->error("Product with ID {$productId} not found.");
            return self::FAILURE;
        }

        $images = $product->images()->get();

        if ($images->isEmpty()) {
            $this->error("Product has no images to process.");
            return self::FAILURE;
        }

        $this->info("Processing product: {$product->name}");
        $this->line("Product ID: {$product->id}");
        $this->line("Images: {$images->count()}");
        //$this->line("Processing Profile: {$product->processProfile->name}");
        $this->line('---');

        try {
            // Update status to processing
            $product->update(['status' => 'processing']);
            $this->info("Status changed to: processing");

            // Dispatch the job
            ProcessProductJob::dispatch($product, $images, $product->processing_profile_id);

            $this->info("✓ Job dispatched successfully!");
            $this->line("Check your queue worker or run: php artisan queue:listen");

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error: {$e->getMessage()}");
            $product->update(['status' => 'failed']);
            return self::FAILURE;
        }
    }
}
