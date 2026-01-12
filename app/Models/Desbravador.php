<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }

    // Relacionamento Novo: Desbravador tem muitas Especialidades
    public function especialidades(): BelongsToMany
    {
        return $this->belongsToMany(Especialidade::class, 'desbravador_especialidade')
            ->withPivot('data_conclusao') // Queremos acessar a data
            ->withTimestamps();
    }
}
