<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'ai_raw_response',
        'processing_profile_id',
        'status'
    ];

    protected $casts = [
        'ai_raw_response' => 'array', // Automatically handles JSON serialization
        'status' => 'string',
    ];

    /**
     * Relationship to the user who owns the product.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to the user who owns the product.
     */
    public function processProfile(): BelongsTo {
        return $this->belongsTo(ProcessingProfile::class);
    }

    /**
     * Get all of the images for the product.
     */
    public function images(): HasMany {
        return $this->hasMany(ProductImage::class);
    }
}
