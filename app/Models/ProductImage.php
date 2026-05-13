<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model {
    use HasFactory;

    protected $fillable = [
        'product_id',
        'original_path',
        'processed_path',
        'is_main'
    ];

    /**
     * Inverse relationship back to the Product parent.
     */
    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor to easily get the full HTTP public URL for the original image.
     */
    public function getOriginalUrlAttribute(): string {
        return Storage::disk('public')->url($this->original_path);
    }

    /**
     * Accessor to easily get the full HTTP public URL for the processed image.
     */
    public function getProcessedUrlAttribute(): ?string {
        return $this->processed_path ? Storage::disk('public')->url($this->processed_path) : null;
    }
}
