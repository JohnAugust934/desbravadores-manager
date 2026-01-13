<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToClub;

class Mensalidade extends Model
{
    use HasFactory, BelongsToClub;

    protected $fillable = [
        'desbravador_id',
        'mes',
        'ano',
        'valor',
        'data_pagamento',
        'status',
        'club_id'
    ];

    protected $casts = [
        'data_pagamento' => 'date',
    ];

    public function desbravador(): BelongsTo
    {
        return $this->belongsTo(Desbravador::class);
    }
}
