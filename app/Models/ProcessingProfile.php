<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcessingProfile extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'width',
        'height',
        'watermark_path',
        'is_watermark_enabled',
    ];

    protected $casts = [
        'is_watermark_enabled' => 'boolean',
        'width' => 'integer',
        'height' => 'integer',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
