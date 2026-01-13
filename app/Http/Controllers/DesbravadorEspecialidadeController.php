<?php

namespace App\Http\Controllers;

use App\Models\Desbravador;
use App\Models\Especialidade;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DesbravadorEspecialidadeController extends Controller
{
    /**
     * Lista as especialidades de um desbravador específico.
     */
    public function index(Desbravador $desbravador): View
    {
        // Carrega as especialidades do desbravador (Eager Loading)
        $desbravador->load('especialidades');

        $especialidades = Especialidade::orderBy('nome')->get();

        return view('desbravadores.especialidades', compact('desbravador', 'especialidades'));
    }

    /**
     * Adiciona uma especialidade ao desbravador.
     */
    public function store(Request $request, Desbravador $desbravador): RedirectResponse
    {
        $request->validate([
            'especialidade_id' => 'required|exists:especialidades,id',
            'data_conclusao' => 'required|date',
        ]);

        // Attach adiciona na tabela pivo
        $desbravador->especialidades()->attach($request->especialidade_id, [
            'data_conclusao' => $request->data_conclusao
        ]);

        return back()->with('success', 'Especialidade adicionada!');
    }

    /**
     * Remove uma especialidade do desbravador.
     */
    public function destroy(Desbravador $desbravador, Especialidade $especialidade): RedirectResponse
    {
        // Detach remove da tabela pivo
        $desbravador->especialidades()->detach($especialidade->id);

        return back()->with('success', 'Especialidade removida.');
    }
}
