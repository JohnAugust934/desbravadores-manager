<?php

namespace App\Http\Controllers;

use App\Models\Desbravador;
use App\Models\Unidade;
use App\Models\Especialidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesbravadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // O Global Scope já filtra pelo clube do usuário
        $desbravadores = Desbravador::with('unidade')->orderBy('nome')->get();
        return view('desbravadores.index', compact('desbravadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unidades = Unidade::orderBy('nome')->get();
        return view('desbravadores.create', compact('unidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'unidade_id' => 'nullable|exists:unidades,id',
            'classe_atual' => 'nullable|string',
        ]);

        Desbravador::create($request->all());

        return redirect()->route('desbravadores.index')->with('success', 'Desbravador cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $desbravador = Desbravador::findOrFail($id);
        $unidades = Unidade::orderBy('nome')->get();

        return view('desbravadores.edit', compact('desbravador', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $desbravador = Desbravador::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'unidade_id' => 'nullable|exists:unidades,id',
            'classe_atual' => 'nullable|string',
            'ativo' => 'boolean'
        ]);

        // Checkbox HTML não envia nada se desmarcado, então forçamos o false se não vier
        if (!$request->has('ativo')) {
            $validated['ativo'] = false;
        }

        $desbravador->update($validated);

        return redirect()->route('desbravadores.index')->with('success', 'Dados atualizados com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $desbravador = Desbravador::findOrFail($id);
        $desbravador->delete();

        return redirect()->route('desbravadores.index')->with('success', 'Desbravador removido com sucesso!');
    }

    // --- Métodos de Especialidades (Extras) ---

    public function gerenciarEspecialidades($id)
    {
        $desbravador = Desbravador::with('especialidades')->findOrFail($id);
        $especialidades = Especialidade::orderBy('nome')->get();

        return view('desbravadores.especialidades', compact('desbravador', 'especialidades'));
    }

    public function salvarEspecialidade(Request $request, $id)
    {
        $desbravador = Desbravador::findOrFail($id);

        $request->validate([
            'especialidade_id' => 'required|exists:especialidades,id',
            'data_conclusao' => 'required|date',
        ]);

        // Attach adiciona na tabela pivo (many-to-many)
        $desbravador->especialidades()->attach($request->especialidade_id, [
            'data_conclusao' => $request->data_conclusao
        ]);

        return back()->with('success', 'Especialidade adicionada!');
    }

    public function removerEspecialidade($id, $especialidade_id)
    {
        $desbravador = Desbravador::findOrFail($id);
        $desbravador->especialidades()->detach($especialidade_id);

        return back()->with('success', 'Especialidade removida.');
    }
}
