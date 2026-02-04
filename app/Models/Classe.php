<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cor', 'ordem'];

    // Uma classe tem muitos requisitos
    public function requisitos()
    {
        return $this->hasMany(Requisito::class);
    }

    // Ajudante para pegar o progresso geral da classe
    public function totalRequisitos()
    {
        return $this->requisitos()->count();
    }
}
