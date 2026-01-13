<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patrimonios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade'); // <--- NOVO
            $table->string('item');
            $table->integer('quantidade')->default(1);
            $table->decimal('valor_estimado', 10, 2)->nullable();
            $table->date('data_aquisicao')->nullable();
            $table->string('estado_conservacao');
            $table->string('local_armazenamento')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patrimonios');
    }
};
