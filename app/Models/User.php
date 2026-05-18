<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User has many AI Engines
     */
    public function aiSettings(): HasMany
    {
        return $this->hasMany(AiEngine::class);
    }

    /**
     * User has many Products
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * User has many Processing Profiles
     */
    public function processingProfiles(): HasMany
    {
        return $this->hasMany(ProcessingProfile::class);
    }
}
