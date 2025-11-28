<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Student extends Model
{
    protected $table = 'student';

    protected $fillable = [
        'name',
        'email',
        'age',
        'birth_date',
        'password',
        'class_id',
        'user_id',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Relacionamento com o usuário. Se existir a coluna `user_id`, usa belongsTo;
     * caso contrário, associa pelo email (`users.email` = `student.email`).
     */
    public function user()
    {
        // Verifica se a coluna user_id existe na tabela student
        try {
            if (Schema::hasColumn($this->getTable(), 'user_id')) {
                return $this->belongsTo(User::class, 'user_id');
            }
        } catch (\Throwable $e) {
            // Em alguns ambientes (ex: durante migrações) Schema pode falhar; cair para associação por email
        }

        return $this->hasOne(User::class, 'email', 'email');
    }
}
