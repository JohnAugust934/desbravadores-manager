<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClub;

class Ata extends Model
{
    use HasFactory, BelongsToClub;

    protected $fillable = [
        'data_reuniao',
        'tipo',
        'secretario_responsavel',
        'participantes',
        'conteudo',
        'club_id'
    ];

    protected $casts = [
        'data_reuniao' => 'date',
    ];
}
