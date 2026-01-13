<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Club; // <--- Importação necessária

class AtoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'club_id' => Club::factory(),
            'data' => $this->faker->date(),
            'tipo' => $this->faker->randomElement(['Nomeação', 'Disciplina']),
            'descricao_resumida' => $this->faker->sentence(),
        ];
    }
}
