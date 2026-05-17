<?php

namespace App\Console\Commands;

use App\Jobs\ProcessProductJob;
use App\Models\Product;
use Illuminate\Console\Command;

class ProcessPendingProductsCommand extends Command
{
    protected $signature = 'products:process-pending {--limit=0 : Maximum number of products to process (0 = all)}';

    protected $description = 'Process all pending products (simulates scheduler for testing)';

    public function handle(): int
    {
        $query = Product::where('status', 'pending');
        $limit = $this->option('limit');

        if ($limit > 0) {
            $query->limit($limit);
        }

        $pendingProducts = $query->get();

        if ($pendingProducts->isEmpty()) {
            $this->info('No pending products found.');
            return self::SUCCESS;
        }

        $this->info("Found {$pendingProducts->count()} pending product(s)");
        $this->line('---');

        $processed = 0;
        $failed = 0;

        foreach ($pendingProducts as $product) {
            $images = $product->images()->get();

            if ($images->isEmpty()) {
                $this->warn("Skipping {$product->name} (ID: {$product->id}) - no images");
                $failed++;
                continue;
            }

            try {
                $this->info("Processing: {$product->name} (ID: {$product->id})");

                // Update status to processing
                $product->update(['status' => 'processing']);

                // Dispatch the job
                ProcessProductJob::dispatch($product, $images->toArray(), $product->processing_profile_id);

                $this->line("  ✓ Job dispatched");
                $processed++;
            } catch (\Exception $e) {
                $this->error("  ✗ Error: {$e->getMessage()}");
                $product->update(['status' => 'failed']);
                $failed++;
            }
        }

        $this->line('---');
        $this->info("Summary: {$processed} processed, {$failed} failed");
        $this->line("Run queue worker: php artisan queue:listen");

        return self::SUCCESS;
    }
}
