<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function () {
            // Find products waiting in queue (pending status)
            $waitingProducts = \App\Models\Product::where('status', 'pending')->get();

            foreach ($waitingProducts as $product) {
                // Get all images for this product
                $images = $product->images()->get();

                if ($images->isEmpty()) {
                    // Skip products with no images
                    continue;
                }

                // Update status to 'processing' before dispatching
                $product->update(['status' => 'processing']);

                // Dispatch job with product, images array, and profile ID
                \App\Jobs\ProcessProductJob::dispatch($product, $images, $product->processing_profile_id);
            }
        })
            ->everyTenMinutes()
            ->withoutOverlapping()
            ->name('start_batch_processing');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
