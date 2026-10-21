<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'annual_price' => 'decimal:2',
        'is_active' => 'boolean',
        'features' => 'array',
        'max_staff' => 'integer',
        'max_bookings' => 'integer',
        'storage_quota_mb' => 'integer',
    ];

    public function subscriptions()
    {
        return $this->hasMany(ClinicSubscription::class, 'plan_id');
    }

    public function clinics()
    {
        return $this->hasManyThrough(Clinic::class, ClinicSubscription::class, 'plan_id', 'id', 'id', 'clinic_id');
    }
}
