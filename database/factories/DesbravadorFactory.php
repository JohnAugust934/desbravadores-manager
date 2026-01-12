<?php

namespace Database\Factories;

use App\Models\Unidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class DesbravadorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'data_nascimento' => $this->faker->date(),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'classe_atual' => $this->faker->randomElement(['Amigo', 'Companheiro', 'Pesquisador']),
            'ativo' => true,
            'unidade_id' => Unidade::factory(), // Cria uma unidade automaticamente se não passar uma
        ];
    }
}
