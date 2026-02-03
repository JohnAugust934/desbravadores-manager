<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Desbravador;
use App\Models\Unidade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrequenciaTest extends TestCase
{
    use RefreshDatabase;

    public function test_pode_acessar_tela_de_chamada()
    {
        $clube = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $clube->id, 'role' => 'master']);

        $unidade = Unidade::factory()->create();
        Desbravador::factory()->create(['unidade_id' => $unidade->id]);

        $response = $this->actingAs($user)->get(route('frequencia.create'));

        $response->assertStatus(200);
    }

    public function test_pode_salvar_chamada_e_calcular_pontos()
    {
        $clube = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);

        $user = User::factory()->create([
            'club_id' => $clube->id,
            'role' => 'master',
        ]);

        $unidade = Unidade::factory()->create();
        $dbv = Desbravador::factory()->create(['unidade_id' => $unidade->id, 'ativo' => true]);

        // Dados simulando o envio correto do formulário
        $dados = [
            'data' => now()->format('Y-m-d'),
            // 'unidade_id' => ... REMOVIDO, pois o controller agora infere isso
            'presencas' => [ // NOME CORRIGIDO de frequencia para presencas
                $dbv->id => [
                    'presente' => 'on',
                    'pontual' => 'on',
                    'biblia' => 'on',
                    'uniforme' => 'on',
                ],
            ],
        ];

        $response = $this->actingAs($user)->post(route('frequencia.store'), $dados);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('frequencias', [
            'desbravador_id' => $dbv->id,
            'presente' => true,
            'pontual' => true,
        ]);
    }
}
