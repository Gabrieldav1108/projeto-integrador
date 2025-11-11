<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'subject_id');
    }
    public function getMainTeacherAttribute()
    {
        return $this->teachers->first();
    }
    public function getHasTeachersAttribute()
    {
        return $this->teachers->count() > 0;
    }

    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_subject', 'subject_id', 'class_id');
    }

    public function classInformations(): HasMany
    {
        return $this->hasMany(ClassInformation::class);
    }
    
}