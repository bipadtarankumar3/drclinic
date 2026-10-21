<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Clinic extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'razorpay_enabled' => 'boolean',
        'allow_cash_booking' => 'boolean',
        'consultation_fee' => 'decimal:2',
        'trial_ends_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(ClinicSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(ClinicSubscription::class)
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->latestOfMany();
    }

    public function pages()
    {
        return $this->hasMany(ClinicPage::class)->orderBy('sort_order', 'asc');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    public function settings()
    {
        return $this->hasOne(Setting::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Check if the clinic's plan or trial is currently active
     */
    public function isPlanActive(): bool
    {
        // 1. If manually marked suspended/inactive
        if ($this->status === 'suspended') {
            return false;
        }

        // 2. Check active paid subscription
        $activeSub = $this->activeSubscription;
        if ($activeSub) {
            return true;
        }

        // 3. Check 7-day trial validity
        if ($this->status === 'trialing' && $this->trial_ends_at && $this->trial_ends_at->isFuture()) {
            return true;
        }

        // 4. If status is explicitly 'active' with future trial_ends_at or no expiration
        if ($this->status === 'active') {
            if (!$this->trial_ends_at || $this->trial_ends_at->isFuture()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Number of trial days remaining
     */
    public function trialDaysRemaining(): int
    {
        if (!$this->trial_ends_at || $this->trial_ends_at->isPast()) {
            return 0;
        }
        return now()->diffInDays($this->trial_ends_at, false) > 0 ? (int) now()->diffInDays($this->trial_ends_at) : 1;
    }
}
