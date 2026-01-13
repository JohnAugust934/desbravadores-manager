<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Club; // <--- Importação necessária

class UnidadeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'club_id' => Club::factory(),
            'nome' => $this->faker->word() . ' ' . $this->faker->city(),
            'conselheiro' => $this->faker->name(),
            'grito_guerra' => $this->faker->sentence(),
        ];
    }
}
