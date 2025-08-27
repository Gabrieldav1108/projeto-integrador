<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'numberClass',
    ];

    public function informations()
    {
        return $this->hasMany(ClassInformation::class, 'class_id');
    }
}
