<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\TenantModel;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Classes extends TenantModel implements HasMedia
{
    use HasFactory, HasMediaTrait;

    protected $fillable=[
        'teacher_id',
        'subject_id',
        'gradeLevel_id',
        'title',
        'instruction',
        'image',
        'content',
        'status',
        'startDate',
        'submissionDate',
        'videoLink',
    ];

    public function subject()
    {
        return $this->belongsTo(Keywords::class, 'subject_id', 'id');
    }

    public function gradeLevel()
    {
        return $this->belongsTo(Keywords::class, 'gradeLevel_id')->withDefaults();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_classes')->withTimestamps();
    }

    public function marking()
    {
        return $this->hasMany(StudentAnswer::class, 'class_id')->where('markValue',null);
    }
}
