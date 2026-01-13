<?php

use App\Models\User;
use App\Models\Club;

// --- TESTES DE GESTÃO DE EQUIPE (Apenas Diretor) ---

test('apenas diretor pode acessar gestao de equipe', function () {
    $user = User::factory()->create(['role' => 'diretor']);

    $this->actingAs($user)
        ->get(route('team.index'))
        ->assertStatus(200);
});

test('secretario nao pode acessar gestao de equipe', function () {
    $user = User::factory()->create(['role' => 'secretario']);

    $this->actingAs($user)
        ->get(route('team.index'))
        ->assertStatus(403); // Forbidden
});

test('tesoureiro nao pode acessar gestao de equipe', function () {
    $user = User::factory()->create(['role' => 'tesoureiro']);

    $this->actingAs($user)
        ->get(route('team.index'))
        ->assertStatus(403);
});

// --- TESTES DE SECRETARIA (Diretor e Secretário) ---

test('secretario pode acessar desbravadores', function () {
    $user = User::factory()->create(['role' => 'secretario']);

    $this->actingAs($user)
        ->get(route('desbravadores.index'))
        ->assertStatus(200);
});

test('tesoureiro NAO pode acessar desbravadores', function () {
    $user = User::factory()->create(['role' => 'tesoureiro']);

    $this->actingAs($user)
        ->get(route('desbravadores.index'))
        ->assertStatus(403);
});

// --- TESTES DE TESOURARIA (Diretor e Tesoureiro) ---

test('tesoureiro pode acessar caixa', function () {
    $user = User::factory()->create(['role' => 'tesoureiro']);

    $this->actingAs($user)
        ->get(route('caixa.index'))
        ->assertStatus(200);
});

test('secretario NAO pode acessar caixa', function () {
    $user = User::factory()->create(['role' => 'secretario']);

    $this->actingAs($user)
        ->get(route('caixa.index'))
        ->assertStatus(403);
});

// --- TESTES DE PATRIMÔNIO (Todos os cargos administrativos) ---

test('secretario e tesoureiro podem acessar patrimonio', function () {
    $secretario = User::factory()->create(['role' => 'secretario']);
    $tesoureiro = User::factory()->create(['role' => 'tesoureiro']);

    $this->actingAs($secretario)
        ->get(route('patrimonio.index'))
        ->assertStatus(200);

    $this->actingAs($tesoureiro)
        ->get(route('patrimonio.index'))
        ->assertStatus(200);
});
