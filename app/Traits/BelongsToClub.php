<?php

namespace App\Traits;

use App\Models\Club;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait BelongsToClub
{
    /**
     * O "boot" da trait é executado quando o Model é inicializado.
     */
    protected static function bootBelongsToClub(): void
    {
        // 1. Adiciona o Escopo Global (Filtro)
        static::addGlobalScope(new TenantScope);

        // 2. Antes de Criar: Preenche o club_id automaticamente
        static::creating(function ($model) {
            // Se o campo já estiver preenchido (ex: em testes/factories), não sobrescreve
            if (isset($model->club_id)) {
                return;
            }

            // Se tem usuário logado, pega o clube dele
            if (Auth::check() && Auth::user()->club_id) {
                $model->club_id = Auth::user()->club_id;
            }
        });
    }

    /**
     * Relacionamento padrão para todos os models que usam essa trait
     */
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
}
