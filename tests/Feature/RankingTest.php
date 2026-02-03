<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Desbravador;
use App\Models\Frequencia;
use App\Models\Unidade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RankingTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_ver_ranking_unidades()
    {
        $clube = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $clube->id]);

        $response = $this->actingAs($user)->get(route('ranking.unidades'));
        $response->assertStatus(200);
        $response->assertViewHas('titulo', 'Ranking das Unidades');
    }

    public function test_usuario_pode_ver_ranking_individual()
    {
        $clube = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $clube->id]);

        $response = $this->actingAs($user)->get(route('ranking.desbravadores'));
        $response->assertStatus(200);
        $response->assertViewHas('titulo', 'Ranking Individual');
    }

    public function test_calculo_ranking_individual_correto()
    {
        $clube = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $clube->id]);

        $unidade = Unidade::factory()->create();

        // Desbravador 1: Full (30 pts)
        $dbv1 = Desbravador::factory()->create(['unidade_id' => $unidade->id, 'nome' => 'Campeão', 'ativo' => true]);
        Frequencia::create(['desbravador_id' => $dbv1->id, 'data' => now(), 'presente' => true, 'uniforme' => true, 'biblia' => true, 'pontual' => true]);

        // Desbravador 2: Só Presença (10 pts)
        $dbv2 = Desbravador::factory()->create(['unidade_id' => $unidade->id, 'nome' => 'Iniciante', 'ativo' => true]);
        Frequencia::create(['desbravador_id' => $dbv2->id, 'data' => now(), 'presente' => true, 'uniforme' => false, 'biblia' => false, 'pontual' => false]);

        $response = $this->actingAs($user)->get(route('ranking.desbravadores'));

        $dados = $response->viewData('data');

        $this->assertEquals('Campeão', $dados->first()->nome);
        $this->assertEquals(30, $dados->first()->pontos);

        $this->assertEquals('Iniciante', $dados->last()->nome);
        $this->assertEquals(10, $dados->last()->pontos);
    }
}
