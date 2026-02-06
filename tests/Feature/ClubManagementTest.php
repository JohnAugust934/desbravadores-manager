<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClubManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_diretor_pode_visualizar_pagina_de_edicao_do_clube()
    {
        // CORREÇÃO: Criação manual sem depender de Factory inexistente
        $club = Club::create([
            'nome' => 'Clube Alpha',
            'cidade' => 'São Paulo',
            'associacao' => 'AP',
        ]);

        $user = User::factory()->create(['club_id' => $club->id, 'role' => 'diretor']);

        $response = $this->actingAs($user)->get(route('club.edit'));

        $response->assertStatus(200);
        $response->assertSee('Clube Alpha');
        // Garante que os novos elementos de UI estão lá
        $response->assertSee('Brasão Oficial');
    }

    public function test_diretor_pode_atualizar_informacoes_basicas()
    {
        $club = Club::create([
            'nome' => 'Clube Antigo',
            'cidade' => 'Cidade Velha',
        ]);

        $user = User::factory()->create(['club_id' => $club->id, 'role' => 'diretor']);

        $response = $this->actingAs($user)->patch(route('club.update'), [
            'nome' => 'Clube Renovado',
            'cidade' => 'Nova Cidade',
            'associacao' => 'Associação Teste',
        ]);

        $response->assertSessionHas('success');
        $response->assertRedirect();

        $this->assertDatabaseHas('clubs', [
            'id' => $club->id,
            'nome' => 'Clube Renovado',
            'cidade' => 'Nova Cidade',
            'associacao' => 'Associação Teste',
        ]);
    }

    public function test_validacao_de_campos_obrigatorios_funciona()
    {
        $club = Club::create([
            'nome' => 'Clube Teste',
            'cidade' => 'SP',
        ]);

        $user = User::factory()->create(['club_id' => $club->id, 'role' => 'diretor']);

        // Tenta enviar vazio para forçar erro de validação
        $response = $this->actingAs($user)->patch(route('club.update'), [
            'nome' => '',
            'cidade' => '',
        ]);

        // Verifica se há erros na sessão (garante que o backend barrou e o x-input-error vai aparecer)
        $response->assertSessionHasErrors(['nome', 'cidade']);
    }

    public function test_upload_e_remocao_de_brasao()
    {
        Storage::fake('public');

        $club = Club::create([
            'nome' => 'Clube Visual',
            'cidade' => 'SP',
        ]);

        $user = User::factory()->create(['club_id' => $club->id, 'role' => 'diretor']);
        $file = UploadedFile::fake()->image('brasao.jpg');

        // 1. Teste de Upload
        $this->actingAs($user)->patch(route('club.update'), [
            'nome' => $club->nome,
            'cidade' => $club->cidade,
            'logo' => $file,
        ]);

        $club->refresh();
        $this->assertNotNull($club->logo);
        Storage::disk('public')->assertExists($club->logo);

        // 2. Teste de Remoção
        $this->actingAs($user)->delete(route('club.logo.destroy'));

        $club->refresh();
        $this->assertNull($club->logo);
    }
}
