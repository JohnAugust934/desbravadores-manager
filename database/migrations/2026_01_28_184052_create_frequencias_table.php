<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frequencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desbravador_id')->constrained('desbravadores')->onDelete('cascade'); // Link com a tabela correta
            $table->date('data');

            // Critérios de Pontuação
            $table->boolean('presente')->default(false);
            $table->boolean('pontual')->default(false);
            $table->boolean('biblia')->default(false);
            $table->boolean('uniforme')->default(false);

            $table->timestamps();

            // Garante que um desbravador só tenha um registro por data
            $table->unique(['desbravador_id', 'data']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frequencias');
    }
};
