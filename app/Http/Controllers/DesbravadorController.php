<?php

namespace App\Http\Controllers;

use App\Models\Desbravador;
use App\Models\Unidade;
use Illuminate\Http\Request;

class DesbravadorController extends Controller
{
    // Lista todos os desbravadores
    public function index()
    {
        // Traz os desbravadores já carregando a Unidade (para não pesar o banco)
        $desbravadores = Desbravador::with('unidade')->get();
        return view('desbravadores.index', compact('desbravadores'));
    }

    // Mostra o formulário de cadastro
    public function create()
    {
        // Precisamos da lista de unidades para o select box
        $unidades = Unidade::all();
        return view('desbravadores.create', compact('unidades'));
    }

    // Salva no banco
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
}
