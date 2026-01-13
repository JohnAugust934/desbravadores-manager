<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Http\Requests\UnidadeRequest; // Novo Request
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UnidadeController extends Controller
{
    public function index(): View
    {
        $unidades = Unidade::orderBy('nome')->get();
        return view('unidades.index', compact('unidades'));
    }

    public function create(): View
    {
        return view('unidades.create');
    }

    public function store(UnidadeRequest $request): RedirectResponse
    {
        // Mass Assignment protegido pelo validated()
        Unidade::create($request->validated());

        return redirect()->route('unidades.index')
            ->with('success', 'Unidade criada com sucesso!');
    }

    public function edit(Unidade $unidade): View
    {
        return view('unidades.edit', compact('unidade'));
    }

    public function update(UnidadeRequest $request, Unidade $unidade): RedirectResponse
    {
        $unidade->update($request->validated());

        return redirect()->route('unidades.index')
            ->with('success', 'Unidade atualizada com sucesso!');
    }

    public function destroy(Unidade $unidade): RedirectResponse
    {
        // Verifica se tem desbravadores antes de deletar (opcional, mas recomendado)
        if ($unidade->desbravadores()->exists()) {
            return back()->with('error', 'Não é possível remover uma unidade que possui desbravadores vinculados.');
        }

        $unidade->delete();

        return redirect()->route('unidades.index')
            ->with('success', 'Unidade removida com sucesso!');
    }
}
