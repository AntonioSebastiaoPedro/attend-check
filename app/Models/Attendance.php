<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'date',
        'status',
        'time',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    /**
     * Relacionamento: Presença pertence a um estudante
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relacionamento: Presença pertence a uma turma
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    /**
     * Relacionamento: Presença registrada por um usuário
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Scope: Presenças de uma data específica
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope: Presenças de uma turma
     */
    public function scopeForClass($query, $classId)
    {
        return $query->where('class_id', $classId);
    }

    /**
     * Scope: Presenças de um estudante
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope: Apenas presenças
     */
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    /**
     * Scope: Apenas ausências
     */
    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }
}

