<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_engines', function (Blueprint $table) {
            $table->id();
            $table->string('model_name');
            $table->foreignId('user_id')->constrained();
            $table->text('api_key');
            $table->text('system_prompt');
            $table->integer('max_timeout')->default(30);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_engines');
    }
};
