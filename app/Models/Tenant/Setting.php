<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Hyn\Tenancy\Abstracts\TenantModel;

class Setting extends TenantModel
{
    use HasFactory;
}
