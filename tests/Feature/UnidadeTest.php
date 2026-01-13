<?php

use App\Models\Unidade;
use App\Models\User;

test('apenas usuarios logados podem ver unidades', function () {
    $response = $this->get('/unidades');
    $response->assertRedirect('/login');
});

test('usuario logado pode ver lista de unidades', function () {
    $user = User::factory()->create();

    // Cria unidades para o clube deste usuário
    Unidade::factory()->count(3)->create(['club_id' => $user->club_id]);

    // Cria unidade para outro clube (não deve aparecer, mas não quebra o teste de status 200)
    Unidade::factory()->create();

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

    $response->assertRedirect(route('unidades.index'));

    $this->assertDatabaseHas('unidades', [
        'nome' => 'Unidade Teste Águia',
        'club_id' => $user->club_id // Garante que salvou para o clube certo
    ]);
});
