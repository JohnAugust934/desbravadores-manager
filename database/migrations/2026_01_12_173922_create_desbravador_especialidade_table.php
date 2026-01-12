<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('desbravador_especialidade', function (Blueprint $table) {
            $table->id();
            // Chaves estrangeiras
            $table->foreignId('desbravador_id')->constrained('desbravadores')->onDelete('cascade');
            $table->foreignId('especialidade_id')->constrained('especialidades')->onDelete('cascade');

            // Dados extras desse relacionamento
            $table->date('data_conclusao');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desbravador_especialidade');
    }
};
