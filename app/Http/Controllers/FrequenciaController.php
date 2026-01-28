<?php

namespace App\Http\Controllers;

use App\Models\Frequencia;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrequenciaController extends Controller
{
    /**
     * Exibe o formulário de chamada (Lista todos agrupados por unidade).
     */
    public function create()
    {
        // Carrega unidades e seus desbravadores ativos
        $unidades = Unidade::with(['desbravadores' => function ($query) {
            $query->orderBy('nome');
        }])->orderBy('nome')->get();

        return view('frequencia.create', compact('unidades'));
    }

    /**
     * Salva a chamada em massa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|date',
            'frequencia' => 'array', // Array de dados
        ]);

        $data = $request->data;
        $dadosFrequencia = $request->frequencia ?? [];

        DB::transaction(function () use ($data, $dadosFrequencia) {
            // Itera sobre os dados enviados (desbravador_id => [dados])
            foreach ($dadosFrequencia as $id => $atributos) {

                // Prepara os valores booleanos (checkbox não enviado é false)
                $presente = isset($atributos['presente']);

                Frequencia::updateOrCreate(
                    [
                        'desbravador_id' => $id,
                        'data' => $data
                    ],
                    [
                        'presente' => $presente,
                        // Se não veio presente, os outros devem ser false logicamente, 
                        // mas vamos salvar o que vier do form
                        'pontual' => isset($atributos['pontual']),
                        'biblia' => isset($atributos['biblia']),
                        'uniforme' => isset($atributos['uniforme']),
                    ]
                );
            }
        });

        return redirect()->route('dashboard')->with('success', 'Chamada realizada com sucesso!');
    }
}
