<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClub;

class Caixa extends Model
{
    use HasFactory, BelongsToClub;

    protected $fillable = [
        'descricao',
        'valor',
        'tipo',
        'data_movimentacao',
        'categoria',
        'club_id'
    ];

    protected $casts = [
        'data_movimentacao' => 'date',
        'valor' => 'decimal:2'
    ];
}
