<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'verification_token',
        'role',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'avatar',
        'is_active',
        'last_login',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
        'email_verified_at',
        'create_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'role' => 'string',
    ];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
