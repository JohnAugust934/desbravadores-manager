<?php

use App\Models\Desbravador;
use App\Models\Especialidade;
use App\Models\Unidade;
use App\Models\User;

test('pode criar um desbravador vinculado a uma unidade', function () {
    $user = User::factory()->create();

    // Cria uma unidade PERTENCENTE ao clube do usuário
    $unidade = Unidade::factory()->create(['club_id' => $user->club_id]);

    $dados = [
        'nome' => 'Joãozinho Desbravador',
        'data_nascimento' => '2010-05-20',
        'sexo' => 'M',
        'unidade_id' => $unidade->id,
        'classe_atual' => 'Amigo',
        // O controller vai pegar o club_id do usuário logado automaticamente
    ];

    $response = $this->actingAs($user)->post('/desbravadores', $dados);

    $response->assertRedirect(route('desbravadores.index'));

    $this->assertDatabaseHas('desbravadores', [
        'nome' => 'Joãozinho Desbravador',
        'unidade_id' => $unidade->id,
        'club_id' => $user->club_id // Verifica se salvou no clube certo
    ]);
});

test('pode adicionar uma especialidade ao desbravador', function () {
    $user = User::factory()->create();

    // O Desbravador TEM que ser do mesmo clube do usuário
    $desbravador = Desbravador::factory()->create(['club_id' => $user->club_id]);
    $especialidade = Especialidade::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('desbravadores.especialidades.store', $desbravador->id), [
            'especialidade_id' => $especialidade->id,
            'data_conclusao' => '2023-10-10'
        ]);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('desbravador_especialidade', [
        'desbravador_id' => $desbravador->id,
        'especialidade_id' => $especialidade->id,
        'data_conclusao' => '2023-10-10'
    ]);
});
