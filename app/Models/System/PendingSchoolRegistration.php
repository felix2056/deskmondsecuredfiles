<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\SystemModel;

class PendingSchoolRegistration extends SystemModel
{
    protected $fillable = [
      'name',
      'email',
      'school_id'
    ];
}
