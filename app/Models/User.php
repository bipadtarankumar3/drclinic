<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function employee()
    {
        // A User has one Employee
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function clinic()
    {
        return $this->hasOne(Clinic::class, 'user_id');
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->user_type, ['admin', 'super_admin']);
    }

    public function isDoctor(): bool
    {
        return $this->user_type === 'doctor' || ($this->clinic()->exists() && !$this->isSuperAdmin());
    }

    public function isStaff(): bool
    {
        return in_array($this->user_type, ['office_employee', 'field_employee', 'sales_employee', 'transport_employee', 'staff', 'employee']);
    }
}
