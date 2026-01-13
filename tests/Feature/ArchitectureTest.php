<?php

use App\Models\Club;
use App\Models\User;
use App\Models\Invitation;

test('pode criar um clube e vincular um usuario', function () {
    $club = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);

    $user = User::factory()->create([
        'club_id' => $club->id,
        'role' => 'diretor'
    ]);

    expect($user->club->nome)->toBe('Clube Teste');
    expect($club->users)->toHaveCount(1);
});

test('pode criar um convite', function () {
    $invitation = Invitation::create([
        'token' => 'TOKEN123',
        'email' => 'diretor@teste.com'
    ]);

    $this->assertDatabaseHas('invitations', ['token' => 'TOKEN123']);
});

test('tabelas de dominio tem club_id', function () {
    // Este teste verifica se a migration rodou certo verificando se conseguimos salvar com club_id
    $club = Club::create(['nome' => 'Clube A']);

    // Testa Unidade
    $unidade = \App\Models\Unidade::create([
        'club_id' => $club->id,
        'nome' => 'Unidade 1'
    ]);

    $this->assertDatabaseHas('unidades', ['club_id' => $club->id]);
});
