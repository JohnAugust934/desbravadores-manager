<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Desbravador extends Model
{
    use HasFactory;

    protected $table = 'desbravadores';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'sexo',
        'unidade_id',
        'classe_atual',
        'ativo',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'ativo' => 'boolean',
    ];

    // Relacionamento: Um desbravador pertence a uma Unidade
    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }
}
