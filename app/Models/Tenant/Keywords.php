<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\TenantModel;

class Keywords extends TenantModel
{
    protected $fillable=[
        'filter',
        'title',
        'description',
        'count',
        'amount',
        'dateTime',
    ];

    public function classes()
    {
        return $this->hasMany(Classes::class);
    }
    
}
