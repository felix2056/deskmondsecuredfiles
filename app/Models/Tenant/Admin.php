<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\TenantModel;

class Admin extends TenantModel
{
    protected $fillable = [
      'user_id', 'super_admin'
    ];

    public function user ()
    {
      return $this->morphOne('App\Models\Tenant\User', 'role');
    }
}
