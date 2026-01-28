<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    /**
     * Relacionamento com Unidade
     */
    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }

    /**
     * Relacionamento com Especialidades (Muitos para Muitos)
     */
    public function especialidades(): BelongsToMany
    {
        return $this->belongsToMany(Especialidade::class, 'desbravador_especialidade')
            ->withPivot('data_conclusao')
            ->withTimestamps();
    }

    /**
     * Relacionamento com Frequências (Um para Muitos)
     */
    public function frequencias(): HasMany
    {
        return $this->hasMany(Frequencia::class);
    }

    /**
     * Soma total de pontos do desbravador.
     * * CORREÇÃO: Usamos $this->frequencias (que já é uma Collection) diretamente para somar.
     */
    public function getTotalPontosAttribute()
    {
        return $this->frequencias->sum(function ($frequencia) {
            return $frequencia->pontos;
        });
    }
}
