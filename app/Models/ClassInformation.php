<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassInformation extends Model
{
    use HasFactory;
    protected $table = 'class_information';
    
    protected $fillable = [
        'class_id',
        'subject_id',
        'content',
        'date',
        'time',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function scopeExpired($query)
    {
        return $query->where(function($q) {
            $q->whereNotNull('date')
              ->where('date', '<', Carbon::today()->toDateString());
        })->orWhere(function($q) {
            $q->whereNotNull('date')
              ->whereNotNull('time')
              ->where('date', '=', Carbon::today()->toDateString())
              ->where('time', '<=', Carbon::now()->format('H:i:s'));
        });
    }

    /**
     * Scope para buscar avisos ativos (não expirados)
     */
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            // Avisos sem data são sempre ativos
            $q->whereNull('date');
        })->orWhere(function($q) {
            // Avisos com data futura
            $q->whereNotNull('date')
              ->where('date', '>', Carbon::today()->toDateString());
        })->orWhere(function($q) {
            // Avisos com data de hoje mas hora futura
            $q->whereNotNull('date')
              ->whereNotNull('time')
              ->where('date', '=', Carbon::today()->toDateString())
              ->where('time', '>', Carbon::now()->format('H:i:s'));
        })->orWhere(function($q) {
            // Avisos com data de hoje mas sem hora
            $q->whereNotNull('date')
              ->whereNull('time')
              ->where('date', '>=', Carbon::today()->toDateString());
        });
    }

    /**
     * Verifica se o aviso está expirado
     */
    public function isExpired(): bool
    {
        if (is_null($this->date)) {
            return false; // Avisos sem data nunca expiram
        }

        $today = Carbon::today();
        $now = Carbon::now();

        if ($this->date->lt($today)) {
            return true; // Data já passou
        }

        if ($this->date->eq($today) && $this->time) {
            $expirationTime = Carbon::createFromTimeString($this->time);
            return $now->gte($expirationTime); // Hora já passou hoje
        }

        return false;
    }
}
