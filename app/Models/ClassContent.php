<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'content',
        'type',
        'class_id',
        'subject_id',
        'teacher_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento com a turma
     */
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Relacionamento com a matéria
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Relacionamento com o professor
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Acessor para URL do arquivo
     */
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    /**
     * Acessor para tipo formatado
     */
    public function getTypeFormattedAttribute()
    {
        return match($this->type) {
            'pdf' => 'PDF',
            'text' => 'Texto',
            'video' => 'Vídeo',
            'link' => 'Link',
            default => ucfirst($this->type)
        };
    }

    /**
     * Verificar se tem arquivo
     */
    public function hasFile()
    {
        return !empty($this->file_path);
    }

    /**
     * Verificar se tem conteúdo textual
     */
    public function hasContent()
    {
        return !empty($this->content);
    }
}