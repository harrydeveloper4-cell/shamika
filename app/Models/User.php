<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Inspection;
use App\Models\MonitoringRequest;
use App\Models\Verification;
use App\Models\Payout;
use App\Models\Payment;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the properties owned by the user.
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'user_id');
    }

    /**
     * Get the bookings made by the renter.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'renter_id');
    }

    /**
     * Get the inspections assigned to the property management team member.
     */
    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class, 'inspector_id');
    }

    /**
     * Get the monitoring requests submitted by the vendor.
     */
    public function monitoringRequestsAsVendor(): HasMany
    {
        return $this->hasMany(MonitoringRequest::class, 'vendor_id');
    }

    /**
     * Get the monitoring requests reviewed/assigned by the admin.
     */
    public function monitoringRequestsAsAdmin(): HasMany
    {
        return $this->hasMany(MonitoringRequest::class, 'admin_id');
    }

    /**
     * Get the verifications made by the admin.
     */
    public function verifications(): HasMany
    {
        return $this->hasMany(Verification::class, 'admin_id');
    }

    /**
     * Get the payouts for the vendor.
     */
    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class, 'vendor_id');
    }

    /**
     * Get the payments made by the renter.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'renter_id');
    }
}