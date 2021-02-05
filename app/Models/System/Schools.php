<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\SystemModel;

class Schools extends SystemModel
{
  protected $fillable = [
    'name',
    'email',
    'fqdn',
    'database',
    'completed_registration'
  ];
}
