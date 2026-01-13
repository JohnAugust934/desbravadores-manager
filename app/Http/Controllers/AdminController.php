<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // Painel Principal
    public function index()
    {
        $clubs = Club::withCount('users')->latest()->get();
        $invitations = Invitation::whereNull('used_at')->latest()->get();

        return view('admin.dashboard', compact('clubs', 'invitations'));
    }

    // Gerar Convite
    public function storeInvitation(Request $request)
    {
        $token = Str::random(32);

        Invitation::create([
            'token' => $token,
            'email' => $request->email, // Opcional, pode ser null
        ]);

        return back()->with('success', 'Convite gerado com sucesso!');
    }

    // Deletar Convite
    public function destroyInvitation($id)
    {
        Invitation::findOrFail($id)->delete();
        return back()->with('success', 'Convite removido.');
    }
}
