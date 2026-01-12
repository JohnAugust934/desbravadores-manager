<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensalidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desbravador_id')->constrained('desbravadores')->onDelete('cascade');
            $table->integer('mes'); // 1 a 12
            $table->integer('ano'); // 2024, 2025...
            $table->decimal('valor', 10, 2);
            $table->date('data_pagamento')->nullable();
            $table->string('status')->default('pendente'); // pendente, pago
            $table->timestamps();

            // Evita duplicidade: O mesmo desbravador não pode ter 2 boletos pro mesmo mês/ano
            $table->unique(['desbravador_id', 'mes', 'ano']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensalidades');
    }
};
