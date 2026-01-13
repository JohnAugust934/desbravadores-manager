<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function index()
    {
        $unidades = Unidade::withCount('desbravadores')->orderBy('nome')->get();
        return view('unidades.index', compact('unidades'));
    }

    public function create()
    {
        return view('unidades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'conselheiro' => 'nullable|string|max:255',
            'grito_guerra' => 'nullable|string',
        ]);

        Unidade::create($request->all());

        return redirect()->route('unidades.index')->with('success', 'Unidade criada com sucesso!');
    }

    public function show(Unidade $unidade)
    {
        return view('unidades.show', compact('unidade'));
    }

    public function edit(Unidade $unidade)
    {
        // Método edit futuro
    }

    public function update(Request $request, Unidade $unidade)
    {
        // Método update futuro
    }

    public function destroy(Unidade $unidade)
    {
        // CORREÇÃO: Verificação via Código (Mais seguro que try/catch de banco)

        // Verifica se existe algum desbravador vinculado a esta unidade
        if ($unidade->desbravadores()->exists()) {
            return back()->with('error', 'Não é possível excluir esta unidade pois existem desbravadores vinculados a ela. Mova-os para outra unidade antes.');
        }

        // Se não tiver ninguém, pode apagar
        $unidade->delete();

        return redirect()->route('unidades.index')->with('success', 'Unidade removida com sucesso!');
    }
}
