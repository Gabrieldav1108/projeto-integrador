<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'comments',
        'points',
        'feedback',
        'submitted_at'
    ];

    protected $casts = [
        'points' => 'decimal:2',
        'submitted_at' => 'datetime'
    ];

    /**
     * Relacionamento com o trabalho
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Relacionamento com o estudante
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Verifica se foi avaliado
     */
    public function getIsGradedAttribute()
    {
        return !is_null($this->points);
    }

    /**
     * Calcula a porcentagem da nota
     */
    public function getGradePercentageAttribute()
    {
        if (!$this->points || !$this->assignment->max_points) {
            return 0;
        }
        
        return ($this->points / $this->assignment->max_points) * 100;
    }
}