<?php

use App\Models\User;
use App\Models\Desbravador;
use App\Models\Caixa;
use App\Models\Patrimonio;

test('pode gerar pdf de autorizacao', function () {
    $user = User::factory()->create();
    // Desbravador do mesmo clube
    $dbv = Desbravador::factory()->create(['club_id' => $user->club_id]);

    $response = $this->actingAs($user)->get(route('relatorios.autorizacao', $dbv->id));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});

test('pode gerar relatorio financeiro', function () {
    $user = User::factory()->create();
    // Caixa do mesmo clube
    Caixa::factory()->count(3)->create(['club_id' => $user->club_id]);

    $response = $this->actingAs($user)->get(route('relatorios.financeiro'));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});

test('pode gerar relatorio de patrimonio', function () {
    $user = User::factory()->create();
    // Patrimonio do mesmo clube
    Patrimonio::factory()->count(3)->create(['club_id' => $user->club_id]);

    $response = $this->actingAs($user)->get(route('relatorios.patrimonio'));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});
