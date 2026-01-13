<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Club; // <--- Importação necessária

class AtaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'club_id' => Club::factory(),
            'data_reuniao' => $this->faker->date(),
            'tipo' => $this->faker->randomElement(['Regular', 'Diretoria']),
            'secretario_responsavel' => $this->faker->name(),
            'conteudo' => $this->faker->paragraphs(3, true),
        ];
    }
}
