<?php

use App\Models\Mensalidade;
use App\Models\Desbravador;
use App\Models\User;

test('pode gerar mensalidades para todos os ativos', function () {
    $user = User::factory()->create();
    // Cria 3 desbravadores ativos e 1 inativo
    Desbravador::factory()->count(3)->create(['ativo' => true]);
    Desbravador::factory()->create(['ativo' => false]);

    $response = $this->actingAs($user)->post(route('mensalidades.gerar'), [
        'mes' => 5,
        'ano' => 2024,
        'valor' => 20.00
    ]);

    $response->assertSessionHas('success');
    // Deve ter gerado apenas 3 (para os ativos)
    expect(Mensalidade::count())->toBe(3);
    $this->assertDatabaseHas('mensalidades', ['valor' => 20.00, 'mes' => 5]);
});

test('pagar mensalidade muda status e lanca no caixa', function () {
    $user = User::factory()->create();
    $mensalidade = Mensalidade::factory()->create(['status' => 'pendente', 'valor' => 50.00]);

    $response = $this->actingAs($user)->post(route('mensalidades.pagar', $mensalidade->id));

    $response->assertSessionHas('success');

    // Verifica se atualizou a mensalidade
    $mensalidade->refresh();
    expect($mensalidade->status)->toBe('pago');
    expect($mensalidade->data_pagamento)->not->toBeNull();

    // Verifica se criou no CAIXA
    $this->assertDatabaseHas('caixas', [
        'valor' => 50.00,
        'tipo' => 'entrada',
        'categoria' => 'Mensalidade'
    ]);
});
