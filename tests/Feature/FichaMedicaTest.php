<?php

use App\Models\User;
use App\Models\Desbravador;
use App\Models\FichaMedica;

test('diretor pode acessar a tela de ficha medica', function () {
    $user = User::factory()->create(['role' => 'diretor']);
    $desbravador = Desbravador::factory()->create(['club_id' => $user->club_id]);

    $response = $this->actingAs($user)
        ->get(route('desbravadores.ficha-medica', $desbravador->id));

    $response->assertStatus(200);
    $response->assertSee($desbravador->nome);
});

test('pode salvar dados medicos', function () {
    $user = User::factory()->create(['role' => 'diretor']);
    $desbravador = Desbravador::factory()->create(['club_id' => $user->club_id]);

    $dados = [
        'contato_nome' => 'Mãe Teste',
        'contato_telefone' => '11999999999',
        'tipo_sanguineo' => 'O+',
        'alergias' => 'Amendoim',
    ];

    $response = $this->actingAs($user)
        ->post(route('desbravadores.ficha-medica.update', $desbravador->id), $dados);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('ficha_medicas', [
        'desbravador_id' => $desbravador->id,
        'alergias' => 'Amendoim',
        'tipo_sanguineo' => 'O+'
    ]);
});

test('nao pode salvar ficha de desbravador de outro clube', function () {
    $user = User::factory()->create(['role' => 'diretor']);
    // Desbravador de OUTRO clube
    $desbravadorOutro = Desbravador::factory()->create();

    $dados = [
        'contato_nome' => 'Invasor',
        'contato_telefone' => '000',
    ];

    $response = $this->actingAs($user)
        ->post(route('desbravadores.ficha-medica.update', $desbravadorOutro->id), $dados);

    // Deve dar 404 porque o TenantScope esconde o desbravador
    $response->assertStatus(404);
});
