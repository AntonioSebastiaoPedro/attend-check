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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome da turma/sala
            $table->string('code')->unique(); // Código único da turma
            $table->text('description')->nullable(); // Descrição da turma
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null'); // Professor responsável
            $table->integer('academic_year')->nullable(); // Ano letivo
            $table->enum('semester', ['1', '2'])->nullable(); // Semestre
            $table->boolean('active')->default(true); // Status ativo/inativo
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
