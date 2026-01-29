<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Mensalidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'desbravador_id',
        'mes',
        'ano',
        'valor',
        'status',
        'data_pagamento',
    ];

    protected $casts = [
        'data_pagamento' => 'date',
        'valor' => 'decimal:2',
    ];

    public function desbravador(): BelongsTo
    {
        return $this->belongsTo(Desbravador::class);
    }

    /**
     * Scope: Filtra mensalidades pendentes de meses anteriores ao atual.
     * Útil para cobrar quem está devendo.
     */
    public function scopeInadimplentes($query)
    {
        $now = Carbon::now();

        return $query->where('status', 'pendente')
            ->where(function ($q) use ($now) {
                // Anos anteriores OU (Mesmo ano mas meses anteriores)
                $q->where('ano', '<', $now->year)
                    ->orWhere(function ($sub) use ($now) {
                        $sub->where('ano', '=', $now->year)
                            ->where('mes', '<', $now->month);
                    });
            });
    }
}
