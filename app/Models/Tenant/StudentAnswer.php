<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Abstracts\TenantModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\InteractsWithMedia;

class StudentAnswer extends TenantModel implements HasMedia
{
    use HasFactory, HasMediaTrait;

    protected $fillable=[
        'student_id',
        'class_id',
        'teacher_id',
        'answer',
        'dateAnswer',
        'feedback',
        'dateFeedback',
        'feedbackbyTeacher_id',
        'mark',
        'markValue',
    ];

    public function classx()
    {
        return $this->belongsTo(Classes::class,'class_id')->withDefault();
    }

    public function subject()
    {
        return $this->belongsTo(Keywords::class, 'subject_id')->withDefault();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id')->withDefault();
    }

    public function byTeacher()
    {
        return $this->belongsTo(Teacher::class, 'feedbackByTeacher_id')->withDefault();
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id')->withDefault();
    }
}