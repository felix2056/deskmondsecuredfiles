<?php

namespace App\Models\Tenant;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class User extends Authenticatable
{
    use Notifiable, UsesTenantConnection;

    protected $primaryKey = 'id';
    protected $guard = 'tenant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'role_type', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role_id', 'role_type'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role ()
    {
      return $this->morphTo(__FUNCTION__, 'role_type', 'role_id');
    }
}
