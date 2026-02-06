<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Patrimonio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatrimonioTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_ver_lista_de_patrimonio()
    {
        $club = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        // Usuário precisa ser 'tesoureiro' ou 'diretor' para acessar área financeira
        $user = User::factory()->create(['club_id' => $club->id, 'role' => 'tesoureiro']);

        // Criação Manual (ajustado campos conforme migration real)
        Patrimonio::create([
            'item' => 'Barraca Iglu',
            'quantidade' => 2,
            'valor_estimado' => 200.00,
            'estado_conservacao' => 'Bom',
            'observacoes' => 'Barraca para 4 pessoas',
        ]);

        $response = $this->actingAs($user)->get(route('patrimonio.index'));

        $response->assertStatus(200);
        $response->assertSee('Inventário de Patrimônio');
        $response->assertSee('Barraca Iglu');
        // 'codigo_patrimonio' não existe na migration, removi a asserção
    }

    public function test_usuario_pode_cadastrar_novo_item()
    {
        $club = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $club->id, 'role' => 'tesoureiro']);

        $dados = [
            'item' => 'Lampião a Gás',
            'quantidade' => 1,
            'valor_estimado' => 150.50,
            'estado_conservacao' => 'Novo',
            'data_aquisicao' => now()->format('Y-m-d'),
        ];

        $response = $this->actingAs($user)->post(route('patrimonio.store'), $dados);

        $response->assertRedirect(route('patrimonio.index'));
        $this->assertDatabaseHas('patrimonios', ['item' => 'Lampião a Gás']);
    }

    public function test_busca_patrimonio_case_insensitive()
    {
        $club = Club::create(['nome' => 'Clube Busca', 'cidade' => 'RJ']);
        $user = User::factory()->create(['club_id' => $club->id, 'role' => 'tesoureiro']);

        Patrimonio::create([
            'item' => 'Mochila Cargueira',
            'quantidade' => 5,
            'valor_estimado' => 500,
            'estado_conservacao' => 'Bom',
        ]);

        Patrimonio::create([
            'item' => 'Fogareiro',
            'quantidade' => 2,
            'valor_estimado' => 100,
            'estado_conservacao' => 'Regular',
        ]);

        // Teste 1: Busca por "mochila" (tudo minúsculo) deve achar "Mochila"
        $response = $this->actingAs($user)->get(route('patrimonio.index', ['search' => 'mochila']));
        $response->assertSee('Mochila Cargueira');
        $response->assertDontSee('Fogareiro');

        // Teste 2: Busca por "CARGUEIRA" (tudo maiúsculo) deve achar
        $response2 = $this->actingAs($user)->get(route('patrimonio.index', ['search' => 'CARGUEIRA']));
        $response2->assertSee('Mochila Cargueira');
    }
}
