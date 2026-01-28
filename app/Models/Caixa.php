<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'valor',
        'tipo',
        'data_movimentacao', // Nome correto da coluna
        'categoria',
    ];

    protected $casts = [
        'data_movimentacao' => 'date',
        'valor' => 'decimal:2',
    ];
}
