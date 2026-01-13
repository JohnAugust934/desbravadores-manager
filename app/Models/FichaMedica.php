<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToClub;

class FichaMedica extends Model
{
    use HasFactory, BelongsToClub;

    protected $table = 'ficha_medicas';

    protected $fillable = [
        'club_id',
        'desbravador_id',
        'tipo_sanguineo',
        'alergias',
        'medicamentos_continuos',
        'problemas_saude',
        'plano_saude',
        'numero_carteirinha',
        'numero_sus',
        'contato_nome',
        'contato_telefone',
        'contato_parentesco',
    ];

    public function desbravador(): BelongsTo
    {
        return $this->belongsTo(Desbravador::class);
    }
}
