<?php

namespace App\Http\Controllers;

use App\Models\Desbravador;
use App\Models\Unidade;
use App\Http\Requests\DesbravadorRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DesbravadorController extends Controller
{
    public function index(): View
    {
        $desbravadores = Desbravador::with('unidade')->orderBy('nome')->get();
        return view('desbravadores.index', compact('desbravadores'));
    }

    public function create(): View
    {
        $unidades = Unidade::orderBy('nome')->get();
        return view('desbravadores.create', compact('unidades'));
    }

    public function store(DesbravadorRequest $request): RedirectResponse
    {
        Desbravador::create($request->validated());

        return redirect()->route('desbravadores.index')
            ->with('success', 'Desbravador cadastrado com sucesso!');
    }

    // Agora recebemos o objeto Desbravador direto (Route Model Binding)
    public function edit(Desbravador $desbravador): View
    {
        $unidades = Unidade::orderBy('nome')->get();
        return view('desbravadores.edit', compact('desbravador', 'unidades'));
    }

    public function update(DesbravadorRequest $request, Desbravador $desbravador): RedirectResponse
    {
        $desbravador->update($request->validated());

        return redirect()->route('desbravadores.index')
            ->with('success', 'Dados atualizados com sucesso!');
    }

    public function destroy(Desbravador $desbravador): RedirectResponse
    {
        $desbravador->delete();

        return redirect()->route('desbravadores.index')
            ->with('success', 'Desbravador removido com sucesso!');
    }
}
