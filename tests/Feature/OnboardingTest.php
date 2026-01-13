<?php

use App\Models\Invitation;
use App\Models\User;
use App\Models\Club;

test('super admin pode gerar convite', function () {
    // Cria um super admin (sem clube, mas com flag true)
    $admin = User::factory()->create(['is_super_admin' => true, 'club_id' => null]);

    $response = $this->actingAs($admin)->post(route('admin.invites.store'), [
        'email' => 'novo@clube.com'
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('invitations', ['email' => 'novo@clube.com']);
});

test('nao pode acessar setup com token invalido', function () {
    $response = $this->get(route('club.setup', ['token' => 'INVALIDO']));
    $response->assertStatus(404);
});

test('pode criar clube e usuario com token valido', function () {
    $invitation = Invitation::create(['token' => 'TOKEN_VALIDO']);

    $dados = [
        'token' => 'TOKEN_VALIDO',
        'club_name' => 'Clube Teste',
        'club_city' => 'Cidade Teste',
        'user_name' => 'Diretor Teste',
        'email' => 'diretor@teste.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->post(route('club.store'), $dados);

    $response->assertRedirect(route('dashboard', absolute: false));

    // Verifica se criou o clube
    $this->assertDatabaseHas('clubs', ['nome' => 'Clube Teste']);

    // Verifica se criou o usuario vinculado
    $club = Club::where('nome', 'Clube Teste')->first();
    $this->assertDatabaseHas('users', [
        'email' => 'diretor@teste.com',
        'club_id' => $club->id,
        'role' => 'diretor'
    ]);

    // Verifica se queimou o convite
    $this->assertNotNull($invitation->refresh()->used_at);
});
