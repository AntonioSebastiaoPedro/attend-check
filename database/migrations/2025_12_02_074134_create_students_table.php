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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do estudante
            $table->string('registration_number')->unique(); // Número de matrícula (único)
            $table->string('email')->nullable(); // Email para contato
            $table->string('phone')->nullable(); // Telefone para contato
            $table->date('birth_date')->nullable(); // Data de nascimento
            $table->text('address')->nullable(); // Endereço
            $table->boolean('active')->default(true); // Status ativo/inativo
            $table->timestamps();
            $table->softDeletes(); // Soft delete para manter histórico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
