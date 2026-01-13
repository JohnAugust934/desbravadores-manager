<?php

namespace App\Http\Controllers;

use App\Models\Desbravador;
use App\Models\FichaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FichaMedicaController extends Controller
{
    // Exibe o formulário (Edição/Visualização)
    public function edit($id)
    {
        $desbravador = Desbravador::with('fichaMedica')->findOrFail($id);
        return view('desbravadores.ficha-medica', compact('desbravador'));
    }

    // Salva os dados
    public function update(Request $request, $id)
    {
        $desbravador = Desbravador::findOrFail($id);

        $dados = $request->validate([
            'tipo_sanguineo' => 'nullable|string|max:3',
            'alergias' => 'nullable|string',
            'medicamentos_continuos' => 'nullable|string',
            'problemas_saude' => 'nullable|string',
            'plano_saude' => 'nullable|string|max:100',
            'numero_carteirinha' => 'nullable|string|max:50',
            'numero_sus' => 'nullable|string|max:50',
            'contato_nome' => 'required|string|max:100',
            'contato_telefone' => 'required|string|max:20',
            'contato_parentesco' => 'nullable|string|max:50',
        ]);

        FichaMedica::updateOrCreate(
            ['desbravador_id' => $desbravador->id, 'club_id' => Auth::user()->club_id],
            $dados
        );

        return back()->with('success', 'Ficha Médica salva com sucesso!');
    }

    // --- NOVO MÉTODO: IMPRESSÃO ---
    public function imprimir($id)
    {
        $desbravador = Desbravador::with(['fichaMedica', 'unidade', 'club'])->findOrFail($id);

        // Se não tiver ficha, cria uma instância vazia para não dar erro na view
        if (!$desbravador->fichaMedica) {
            $desbravador->setRelation('fichaMedica', new FichaMedica());
        }

        return view('desbravadores.print-ficha', compact('desbravador'));
    }
}
