<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToClub;

class Ato extends Model
{
    use HasFactory, BelongsToClub;

    protected $fillable = [
        'data',
        'tipo',
        'descricao_resumida',
        'texto_completo',
        'desbravador_id',
        'club_id'
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public function desbravador(): BelongsTo
    {
        return $this->belongsTo(Desbravador::class);
    }
}
