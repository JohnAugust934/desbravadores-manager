<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    public function index()
    {
        $especialidades = Especialidade::all();
        return view('especialidades.index', compact('especialidades'));
    }

    public function create()
    {
        return view('especialidades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'area' => 'required|string|max:255',
        ]);

        Especialidade::create($request->all());

        return redirect()->route('especialidades.index')
            ->with('success', 'Especialidade cadastrada com sucesso!');
    }
}
