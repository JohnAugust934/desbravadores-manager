<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Club; // <--- Importação necessária

class CaixaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'club_id' => Club::factory(),
            'descricao' => $this->faker->sentence(3),
            'valor' => $this->faker->randomFloat(2, 10, 500),
            'tipo' => $this->faker->randomElement(['entrada', 'saida']),
            'data_movimentacao' => $this->faker->date(),
            'categoria' => $this->faker->word(),
        ];
    }
}
