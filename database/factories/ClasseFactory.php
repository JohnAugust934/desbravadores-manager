<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClasseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->randomElement([
                'Amigo', 'Companheiro', 'Pesquisador', 'Pioneiro', 'Excursionista', 'Guia',
            ]),
            'cor' => $this->faker->hexColor(),
            'ordem' => $this->faker->unique()->numberBetween(1, 10),
        ];
    }
}
