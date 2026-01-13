<?php

use App\Models\Unidade;
use App\Models\User;
use App\Models\Club;

test('lista unidades do clube do usuario', function () {
    $user = User::factory()->create();
    Unidade::factory()->count(3)->create(['club_id' => $user->club_id]);

    $response = $this->actingAs($user)->get('/unidades');

    $response->assertStatus(200);
    $response->assertViewHas('unidades');
});

test('pode criar uma unidade', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/unidades', [
        'nome' => 'Unidade Leões',
    ]);

    $response->assertRedirect(route('unidades.index'));
    $this->assertDatabaseHas('unidades', [
        'nome' => 'Unidade Leões',
        'club_id' => $user->club_id,
    ]);
});

test('seguranca: nao pode editar unidade de outro clube', function () {
    $userClubeA = User::factory()->create();

    // Cria uma unidade em OUTRO clube (factory cria um clube novo automaticamente)
    $unidadeClubeB = Unidade::factory()->create();

    // Tenta atualizar a unidade B estando logado no Clube A
    $response = $this->actingAs($userClubeA)
        ->put("/unidades/{$unidadeClubeB->id}", [
            'nome' => 'Nome Hackeado'
        ]);

    // O Laravel deve retornar 404 porque o Scope Global esconde a unidade do outro clube
    $response->assertStatus(404);
});
