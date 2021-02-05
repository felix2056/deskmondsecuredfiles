<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\TenantModel;

class VideoLink extends TenantModel
{
    //this model is used to store youtube information used in classes
    protected $fillable = [
        'Name',
        'class_id',
        'subject_id',
        'videoTitle',
        'videoLink',
        'videoDesc',
        'videoThumb',
        'videoPreview',
    ];

    
}
