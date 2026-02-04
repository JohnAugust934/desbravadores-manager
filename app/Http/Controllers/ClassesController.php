<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Desbravador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
{
    public function index()
    {
        $classes = Classe::orderBy('ordem')->get();

        return view('classes.index', compact('classes'));
    }

    public function show(Classe $classe)
    {
        $classe->load('requisitos');

        // BUSCA CORRETA:
        // Filtra onde a coluna 'classe_atual' é igual ao ID da classe visualizada
        $desbravadores = Desbravador::where('ativo', true)
            ->where('classe_atual', $classe->id)
            ->with(['requisitosCumpridos' => function ($q) use ($classe) {
                $q->where('classe_id', $classe->id);
            }])
            ->orderBy('nome')
            ->get()
            ->map(function ($dbv) use ($classe) {
                $totalReqs = $classe->requisitos->count();
                $cumpridos = $dbv->requisitosCumpridos->count();

                $dbv->progresso_percentual = $totalReqs > 0 ? round(($cumpridos / $totalReqs) * 100) : 0;
                $dbv->ids_cumpridos = $dbv->requisitosCumpridos->pluck('id')->toArray();

                return $dbv;
            });

        return view('classes.show', compact('classe', 'desbravadores'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'desbravador_id' => 'required|exists:desbravadores,id',
            'requisito_id' => 'required|exists:requisitos,id',
            'concluido' => 'required|boolean',
        ]);

        $dbv = Desbravador::find($request->desbravador_id);

        // Verifica permissão se necessário
        // if (Gate::denies('pedagogico')) abort(403);

        if ($request->concluido) {
            $dbv->requisitosCumpridos()->attach($request->requisito_id, [
                'user_id' => Auth::id(),
                'data_conclusao' => now(),
            ]);
            $msg = 'Requisito assinado!';
        } else {
            $dbv->requisitosCumpridos()->detach($request->requisito_id);
            $msg = 'Assinatura removida.';
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }
}
