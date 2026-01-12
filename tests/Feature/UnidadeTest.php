<?php

use App\Models\Unidade;
use App\Models\User;

test('apenas usuarios logados podem ver unidades', function () {
    $response = $this->get('/unidades');
    $response->assertRedirect('/login');
});

test('usuario logado pode ver lista de unidades', function () {
    $user = User::factory()->create();

    // Cria 3 unidades no banco de teste
    Unidade::factory()->count(3)->create();

    $response = $this->actingAs($user)->get('/unidades');

    $response->assertStatus(200);
});

test('pode criar uma nova unidade', function () {
    $user = User::factory()->create();

    $dados = [
        'nome' => 'Unidade Teste Águia',
        'conselheiro' => 'Diretor Teste',
    ];

    $response = $this->actingAs($user)->post('/unidades', $dados);

    // Deve redirecionar após salvar
    $response->assertRedirect(route('unidades.index'));

    // Verifica se salvou no banco
    $this->assertDatabaseHas('unidades', [
        'nome' => 'Unidade Teste Águia'
    ]);
});
