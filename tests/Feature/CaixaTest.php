<?php

use App\Models\Caixa;
use App\Models\User;

test('usuario logado pode ver o caixa', function () {
    $user = User::factory()->create();
    Caixa::factory()->count(3)->create();

    $response = $this->actingAs($user)->get(route('caixa.index'));
    $response->assertStatus(200);
});

test('pode criar uma entrada no caixa', function () {
    $user = User::factory()->create();

    $dados = [
        'descricao' => 'Doação da Igreja',
        'valor' => 150.00,
        'tipo' => 'entrada',
        'data_movimentacao' => '2025-01-01',
        'categoria' => 'Doações'
    ];

    $response = $this->actingAs($user)->post(route('caixa.store'), $dados);

    $response->assertRedirect(route('caixa.index'));
    $this->assertDatabaseHas('caixas', ['descricao' => 'Doação da Igreja', 'valor' => 150.00]);
});
