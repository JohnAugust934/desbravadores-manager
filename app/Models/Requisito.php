<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{
    use HasFactory;

    protected $fillable = ['classe_id', 'codigo', 'descricao', 'categoria'];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Relação com desbravadores que completaram este requisito
    public function desbravadores()
    {
        return $this->belongsToMany(Desbravador::class, 'desbravador_requisito')
            ->withPivot('user_id', 'data_conclusao')
            ->withTimestamps();
    }
}
