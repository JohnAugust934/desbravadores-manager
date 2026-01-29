<?php

namespace App\Http\Controllers;

use App\Models\Mensalidade;
use App\Models\Desbravador;
use App\Models\Caixa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MensalidadeController extends Controller
{
    /**
     * Lista as mensalidades com filtros.
     */
    public function index(Request $request)
    {
        $mes = $request->input('mes', date('m'));
        $ano = $request->input('ano', date('Y'));

        // Carrega mensalidades do mês selecionado
        $mensalidades = Mensalidade::with('desbravador')
            ->where('mes', $mes)
            ->where('ano', $ano)
            ->get();

        // Cálculos do Mês
        $valorRecebido = $mensalidades->where('status', 'pago')->sum('valor');
        $valorPendente = $mensalidades->where('status', 'pendente')->sum('valor');
        $totalPago = $mensalidades->where('status', 'pago')->count();
        $totalPendente = $mensalidades->where('status', 'pendente')->count();

        // Cálculo de Inadimplência Histórica (Dívida total acumulada de meses anteriores)
        $totalInadimplenteGeral = Mensalidade::inadimplentes()->sum('valor');
        $qtdInadimplentes = Mensalidade::inadimplentes()->count();

        return view('financeiro.mensalidades.index', compact(
            'mensalidades',
            'mes',
            'ano',
            'valorRecebido',
            'valorPendente',
            'totalPago',
            'totalPendente',
            'totalInadimplenteGeral',
            'qtdInadimplentes'
        ));
    }

    /**
     * Gera mensalidades em massa para todos os desbravadores.
     */
    public function gerarMassivo(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'ano' => 'required|integer|min:2020',
            'valor' => 'required|numeric|min:0',
        ]);

        $desbravadores = Desbravador::all();
        $count = 0;

        foreach ($desbravadores as $dbv) {
            // Verifica se já existe para não duplicar
            $exists = Mensalidade::where('desbravador_id', $dbv->id)
                ->where('mes', $request->mes)
                ->where('ano', $request->ano)
                ->exists();

            if (!$exists) {
                Mensalidade::create([
                    'desbravador_id' => $dbv->id,
                    'mes' => $request->mes,
                    'ano' => $request->ano,
                    'valor' => $request->valor,
                    'status' => 'pendente',
                ]);
                $count++;
            }
        }

        return back()->with('success', "$count mensalidades geradas com sucesso!");
    }

    /**
     * Realiza o pagamento e lança no caixa automaticamente.
     */
    public function pagar($id)
    {
        $mensalidade = Mensalidade::with('desbravador')->findOrFail($id);

        if ($mensalidade->status === 'pago') {
            return back()->with('error', 'Esta mensalidade já consta como paga.');
        }

        // Transação: Tudo ou nada. Se falhar o caixa, não baixa a mensalidade.
        DB::transaction(function () use ($mensalidade) {

            // 1. Atualiza Status da Mensalidade
            $mensalidade->update([
                'status' => 'pago',
                'data_pagamento' => Carbon::now(),
            ]);

            // 2. Lança Entrada no Caixa
            Caixa::create([
                'descricao' => "Mensalidade " . str_pad($mensalidade->mes, 2, '0', STR_PAD_LEFT) . "/" . $mensalidade->ano . " - " . $mensalidade->desbravador->nome,
                'tipo' => 'entrada',
                'valor' => $mensalidade->valor,
                'data_movimentacao' => Carbon::now(),
            ]);
        });

        return back()->with('success', 'Pagamento recebido e lançado no caixa com sucesso!');
    }
}
