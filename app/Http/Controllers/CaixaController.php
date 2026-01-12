<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use Illuminate\Http\Request;

class CaixaController extends Controller
{
    public function index()
    {
        // Ordena por data (mais recente primeiro)
        $lancamentos = Caixa::orderBy('data_movimentacao', 'desc')->get();

        // Calcula o saldo total
        $entradas = Caixa::where('tipo', 'entrada')->sum('valor');
        $saidas = Caixa::where('tipo', 'saida')->sum('valor');
        $saldoAtual = $entradas - $saidas;

        return view('financeiro.caixa.index', compact('lancamentos', 'saldoAtual'));
    }

    public function create()
    {
        return view('financeiro.caixa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'tipo' => 'required|in:entrada,saida',
            'data_movimentacao' => 'required|date',
            'categoria' => 'nullable|string',
        ]);

        Caixa::create($request->all());

        return redirect()->route('caixa.index')
            ->with('success', 'Lançamento realizado com sucesso!');
    }
}
