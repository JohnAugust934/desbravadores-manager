<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EspecialidadeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->words(3, true),
            'area' => $this->faker->randomElement(['Natureza', 'Artes', 'Saúde']),
        ];
    }
}
