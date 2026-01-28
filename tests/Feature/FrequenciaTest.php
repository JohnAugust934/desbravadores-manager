<?php

namespace Tests\Feature;

use App\Models\Desbravador;
use App\Models\Frequencia;
use App\Models\Unidade;
use App\Models\User;
use App\Models\Club;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrequenciaTest extends TestCase
{
    use RefreshDatabase;

    public function test_pode_acessar_tela_de_chamada()
    {
        $club = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $club->id]);
        $unidade = Unidade::factory()->create();
        Desbravador::factory()->create(['unidade_id' => $unidade->id]);

        $response = $this->actingAs($user)->get(route('frequencia.create'));

        $response->assertStatus(200);
        $response->assertSee($unidade->nome);
    }

    public function test_pode_salvar_chamada_e_calcular_pontos()
    {
        $club = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $club->id]);
        $unidade = Unidade::factory()->create();
        $dbv = Desbravador::factory()->create(['unidade_id' => $unidade->id]);

        $data = date('Y-m-d');

        // Simula envio do formulário
        $response = $this->actingAs($user)->post(route('frequencia.store'), [
            'data' => $data,
            'frequencia' => [
                $dbv->id => [
                    'presente' => '1',
                    'pontual' => '1',
                    // 'biblia' => nao enviado (false)
                    'uniforme' => '1',
                ]
            ]
        ]);

        $response->assertRedirect(route('dashboard'));

        // Verifica banco (Removemos a verificação estrita da string de data para evitar erro de formato)
        $this->assertDatabaseHas('frequencias', [
            'desbravador_id' => $dbv->id,
            'presente' => 1,
            'biblia' => 0,
            'uniforme' => 1
        ]);

        // Verifica se a data foi salva corretamente no objeto (cast do Model resolve o formato)
        $frequencia = Frequencia::first();
        $this->assertEquals($data, $frequencia->data->format('Y-m-d'));

        // Verifica cálculo no Model (10 + 5 + 0 + 10 = 25)
        $this->assertEquals(25, $frequencia->pontos);

        // Verifica soma no Desbravador
        $this->assertEquals(25, $dbv->total_pontos);

        // Verifica soma na Unidade (Ranking)
        $this->assertEquals(25, $unidade->pontuacao_total);
    }
}
