<?php

use App\Models\Caixa;
use App\Models\User;

test('calcula saldo corretamente', function () {
    $user = User::factory()->create();

    // Cria 2 entradas de 100 e 1 saída de 50
    Caixa::factory()->create(['club_id' => $user->club_id, 'tipo' => 'entrada', 'valor' => 100]);
    Caixa::factory()->create(['club_id' => $user->club_id, 'tipo' => 'entrada', 'valor' => 100]);
    Caixa::factory()->create(['club_id' => $user->club_id, 'tipo' => 'saida', 'valor' => 50]);

    $response = $this->actingAs($user)->get('/caixa');

    $response->assertStatus(200);
    // Verifica se a View recebeu a variável saldo com 150
    $response->assertViewHas('saldo', 150);
});

test('impede lancamento com valor negativo ou zero', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/caixa', [
        'descricao' => 'Teste Negativo',
        'valor' => -50,
        'tipo' => 'entrada',
        'data_movimentacao' => now(),
    ]);

    $response->assertSessionHasErrors('valor');
});

test('seguranca: usuario nao ve caixa de outro clube', function () {
    $user = User::factory()->create();
    $caixaOutroClube = Caixa::factory()->create(); // Cria clube novo

    $response = $this->actingAs($user)->get('/caixa');

    $response->assertDontSee($caixaOutroClube->descricao);
});
