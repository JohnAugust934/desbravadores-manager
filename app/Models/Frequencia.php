<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frequencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'desbravador_id',
        'data',
        'presente',
        'pontual',
        'biblia',
        'uniforme',
    ];

    protected $casts = [
        'data' => 'date',
        'presente' => 'boolean',
        'pontual' => 'boolean',
        'biblia' => 'boolean',
        'uniforme' => 'boolean',
    ];

    public function desbravador()
    {
        return $this->belongsTo(Desbravador::class);
    }

    // Calcula os pontos deste dia específico
    public function getPontosAttribute()
    {
        $pontos = 0;
        if ($this->presente) $pontos += 10;
        if ($this->pontual) $pontos += 5;
        if ($this->biblia) $pontos += 5;
        if ($this->uniforme) $pontos += 10;

        return $pontos;
    }
}
