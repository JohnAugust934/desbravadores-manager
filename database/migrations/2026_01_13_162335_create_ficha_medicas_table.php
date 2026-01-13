<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ficha_medicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade');
            $table->foreignId('desbravador_id')->constrained('desbravadores')->onDelete('cascade');

            // Dados Médicos
            $table->string('tipo_sanguineo')->nullable(); // A+, O-, etc.
            $table->text('alergias')->nullable();
            $table->text('medicamentos_continuos')->nullable();
            $table->text('problemas_saude')->nullable(); // Asma, diabetes, etc.

            // Plano e SUS
            $table->string('plano_saude')->nullable();
            $table->string('numero_carteirinha')->nullable();
            $table->string('numero_sus')->nullable();

            // Emergência
            $table->string('contato_nome');
            $table->string('contato_telefone');
            $table->string('contato_parentesco')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ficha_medicas');
    }
};
