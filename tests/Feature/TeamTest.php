<?php

use App\Models\User;
use App\Models\Club;

test('diretor pode adicionar um novo membro a equipe', function () {
    $diretor = User::factory()->create(['role' => 'diretor']);

    $dados = [
        'name' => 'Novo Tesoureiro',
        'email' => 'tesoureiro@clube.com',
        'role' => 'tesoureiro',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->actingAs($diretor)->post(route('team.store'), $dados);

    $response->assertRedirect(route('team.index'));
    $response->assertSessionHas('success');

    // Verifica se criou o usuário
    $this->assertDatabaseHas('users', [
        'email' => 'tesoureiro@clube.com',
        'role' => 'tesoureiro',
        'club_id' => $diretor->club_id // Deve herdar o clube do diretor
    ]);
});

test('diretor pode remover um membro da equipe', function () {
    $diretor = User::factory()->create(['role' => 'diretor']);

    // Cria um membro do MESMO clube
    $membro = User::factory()->create([
        'club_id' => $diretor->club_id,
        'role' => 'secretario'
    ]);

    $response = $this->actingAs($diretor)->delete(route('team.destroy', $membro->id));

    $response->assertRedirect(); // Volta pra tela anterior
    $response->assertSessionHas('success');

    // Verifica se o usuário sumiu do banco
    $this->assertDatabaseMissing('users', ['id' => $membro->id]);
});

test('diretor nao pode remover membro de outro clube', function () {
    $diretor = User::factory()->create(['role' => 'diretor']);

    // Cria um membro de OUTRO clube
    $membroOutroClube = User::factory()->create(); // Factory cria clube novo auto

    $response = $this->actingAs($diretor)->delete(route('team.destroy', $membroOutroClube->id));

    // Deve dar 404 porque o TenantScope esconde esse usuário do diretor
    $response->assertStatus(404);

    // O usuário ainda deve existir no banco
    $this->assertDatabaseHas('users', ['id' => $membroOutroClube->id]);
});

test('diretor nao pode remover a si mesmo', function () {
    $diretor = User::factory()->create(['role' => 'diretor']);

    $response = $this->actingAs($diretor)->delete(route('team.destroy', $diretor->id));

    $response->assertSessionHas('error');
    $this->assertDatabaseHas('users', ['id' => $diretor->id]);
});
