<?php

use App\Models\Desbravador;
use App\Models\Especialidade;
use App\Models\Unidade;
use App\Models\User;

test('pode criar um desbravador vinculado a uma unidade', function () {
    $user = User::factory()->create();
    $unidade = Unidade::factory()->create();

    $dados = [
        'nome' => 'Joãozinho Desbravador',
        'data_nascimento' => '2010-05-20',
        'sexo' => 'M',
        'unidade_id' => $unidade->id,
        'classe_atual' => 'Amigo',
    ];

    $response = $this->actingAs($user)->post('/desbravadores', $dados);

    $response->assertRedirect(route('desbravadores.index'));

    $this->assertDatabaseHas('desbravadores', [
        'nome' => 'Joãozinho Desbravador',
        'unidade_id' => $unidade->id
    ]);
});

test('pode adicionar uma especialidade ao desbravador', function () {
    $user = User::factory()->create();
    $desbravador = Desbravador::factory()->create();
    $especialidade = Especialidade::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('desbravadores.especialidades.store', $desbravador->id), [
            'especialidade_id' => $especialidade->id,
            'data_conclusao' => '2023-10-10'
        ]);

    $response->assertSessionHasNoErrors();

    // Verifica na tabela pivot (ligação)
    $this->assertDatabaseHas('desbravador_especialidade', [
        'desbravador_id' => $desbravador->id,
        'especialidade_id' => $especialidade->id,
        'data_conclusao' => '2023-10-10'
    ]);
});
