<?php

namespace Tests\Feature;

use App\Models\Caixa;
use App\Models\Club;
use App\Models\Desbravador;
use App\Models\Mensalidade;
use App\Models\Unidade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class MensalidadeTest extends TestCase
{
    use RefreshDatabase;

    public function test_pode_gerar_mensalidades_para_todos_os_ativos()
    {
        $clube = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $clube->id]);
        $unidade = Unidade::factory()->create();
        Desbravador::factory()->count(3)->create(['unidade_id' => $unidade->id]);

        $response = $this->actingAs($user)->post(route('mensalidades.gerar'), [
            'mes' => 1,
            'ano' => 2026,
            'valor' => 15.00
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('mensalidades', 3);
    }

    public function test_pagar_mensalidade_muda_status_e_lanca_no_caixa()
    {
        $clube = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $clube->id]);
        $unidade = Unidade::factory()->create();
        $dbv = Desbravador::factory()->create(['unidade_id' => $unidade->id]);

        $mensalidade = Mensalidade::create([
            'desbravador_id' => $dbv->id,
            'mes' => 5,
            'ano' => 2026,
            'valor' => 20.00,
            'status' => 'pendente'
        ]);

        $response = $this->actingAs($user)->post(route('mensalidades.pagar', $mensalidade->id));

        $response->assertRedirect();

        // Verifica atualização da mensalidade
        $mensalidade->refresh();
        $this->assertEquals('pago', $mensalidade->status);
        $this->assertNotNull($mensalidade->data_pagamento);

        // Verifica lançamento automático no caixa
        $this->assertDatabaseHas('caixas', [
            'tipo' => 'entrada',
            'valor' => 20.00,
            'descricao' => "Mensalidade 05/2026 - " . $dbv->nome
        ]);
    }

    public function test_scope_inadimplentes_filtra_atrasados()
    {
        $unidade = Unidade::factory()->create();
        $dbv = Desbravador::factory()->create(['unidade_id' => $unidade->id]);

        // Fixamos uma data base para evitar colisão
        $now = Carbon::create(2026, 6, 15); // Supondo que hoje é Junho/2026
        Carbon::setTestNow($now); // Congela o tempo do teste

        // Cenário 1: Mensalidade mês passado (Maio/2026) -> ATRASADA
        $atrasada = Mensalidade::create([
            'desbravador_id' => $dbv->id,
            'mes' => 5,
            'ano' => 2026,
            'valor' => 10.00,
            'status' => 'pendente'
        ]);

        // Cenário 2: Mensalidade mês atual (Junho/2026) -> NÃO ATRASADA (Apenas pendente)
        $atual = Mensalidade::create([
            'desbravador_id' => $dbv->id,
            'mes' => 6,
            'ano' => 2026,
            'valor' => 10.00,
            'status' => 'pendente'
        ]);

        // Cenário 3: Mensalidade de dois meses atrás (Abril/2026) -> PAGA (Não deve aparecer)
        $paga = Mensalidade::create([
            'desbravador_id' => $dbv->id,
            'mes' => 4,
            'ano' => 2026,
            'valor' => 10.00,
            'status' => 'pago',
            'data_pagamento' => $now
        ]);

        // Busca usando o scope
        $inadimplentes = Mensalidade::inadimplentes()->get();

        // Verificações
        $this->assertTrue($inadimplentes->contains('id', $atrasada->id), 'A mensalidade atrasada deveria estar na lista.');
        $this->assertFalse($inadimplentes->contains('id', $atual->id), 'A mensalidade do mês atual NÃO é inadimplência ainda.');
        $this->assertFalse($inadimplentes->contains('id', $paga->id), 'A mensalidade paga não deve ser listada.');
    }
}
