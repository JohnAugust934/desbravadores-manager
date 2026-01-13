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
    // Mostra o formulário APENAS se o token for válido
    public function create(Request $request)
    {
        $token = $request->query('token');

        $invitation = Invitation::where('token', $token)
            ->whereNull('used_at')
            ->first();

        if (!$invitation) {
            abort(404, 'Convite inválido ou já utilizado.');
        }

        return view('auth.setup-club', compact('token', 'invitation'));
    }

    // Processa o cadastro
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

        $invitation = Invitation::where('token', $request->token)
            ->whereNull('used_at')
            ->firstOrFail();

        DB::transaction(function () use ($request, $invitation) {
            // 1. Criar o Clube
            $club = Club::create([
                'nome' => $request->club_name,
                'cidade' => $request->club_city,
                'ativo' => true,
            ]);

            // 2. Criar o Diretor vinculado ao Clube
            $user = User::create([
                'name' => $request->user_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'club_id' => $club->id,
                'role' => 'diretor',
                'is_super_admin' => false,
            ]);

            // 3. Invalidar o convite
            $invitation->update(['used_at' => now()]);

            // 4. Logar o usuário
            Auth::login($user);
        });

        return redirect(route('dashboard', absolute: false));
    }
}
