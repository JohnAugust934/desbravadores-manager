<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Desbravador;
use App\Models\Especialidade;
use App\Models\Unidade;
use Illuminate\Http\Request;

class DesbravadorController extends Controller
{
    public function index(Request $request)
    {
        // Carrega unidade e classe para otimizar a listagem
        $query = Desbravador::with(['unidade', 'classe'])->orderBy('nome');

        // 1. Filtro da Barra de Busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Filtro por Unidade
        if ($request->filled('unidade_id')) {
            $query->where('unidade_id', $request->unidade_id);
        }

        // 3. Filtro de Status
        $status = $request->input('status', 'ativos');
        if ($status === 'ativos') {
            $query->where('ativo', true);
        } elseif ($status === 'inativos') {
            $query->where('ativo', false);
        }

        $desbravadores = $query->paginate(10);

        return view('desbravadores.index', compact('desbravadores', 'status'));
    }

    public function create()
    {
        $unidades = Unidade::orderBy('nome')->get();
        $classes = Classe::orderBy('ordem')->get(); // Carrega classes para o select

        return view('desbravadores.create', compact('unidades', 'classes'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            // Dados do Clube
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'unidade_id' => 'required|exists:unidades,id',

            // CORREÇÃO: Valida se é um ID válido de classe
            'classe_atual' => 'nullable|exists:classes,id',

            // Dados Pessoais e Contato
            'email' => 'required|email',
            'telefone' => 'nullable|string',
            'endereco' => 'required|string|max:500',
            'nome_responsavel' => 'required|string|max:255',
            'telefone_responsavel' => 'required|string',
            'numero_sus' => 'required|string|max:50',

            // Dados Médicos
            'tipo_sanguineo' => 'nullable|string|max:3',
            'alergias' => 'nullable|string',
            'medicamentos_continuos' => 'nullable|string',
            'plano_saude' => 'nullable|string',
        ]);

        $dados['ativo'] = true;

        Desbravador::create($dados);

        return redirect()->route('desbravadores.index')->with('success', 'Desbravador cadastrado com sucesso!');
    }

    public function show(Desbravador $desbravador)
    {
        // Carrega 'classe' para mostrar o nome (ex: "Amigo") na view
        $desbravador->load(['unidade', 'classe', 'especialidades', 'frequencias' => function ($q) {
            $q->orderBy('data', 'desc')->take(5);
        }]);

        return view('desbravadores.show', compact('desbravador'));
    }

    public function edit(Desbravador $desbravador)
    {
        $unidades = Unidade::orderBy('nome')->get();
        $classes = Classe::orderBy('ordem')->get(); // Carrega classes

        return view('desbravadores.edit', compact('desbravador', 'unidades', 'classes'));
    }

    public function update(Request $request, Desbravador $desbravador)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'ativo' => 'boolean',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'unidade_id' => 'required|exists:unidades,id',

            // CORREÇÃO: Validação de ID
            'classe_atual' => 'nullable|exists:classes,id',

            'email' => 'required|email',
            'telefone' => 'nullable|string',
            'endereco' => 'required|string',
            'nome_responsavel' => 'required|string',
            'telefone_responsavel' => 'required|string',
            'numero_sus' => 'required|string',
            'tipo_sanguineo' => 'nullable|string|max:3',
            'alergias' => 'nullable|string',
            'medicamentos_continuos' => 'nullable|string',
            'plano_saude' => 'nullable|string',
        ]);

        // Checkbox não enviado = false
        $dados['ativo'] = $request->has('ativo');

        $desbravador->update($dados);

        return redirect()->route('desbravadores.show', $desbravador)->with('success', 'Dados atualizados!');
    }

    // ... métodos de especialidades (mantidos iguais)
    public function gerenciarEspecialidades(Desbravador $desbravador)
    {
        $especialidades = Especialidade::orderBy('nome')->get();

        return view('desbravadores.especialidades', compact('desbravador', 'especialidades'));
    }

    public function salvarEspecialidades(Request $request, Desbravador $desbravador)
    {
        $request->validate([
            'especialidades' => 'array',
            'especialidades.*' => 'exists:especialidades,id',
            'data_conclusao' => 'required|date',
        ]);

        if ($request->has('especialidades')) {
            $syncData = [];
            foreach ($request->especialidades as $espId) {
                $syncData[$espId] = ['data_conclusao' => $request->data_conclusao];
            }
            $desbravador->especialidades()->syncWithoutDetaching($syncData);

            return back()->with('success', 'Especialidades adicionadas com sucesso!');
        }

        return back()->with('warning', 'Nenhuma especialidade selecionada.');
    }

    public function removerEspecialidade(Desbravador $desbravador, $especialidadeId)
    {
        $desbravador->especialidades()->detach($especialidadeId);

        return back()->with('success', 'Especialidade removida.');
    }
}
