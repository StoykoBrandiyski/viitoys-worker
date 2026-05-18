<?php

use App\Services\BatchProcessingService;
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
            // Delegate to service layer for batch processing
            $batchProcessingService = new BatchProcessingService();
            $batchProcessingService->processPendingProducts();
        })
            ->everyTenMinutes()
            ->withoutOverlapping()
            ->name('start_batch_processing');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
