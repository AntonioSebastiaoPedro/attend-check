<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    use SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'code',
        'description',
        'teacher_id',
        'academic_year',
        'semester',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'academic_year' => 'integer',
    ];

    /**
     * Relacionamento: Turma pertence a um professor (User)
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Relacionamento: Turma tem muitos estudantes
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'class_student')
            ->withTimestamps()
            ->withPivot('enrolled_at');
    }

    /**
     * Relacionamento: Turma tem muitas presenças
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    /**
     * Scope: Apenas turmas ativas
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope: Turmas de um professor específico
     */
    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }
}

