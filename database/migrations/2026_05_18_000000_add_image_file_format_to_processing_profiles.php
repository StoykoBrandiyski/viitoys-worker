<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('processing_profiles', function (Blueprint $table) {
            $table->enum('image_file_format', ['png', 'jpg', 'jpeg', 'webp', 'gif'])->default('png')->after('is_watermark_enabled');
        });
    }

    public function down(): void {
        Schema::table('processing_profiles', function (Blueprint $table) {
            $table->dropColumn('image_file_format');
        });
    }
};
