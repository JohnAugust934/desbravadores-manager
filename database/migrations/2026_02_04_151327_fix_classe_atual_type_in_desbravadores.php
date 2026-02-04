<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('desbravadores', function (Blueprint $table) {
            // 1. Remove a coluna antiga que era VARCHAR
            if (Schema::hasColumn('desbravadores', 'classe_atual')) {
                // Removemos a chave estrangeira se existir por engano, para evitar erro
                // $table->dropForeign(['classe_atual']);
                $table->dropColumn('classe_atual');
            }
        });

        Schema::table('desbravadores', function (Blueprint $table) {
            // 2. Recria como Chave Estrangeira (ID numérico) ligada à tabela classes
            $table->foreignId('classe_atual')
                ->nullable()
                ->after('unidade_id')
                ->constrained('classes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('desbravadores', function (Blueprint $table) {
            $table->dropForeign(['classe_atual']);
            $table->dropColumn('classe_atual');
        });

        Schema::table('desbravadores', function (Blueprint $table) {
            $table->string('classe_atual')->nullable();
        });
    }
};
