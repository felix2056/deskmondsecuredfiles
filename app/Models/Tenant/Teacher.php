<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\TenantModel;

use App\Models\Tenant\Classes;

class Teacher extends TenantModel
{
    protected $fillable = [
      'name',
      'email',
      'user_id'
    ];

    protected $appends = ['avatar_url'];

    public function user ()
    {
      return $this->morphOne('App\Models\Tenant\User', 'role');
    }

    public function classes()
    {
      return $this->hasMany(Classes::class);
    }

    public function getAvatarUrlAttribute()
    {
      $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();

      if ($this->avatar == null) {
        return '/images/blank-avatar.png';
      }
      else{
        return '/storage/tenants/' . $hostname->fqdn . '/avatars/' . $this->avatar;
      }
    }
}
