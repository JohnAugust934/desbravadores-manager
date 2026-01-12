<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('caixas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao'); // Ex: Venda de Pizza
            $table->decimal('valor', 10, 2); // Ex: 150.00
            $table->string('tipo'); // 'entrada' ou 'saida'
            $table->date('data_movimentacao');
            $table->string('categoria')->nullable(); // Ex: Cantina, Material, Evento
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caixas');
    }
};
