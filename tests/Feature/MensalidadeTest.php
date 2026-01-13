<?php

use App\Models\Mensalidade;
use App\Models\Desbravador;
use App\Models\User;

test('pode gerar mensalidades para todos os ativos', function () {
    $user = User::factory()->create();

    // Cria desbravadores DO MESMO CLUBE do usuário
    Desbravador::factory()->count(3)->create([
        'ativo' => true,
        'club_id' => $user->club_id
    ]);

    // Cria um inativo (não deve gerar para este)
    Desbravador::factory()->create([
        'ativo' => false,
        'club_id' => $user->club_id
    ]);

    // Cria um de OUTRO clube (não deve gerar para este, pois o user não vê)
    Desbravador::factory()->create(['ativo' => true]);

    $response = $this->actingAs($user)->post(route('mensalidades.gerar'), [
        'mes' => 5,
        'ano' => 2024,
        'valor' => 20.00
    ]);

    $response->assertSessionHas('success');

    // Deve ter gerado apenas 3 (apenas os ativos do clube do usuario)
    // O scope global já filtra o Mensalidade::count()
    expect(Mensalidade::count())->toBe(3);

    $this->assertDatabaseHas('mensalidades', [
        'valor' => 20.00,
        'mes' => 5,
        'club_id' => $user->club_id
    ]);
});

test('pagar mensalidade muda status e lanca no caixa', function () {
    $user = User::factory()->create();

    // Mensalidade deve pertencer ao clube do usuário
    $mensalidade = Mensalidade::factory()->create([
        'status' => 'pendente',
        'valor' => 50.00,
        'club_id' => $user->club_id
    ]);

    $response = $this->actingAs($user)->post(route('mensalidades.pagar', $mensalidade->id));

    $response->assertSessionHas('success');

    $mensalidade->refresh();
    expect($mensalidade->status)->toBe('pago');
    expect($mensalidade->data_pagamento)->not->toBeNull();

    $this->assertDatabaseHas('caixas', [
        'valor' => 50.00,
        'tipo' => 'entrada',
        'categoria' => 'Mensalidade',
        'club_id' => $user->club_id
    ]);
});
