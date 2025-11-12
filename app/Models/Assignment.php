<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
        'title',
        'description',
        'due_date',
        'due_time',
        'max_points',
        'is_active'
    ];

    protected $casts = [
        'due_date' => 'date',
        'max_points' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    protected $appends = [
        'is_expired',
    ];

    /**
     * Relacionamento com a turma
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Relacionamento com a matéria
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Relacionamento com o professor
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relacionamento com as entregas
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    /**
     * Acessor para verificar se está expirado
     */
    public function getIsExpiredAttribute(): bool
    {
        $dueDateTime = $this->due_date->format('Y-m-d');
        
        if ($this->due_time) {
            $dueDateTime .= ' ' . $this->due_time;
            return now()->greaterThan($dueDateTime);
        }
        
        // Se não tem horário, considera até o final do dia
        return now()->greaterThan($this->due_date->endOfDay());
    }

    /**
     * Conta quantos alunos entregaram
     */
    public function getSubmissionsCountAttribute(): int
    {
        return $this->submissions()->count();
    }

    /**
     * Verifica se um aluno específico já entregou este trabalho
     * 
     * @param int $studentId ID do estudante
     * @return bool
     */
    public function hasStudentSubmission(int $studentId): bool
    {
        return $this->submissions()->where('student_id', $studentId)->exists();
    }

    /**
     * Obtém a entrega de um aluno específico
     * 
     * @param int $studentId ID do estudante
     * @return AssignmentSubmission|null
     */
    public function getStudentSubmission(int $studentId): ?AssignmentSubmission
    {
        return $this->submissions()->where('student_id', $studentId)->first();
    }

    /**
     * Escopo para trabalhos ativos
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Escopo para trabalhos não expirados
     */
    public function scopeNotExpired(Builder $query): Builder
    {
        return $query->where(function(Builder $query) {
            $query->where('due_date', '>', now()->format('Y-m-d'))
                  ->orWhere(function(Builder $query) {
                      $query->where('due_date', '=', now()->format('Y-m-d'))
                            ->where('due_time', '>', now()->format('H:i:s'));
                  });
        });
    }
}