<?php

namespace App\Http\Controllers;

use App\Models\Desbravador;
use App\Models\Unidade;
use App\Models\Especialidade;
use Illuminate\Http\Request;

class DesbravadorController extends Controller
{
    public function index()
    {
        $desbravadores = Desbravador::with('unidade')->get();
        return view('desbravadores.index', compact('desbravadores'));
    }

    public function create()
    {
        $unidades = Unidade::all();
        return view('desbravadores.create', compact('unidades'));
    }

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

        return redirect()->route('desbravadores.index')
            ->with('success', 'Desbravador cadastrado com sucesso!');
    }

    // --- MÉTODOS NOVOS PARA ESPECIALIDADES ---

    public function gerenciarEspecialidades($id)
    {
        $desbravador = Desbravador::with('especialidades')->findOrFail($id);
        $todasEspecialidades = Especialidade::all();

        return view('desbravadores.especialidades', compact('desbravador', 'todasEspecialidades'));
    }

    public function salvarEspecialidade(Request $request, $id)
    {
        $request->validate([
            'especialidade_id' => 'required|exists:especialidades,id',
            'data_conclusao' => 'required|date',
        ]);

        $desbravador = Desbravador::findOrFail($id);

        // O método attach cria o vínculo na tabela pivot
        $desbravador->especialidades()->attach($request->especialidade_id, [
            'data_conclusao' => $request->data_conclusao
        ]);

        return back()->with('success', 'Especialidade adicionada!');
    }

    public function removerEspecialidade($id, $especialidade_id)
    {
        $desbravador = Desbravador::findOrFail($id);

        // O método detach remove o vínculo
        $desbravador->especialidades()->detach($especialidade_id);

        return back()->with('success', 'Especialidade removida!');
    }
}
