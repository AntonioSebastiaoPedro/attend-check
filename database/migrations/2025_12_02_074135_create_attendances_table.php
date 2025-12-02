<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Estudante
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade'); // Turma
            $table->date('date'); // Data da aula/presença
            $table->enum('status', ['present', 'absent']); // Presente ou Ausente
            $table->time('time')->nullable(); // Hora de marcação (RF09)
            $table->text('notes')->nullable(); // Observações opcionais
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null'); // Quem registrou
            $table->timestamps(); // created_at armazena hora exata do registro (RF09)

            // Índice para consultas rápidas por data
            $table->index(['date', 'class_id']);
            // Prevenir duplicatas: um estudante não pode ter dois registros no mesmo dia/turma
            $table->unique(['student_id', 'class_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
