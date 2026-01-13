<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TeamController extends Controller
{
    public function index()
    {
        // Lista usuários do MESMO clube (o Global Scope já filtra, mas garantimos)
        $users = User::where('club_id', Auth::user()->club_id)->get();
        return view('team.index', compact('users'));
    }

    public function create()
    {
        return view('team.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'in:diretor,secretario,tesoureiro,conselheiro'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'club_id' => Auth::user()->club_id, // Vincula ao clube do diretor logado
            'is_super_admin' => false,
        ]);

        return redirect()->route('team.index')->with('success', 'Membro adicionado à equipe!');
    }

    public function destroy($id)
    {
        $user = User::where('club_id', Auth::user()->club_id)->findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Você não pode remover a si mesmo.');
        }

        $user->delete();
        return back()->with('success', 'Membro removido.');
    }
}
