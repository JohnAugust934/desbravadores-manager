<?php

use App\Models\Invitation;
use App\Models\User;
use App\Models\Unidade;
use App\Models\Desbravador;

test('convite expirado nao permite cadastro', function () {
    // Cria convite vencido ontem
    $invitation = Invitation::create([
        'token' => 'TOKEN_VENCIDO',
        'expires_at' => now()->subDay()
    ]);

    $response = $this->get(route('club.setup', ['token' => 'TOKEN_VENCIDO']));

    // Deve dar 404 ou erro
    $response->assertStatus(404);
});

test('nao pode excluir unidade com desbravadores vinculados', function () {
    $user = User::factory()->create(['role' => 'diretor']);

    // Cria unidade e coloca um desbravador nela
    $unidade = Unidade::factory()->create(['club_id' => $user->club_id]);
    Desbravador::factory()->create([
        'club_id' => $user->club_id,
        'unidade_id' => $unidade->id
    ]);

    $response = $this->actingAs($user)->delete(route('unidades.destroy', $unidade->id));

    // Não deve excluir
    $this->assertDatabaseHas('unidades', ['id' => $unidade->id]);

    // Deve redirecionar com mensagem de erro na sessão
    $response->assertSessionHas('error');
});

test('pode excluir unidade vazia', function () {
    $user = User::factory()->create(['role' => 'diretor']);
    $unidade = Unidade::factory()->create(['club_id' => $user->club_id]);

    $response = $this->actingAs($user)->delete(route('unidades.destroy', $unidade->id));

    $this->assertDatabaseMissing('unidades', ['id' => $unidade->id]);
    $response->assertSessionHas('success');
});
