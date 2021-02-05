<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\TenantModel;

class Student extends TenantModel
{
    protected $fillable = [
      'user_id'
    ];

    protected $appends = ['full_name'];

    public function user ()
    {
      return $this->morphOne('App\Models\Tenant\User', 'role');
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'student_classes')->withTimestamps();
    }

    public function getFullNameAttribute()
    {
      return $this->firstName . ' ' . $this->lastName;
    }
}
