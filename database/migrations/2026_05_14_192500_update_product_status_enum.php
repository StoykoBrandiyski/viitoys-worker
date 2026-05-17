<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            // For MySQL, modify the enum to include 'processing'
            $table->enum('status', ['pending', 'processing', 'processed', 'failed'])
                ->default('pending')
                ->change();
        });
    }

    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            // Revert to original enum values
            $table->enum('status', ['pending', 'processed', 'failed'])
                ->default('pending')
                ->change();
        });
    }
};
