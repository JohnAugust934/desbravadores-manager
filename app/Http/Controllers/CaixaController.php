<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Http\Requests\CaixaRequest; // Novo Request
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CaixaController extends Controller
{
    public function index(): View
    {
        // Ordena por data mais recente
        $lancamentos = Caixa::orderBy('data_movimentacao', 'desc')->get();

        // Cálculos simples para o topo da página
        $totalEntradas = $lancamentos->where('tipo', 'entrada')->sum('valor');
        $totalSaidas = $lancamentos->where('tipo', 'saida')->sum('valor');
        $saldo = $totalEntradas - $totalSaidas;

        return view('financeiro.caixa.index', compact('lancamentos', 'saldo', 'totalEntradas', 'totalSaidas'));
    }

    public function create(): View
    {
        return view('financeiro.caixa.create');
    }

    public function store(CaixaRequest $request): RedirectResponse
    {
        Caixa::create($request->validated());

        return redirect()->route('caixa.index')
            ->with('success', 'Lançamento financeiro realizado com sucesso!');
    }

    // Geralmente Caixa não se edita para manter integridade, mas se seu sistema permite:
    public function edit(Caixa $caixa): View
    {
        // O Route Model Binding já verificou se o $caixa pertence ao clube do usuário
        return view('financeiro.caixa.edit', compact('caixa'));
    }

    public function update(CaixaRequest $request, Caixa $caixa): RedirectResponse
    {
        $caixa->update($request->validated());

        return redirect()->route('caixa.index')
            ->with('success', 'Lançamento atualizado!');
    }

    public function destroy(Caixa $caixa): RedirectResponse
    {
        $caixa->delete();

        return redirect()->route('caixa.index')
            ->with('success', 'Lançamento removido.');
    }
}
