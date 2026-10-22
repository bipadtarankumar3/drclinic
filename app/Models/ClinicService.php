<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicService extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'title',
        'description',
        'icon',
        'image',
        'price',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'price' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    /**
     * Get clean FontAwesome icon class
     */
    public function getIconClassAttribute()
    {
        $icon = trim($this->icon ?: 'fa-stethoscope');
        if (!str_starts_with($icon, 'fa-')) {
            $icon = 'fa-' . $icon;
        }
        return 'fa-solid ' . $icon;
    }
}
