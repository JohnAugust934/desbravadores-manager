<?php

namespace Database\Factories;

use App\Models\Desbravador;
use App\Models\Club; // <--- Importação necessária
use Illuminate\Database\Eloquent\Factories\Factory;

class MensalidadeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'club_id' => Club::factory(),
            'desbravador_id' => Desbravador::factory(),
            'mes' => 1,
            'ano' => 2024,
            'valor' => 15.00,
            'status' => 'pendente'
        ];
    }
}
