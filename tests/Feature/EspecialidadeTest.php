<?php

use App\Models\Especialidade;
use App\Models\User;

test('pode criar uma especialidade', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/especialidades', [
        'nome' => 'Fogueiras',
        'area' => 'Estudos da Natureza'
    ]);

    $response->assertRedirect(route('especialidades.index'));

    $this->assertDatabaseHas('especialidades', ['nome' => 'Fogueiras']);
});
