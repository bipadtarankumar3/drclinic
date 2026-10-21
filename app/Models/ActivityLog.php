<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    /**
     * Helper to log an activity
     */
    public static function log($action, $description = null, $clinicId = null, $userId = null)
    {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'clinic_id' => $clinicId ?? (auth()->user()?->clinic?->id ?? null),
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => substr(request()->userAgent() ?? '', 0, 500),
        ]);
    }
}
