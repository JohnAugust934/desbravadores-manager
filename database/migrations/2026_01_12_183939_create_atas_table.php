<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); // Adicionado (Campo principal do form)
            $table->date('data_reuniao');
            $table->time('hora_inicio'); // Adicionado
            $table->time('hora_fim')->nullable(); // Adicionado
            $table->string('local'); // Adicionado

            // Definimos 'Regular' como padrão para resolver o erro "Not null violation"
            $table->string('tipo')->default('Regular');

            $table->string('secretario_responsavel')->nullable();
            $table->text('participantes')->nullable();
            $table->text('conteudo');
            $table->timestamps();
        });
    }
};
