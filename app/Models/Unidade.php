<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unidade extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'conselheiro', 'grito_guerra'];

    // Relacionamento: Uma unidade tem vários desbravadores
    public function desbravadores(): HasMany
    {
        return $this->hasMany(Desbravador::class);
    }
}
