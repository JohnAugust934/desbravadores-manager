<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $clubs = Club::withCount('users')->latest()->get();

        // Mostra convites não usados e verifica validade visualmente
        $invitations = Invitation::whereNull('used_at')->latest()->get();

        return view('admin.dashboard', compact('clubs', 'invitations'));
    }

    public function storeInvitation(Request $request)
    {
        $token = Str::random(32);

        Invitation::create([
            'token' => $token,
            'email' => $request->email,
            // CORREÇÃO: Define validade de 48 horas
            'expires_at' => now()->addHours(48),
        ]);

        return back()->with('success', 'Link de convite gerado! Valido por 48 horas.');
    }

    public function destroyInvitation($id)
    {
        Invitation::findOrFail($id)->delete();
        return back()->with('success', 'Convite cancelado.');
    }
}
