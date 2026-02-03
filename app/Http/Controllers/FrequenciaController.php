<?php

namespace App\Http\Controllers;

use App\Models\Desbravador;
use App\Models\Frequencia;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FrequenciaController extends Controller
{
    public function create()
    {
        // Busca unidades que o usuário pode gerenciar
        $unidades = Unidade::with(['desbravadores' => function ($q) {
            $q->where('ativo', true)->orderBy('nome');
        }])->get()->filter(function ($unidade) {
            return Gate::allows('gerir-unidade', $unidade);
        });

        return view('frequencia.create', compact('unidades'));
    }

    public function store(Request $request)
    {
        // REMOVIDO: 'unidade_id' => 'required'
        // MOTIVO: O formulário pode conter múltiplas unidades (visão do Diretor/Master).
        // A validação de permissão será feita item a item abaixo.
        $request->validate([
            'data' => 'required|date',
            'presencas' => 'required|array',
        ]);

        foreach ($request->presencas as $id => $dados) {
            // Buscamos o desbravador e sua unidade para checar permissão
            $dbv = Desbravador::with('unidade')->find($id);

            if (! $dbv) {
                continue;
            }

            // Verifica permissão para a unidade deste desbravador específico
            if (Gate::denies('gerir-unidade', $dbv->unidade)) {
                // Se for um espertinho tentando burlar, abortamos ou apenas pulamos.
                // Aqui optei por pular para não quebrar o salvamento em lote se houver erro pontual.
                continue;
            }

            Frequencia::updateOrCreate(
                [
                    'desbravador_id' => $id,
                    'data' => $request->data,
                ],
                [
                    // isset() verifica se o checkbox foi marcado
                    'presente' => isset($dados['presente']),
                    'pontual' => isset($dados['pontual']),
                    'biblia' => isset($dados['biblia']),
                    'uniforme' => isset($dados['uniforme']),
                ]
            );
        }

        return redirect()->route('dashboard')->with('success', 'Chamada realizada com sucesso!');
    }
}
