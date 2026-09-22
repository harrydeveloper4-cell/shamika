<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Inspection;
use App\Models\Verification;
use App\Models\Booking;
use App\Models\MonitoringRequest;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'main_image',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'type',
        'purpose',
        'inspection_status',
        'verification_status',
        'owner_type',
        'is_verified',
        'published_at',
        'archived_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(Verification::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function monitoringRequests(): HasMany
    {
        return $this->hasMany(MonitoringRequest::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function getMainImageUrlAttribute(): ?string
    {
        if ($this->main_image) {
            // return Storage::disk('public')->url($this->main_image);
            return asset($this->main_image);
        }
        return null;
    }
}
