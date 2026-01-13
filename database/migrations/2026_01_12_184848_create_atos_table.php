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
            $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade'); // <--- NOVO
            $table->date('data');
            $table->string('tipo');
            $table->string('descricao_resumida');
            $table->text('texto_completo')->nullable();
            $table->foreignId('desbravador_id')->nullable()->constrained('desbravadores')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atos');
    }
};
