<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\TenantModel;

class liveStream extends TenantModel
{
    //
    protected $fillable = [
        'teacher_id',
        'class_id',
        'startDate',
        'startTime',
        'subject_id',
        'notes',
        'status',
        'room_id',
        'room_key',
    ];


    public function subject()
    {
        return $this->belongsTo(Keywords::class, 'subject_id', 'id')->withDefault();
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id')->withDefault();
    }
}
