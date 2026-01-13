<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\BelongsToClub; // <--- Importar

class Unidade extends Model
{
    use HasFactory, BelongsToClub; // <--- Usar

    protected $fillable = ['nome', 'conselheiro', 'grito_guerra', 'club_id'];

    public function desbravadores(): HasMany
    {
        return $this->hasMany(Desbravador::class);
    }
}
