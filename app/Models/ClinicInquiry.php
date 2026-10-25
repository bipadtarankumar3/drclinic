<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'ip_address',
        'status',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
