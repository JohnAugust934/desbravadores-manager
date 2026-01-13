<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClubFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => 'Clube ' . $this->faker->company(),
            'cidade' => $this->faker->city(),
            'ativo' => true,
        ];
    }
}
