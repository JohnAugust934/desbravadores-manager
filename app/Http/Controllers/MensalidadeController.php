<?php

namespace App\Http\Controllers;

use App\Models\Mensalidade;
use App\Models\Desbravador;
use App\Models\Caixa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MensalidadeController extends Controller
{
    public function index(Request $request)
    {
        // Filtros básicos (Padrão: Mês atual)
        $mes = $request->input('mes', date('m'));
        $ano = $request->input('ano', date('Y'));

        $mensalidades = Mensalidade::with('desbravador')
            ->where('mes', $mes)
            ->where('ano', $ano)
            ->get();

        // Estatísticas para os Cards
        $totalPendente = $mensalidades->where('status', 'pendente')->count();
        $totalPago = $mensalidades->where('status', 'pago')->count();
        $valorRecebido = $mensalidades->where('status', 'pago')->sum('valor');
        $valorPendente = $mensalidades->where('status', 'pendente')->sum('valor');

        return view('financeiro.mensalidades.index', compact(
            'mensalidades',
            'mes',
            'ano',
            'totalPendente',
            'totalPago',
            'valorRecebido',
            'valorPendente'
        ));
    }

    public function gerarMassivo(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'ano' => 'required|integer|min:2020',
            'valor' => 'required|numeric|min:0.01',
        ]);

        // Pega todos os desbravadores ATIVOS
        $desbravadores = Desbravador::where('ativo', true)->get();
        $count = 0;

        foreach ($desbravadores as $dbv) {
            // Cria apenas se ainda não existir para esse mês
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
                    'status' => 'pendente'
                ]);
                $count++;
            }
        }

        return back()->with('success', "$count mensalidades geradas para {$request->mes}/{$request->ano}!");
    }

    public function pagar($id)
    {
        $mensalidade = Mensalidade::with('desbravador')->findOrFail($id);

        if ($mensalidade->status == 'pago') {
            return back()->with('error', 'Esta mensalidade já foi paga.');
        }

        // Transação de Banco de Dados: Ou faz tudo (Update + Caixa), ou não faz nada.
        DB::transaction(function () use ($mensalidade) {
            // 1. Atualiza a mensalidade
            $mensalidade->update([
                'status' => 'pago',
                'data_pagamento' => now()
            ]);

            // 2. Lança no Caixa automaticamente
            Caixa::create([
                'descricao' => "Mensalidade " . $mensalidade->mes . "/" . $mensalidade->ano . " - " . $mensalidade->desbravador->nome,
                'valor' => $mensalidade->valor,
                'tipo' => 'entrada',
                'categoria' => 'Mensalidade',
                'data_movimentacao' => now()
            ]);
        });

        return back()->with('success', 'Pagamento recebido e lançado no caixa!');
    }
}
