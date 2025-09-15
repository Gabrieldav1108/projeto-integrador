<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Teacher extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'specialty',
        'phone',
        'hire_date',
        'is_active'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'is_active' => 'boolean'
    ];

}
