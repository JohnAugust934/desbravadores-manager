<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class ClubSetupController extends Controller
{
    public function create(Request $request)
    {
        $token = $request->query('token');

        $invitation = Invitation::where('token', $token)->first();

        // CORREÇÃO: Verifica se existe, se já usou OU SE JÁ EXPIROU
        if (!$invitation || $invitation->used_at || ($invitation->expires_at && $invitation->expires_at->isPast())) {
            abort(404, 'Este convite expirou, já foi utilizado ou é inválido.');
        }

        return view('auth.setup-club', compact('token', 'invitation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|exists:invitations,token',
            'club_name' => 'required|string|max:255',
            'club_city' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $invitation = Invitation::where('token', $request->token)->firstOrFail();

        // CORREÇÃO: Validação dupla no backend antes de salvar
        if ($invitation->used_at || ($invitation->expires_at && $invitation->expires_at->isPast())) {
            return back()->withErrors(['token' => 'O convite expirou enquanto você preenchia o formulário.']);
        }

        DB::transaction(function () use ($request, $invitation) {
            $club = Club::create([
                'nome' => $request->club_name,
                'cidade' => $request->club_city,
                'ativo' => true,
            ]);

            $user = User::create([
                'name' => $request->user_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'club_id' => $club->id,
                'role' => 'diretor',
                'is_super_admin' => false,
            ]);

            $invitation->update(['used_at' => now()]);

            Auth::login($user);
        });

        return redirect(route('dashboard', absolute: false));
    }
}
