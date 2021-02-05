<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\TenantModel;

class StudentClasses extends TenantModel
{
    //
    protected $fillable = [
        'student_id',
        'class_id',
    ];

    public function getClass()
    {
        //this method will get the linked class object
        return $this->belongsTo(Classes::class, 'class_id')->with('subject')->withDefault();
    }

    public function gClass()
    {
        //this method will try to retrieve both subject and class
        return $this->belongsTo(Classes::class, 'class_id')->with('subject')->withDefault();

    }

    
}
