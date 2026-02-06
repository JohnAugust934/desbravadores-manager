<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unidades', function (Blueprint $table) {
            // Adiciona a coluna club_id referenciando a tabela clubs
            // nullable() é usado caso já existam unidades sem clube, para não dar erro na criação
            if (! Schema::hasColumn('unidades', 'club_id')) {
                $table->foreignId('club_id')->nullable()->constrained('clubs')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('unidades', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropColumn('club_id');
        });
    }
};
