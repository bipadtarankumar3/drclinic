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
        'extra_features' => 'array',
        'custom_quotas' => 'array',
    ];

    /**
     * Check if clinic is entitled to a specific feature (from Plan OR VIP Extra Grant)
     */
    public function hasFeature(string $featureKey): bool
    {
        // 1. Check VIP extra grants
        if (!empty($this->extra_features) && in_array($featureKey, (array)$this->extra_features)) {
            return true;
        }

        // 2. Check active plan features
        if ($this->activeSubscription && $this->activeSubscription->plan) {
            $planFeatures = (array)($this->activeSubscription->plan->features ?? []);
            if (in_array($featureKey, $planFeatures)) {
                return true;
            }
        } elseif ($this->status === 'trialing' || ($this->status === 'active' && !$this->activeSubscription)) {
            $defaultPlan = SubscriptionPlan::where('slug', 'starter')->orWhere('id', 1)->first();
            if ($defaultPlan && is_array($defaultPlan->features) && in_array($featureKey, $defaultPlan->features)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if feature is granted specifically as VIP override
     */
    public function hasExtraFeature(string $featureKey): bool
    {
        return !empty($this->extra_features) && in_array($featureKey, (array)$this->extra_features);
    }

    /**
     * Get all entitled feature keys (merging plan + VIP grants)
     */
    public function getAllEntitledFeatures(): array
    {
        $features = [];
        if ($this->activeSubscription && $this->activeSubscription->plan) {
            $features = array_merge($features, (array)($this->activeSubscription->plan->features ?? []));
        } elseif ($this->status === 'trialing' || ($this->status === 'active' && !$this->activeSubscription)) {
            $defaultPlan = SubscriptionPlan::where('slug', 'starter')->orWhere('id', 1)->first();
            if ($defaultPlan && is_array($defaultPlan->features)) {
                $features = array_merge($features, $defaultPlan->features);
            }
        }
        if (!empty($this->extra_features)) {
            $features = array_merge($features, (array)$this->extra_features);
        }
        return array_values(array_unique($features));
    }

    /**
     * Get current assigned plan or default Starter plan
     */
    public function getCurrentPlan()
    {
        if ($this->activeSubscription && $this->activeSubscription->plan) {
            return $this->activeSubscription->plan;
        }
        return SubscriptionPlan::where('slug', 'starter')->orWhere('id', 1)->first();
    }

    /**
     * Get effective quota accounting for VIP custom overrides
     */
    public function getEffectiveQuota(string $key, int $default = 0): int
    {
        if (!empty($this->custom_quotas) && isset($this->custom_quotas[$key])) {
            return (int) $this->custom_quotas[$key];
        }

        $plan = $this->getCurrentPlan();
        if ($plan && isset($plan->{$key})) {
            return (int) $plan->{$key};
        }

        return $default;
    }

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

    /**
     * Get fully resolved public URL for clinic logo
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (empty($this->logo)) {
            return null;
        }

        if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        }

        $cleanPath = ltrim($this->logo, '/');
        if (str_starts_with($cleanPath, 'public/')) {
            return \Illuminate\Support\Facades\URL::to($cleanPath);
        }

        return \Illuminate\Support\Facades\URL::to('public/' . $cleanPath);
    }

    /**
     * Get fully resolved public URL for clinic header banner
     */
    public function getBannerUrlAttribute(): ?string
    {
        if (empty($this->banner)) {
            return null;
        }

        if (str_starts_with($this->banner, 'http://') || str_starts_with($this->banner, 'https://')) {
            return $this->banner;
        }

        $cleanPath = ltrim($this->banner, '/');
        if (str_starts_with($cleanPath, 'public/')) {
            return \Illuminate\Support\Facades\URL::to($cleanPath);
        }

        return \Illuminate\Support\Facades\URL::to('public/' . $cleanPath);
    }
}
