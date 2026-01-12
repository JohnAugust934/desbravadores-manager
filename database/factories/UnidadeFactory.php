<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UnidadeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->word() . ' ' . $this->faker->city(),
            'conselheiro' => $this->faker->name(),
            'grito_guerra' => $this->faker->sentence(),
        ];
    }
}
