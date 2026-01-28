<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'area',
        'cor_fundo' // <--- ADICIONE ESTA LINHA
    ];
}
