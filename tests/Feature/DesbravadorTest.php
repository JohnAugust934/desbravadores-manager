<?php

use App\Models\Desbravador;
use App\Models\Especialidade;
use App\Models\Unidade;
use App\Models\User;
use App\Models\Club;

test('pode criar um desbravador vinculado a uma unidade', function () {
    $user = User::factory()->create();
    $unidade = Unidade::factory()->create(['club_id' => $user->club_id]);

    $dados = [
        'nome' => 'Joãozinho Desbravador',
        'data_nascimento' => '2010-05-20',
        'sexo' => 'M',
        'unidade_id' => $unidade->id,
        'classe_atual' => 'Amigo',
    ];

    $response = $this->actingAs($user)->post('/desbravadores', $dados);

    $response->assertRedirect(route('desbravadores.index'));

    $this->assertDatabaseHas('desbravadores', [
        'nome' => 'Joãozinho Desbravador',
        'unidade_id' => $unidade->id,
        'club_id' => $user->club_id
    ]);
});

test('seguranca: ignora club_id injetado maliciosamente no cadastro', function () {
    // Cenário: Usuário do Clube A tenta criar um desbravador forçando o ID do Clube B
    $userClubeA = User::factory()->create();
    $clubeB = Club::factory()->create();
    $unidadeClubeA = Unidade::factory()->create(['club_id' => $userClubeA->club_id]);

    $dadosMaliciosos = [
        'nome' => 'Hacker Desbravador',
        'data_nascimento' => '2010-05-20',
        'sexo' => 'M',
        'unidade_id' => $unidadeClubeA->id,
        'club_id' => $clubeB->id, // <--- TENTATIVA DE ATAQUE
    ];

    $this->actingAs($userClubeA)->post('/desbravadores', $dadosMaliciosos);

    // Verifica se o desbravador foi criado no Clube A (do usuário) e NÃO no Clube B
    $this->assertDatabaseHas('desbravadores', [
        'nome' => 'Hacker Desbravador',
        'club_id' => $userClubeA->club_id
    ]);

    $this->assertDatabaseMissing('desbravadores', [
        'nome' => 'Hacker Desbravador',
        'club_id' => $clubeB->id
    ]);
});

test('seguranca: impede vincular unidade de outro clube', function () {
    $user = User::factory()->create();

    // Cria uma unidade de OUTRO clube
    $outraUnidade = Unidade::factory()->create(); // Factory cria um clube novo automaticamente

    $dados = [
        'nome' => 'Teste Unidade Invalida',
        'data_nascimento' => '2010-05-20',
        'sexo' => 'M',
        'unidade_id' => $outraUnidade->id, // ID válido, mas de outro clube
    ];

    $response = $this->actingAs($user)->post('/desbravadores', $dados);

    // Deve falhar na validação (erro no campo unidade_id)
    $response->assertSessionHasErrors(['unidade_id']);
});

test('pode adicionar uma especialidade ao desbravador', function () {
    $user = User::factory()->create();
    $desbravador = Desbravador::factory()->create(['club_id' => $user->club_id]);
    $especialidade = Especialidade::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('desbravadores.especialidades.store', $desbravador->id), [
            'especialidade_id' => $especialidade->id,
            'data_conclusao' => '2023-10-10'
        ]);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('desbravador_especialidade', [
        'desbravador_id' => $desbravador->id,
        'especialidade_id' => $especialidade->id,
        'data_conclusao' => '2023-10-10'
    ]);
});
