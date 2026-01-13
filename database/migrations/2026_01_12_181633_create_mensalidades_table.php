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
            $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade'); // <--- NOVO
            $table->foreignId('desbravador_id')->constrained('desbravadores')->onDelete('cascade');
            $table->integer('mes');
            $table->integer('ano');
            $table->decimal('valor', 10, 2);
            $table->date('data_pagamento')->nullable();
            $table->string('status')->default('pendente');
            $table->timestamps();
            $table->unique(['desbravador_id', 'mes', 'ano']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensalidades');
    }
};
