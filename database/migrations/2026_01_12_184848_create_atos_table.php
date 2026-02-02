<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atos', function (Blueprint $table) {
            $table->id();
            $table->string('numero'); // Adicionado (Ex: 001/2026)
            $table->date('data');
            $table->string('tipo'); // Nomeação, Exoneração...

            // Alterado de 'descricao_resumida' para 'descricao' para bater com o formulário
            // Mudamos para text para caber textos maiores
            $table->text('descricao');

            $table->foreignId('desbravador_id')->nullable()->constrained('desbravadores')->nullOnDelete();
            $table->timestamps();
        });
    }
};
