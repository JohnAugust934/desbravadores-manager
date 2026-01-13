<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\DesbravadorController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\MensalidadeController;
use App\Http\Controllers\PatrimonioController;
use App\Http\Controllers\AtaController;
use App\Http\Controllers\AtoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClubSetupController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\DesbravadorEspecialidadeController;
use App\Http\Controllers\FichaMedicaController;
use App\Models\Desbravador;
use App\Models\Unidade;
use App\Models\Caixa;
use App\Models\Mensalidade;
use App\Models\Patrimonio;
use App\Models\Ata;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- ROTA DE ONBOARDING (PÚBLICA MAS REQUER TOKEN) ---
Route::get('/setup', [ClubSetupController::class, 'create'])->name('club.setup');
Route::post('/setup', [ClubSetupController::class, 'store'])->name('club.store');

// --- DASHBOARD PRINCIPAL ---
Route::get('/dashboard', function () {
    if (auth()->user()->is_super_admin) {
        return redirect()->route('admin.dashboard');
    }

    $stats = [
        'desbravadores' => Desbravador::count(),
        'unidades' => Unidade::count(),
        'saldo' => Caixa::where('tipo', 'entrada')->sum('valor') - Caixa::where('tipo', 'saida')->sum('valor'),
        'mensalidades_pendentes' => Mensalidade::where('status', 'pendente')->count(),
        'patrimonio_itens' => Patrimonio::sum('quantidade'),
        'atas' => Ata::count(),
    ];

    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

// --- GRUPO AUTENTICADO ---
Route::middleware('auth')->group(function () {

    // --- SUPER ADMIN (PAINEL DE CONTROLE) ---
    Route::middleware('superadmin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/invites', [AdminController::class, 'storeInvitation'])->name('invites.store');
        Route::delete('/invites/{id}', [AdminController::class, 'destroyInvitation'])->name('invites.destroy');
    });

    // --- PERFIL DE USUÁRIO (Acessível a todos) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- GESTÃO DE EQUIPE (Apenas Diretor) ---
    Route::middleware('can:gerenciar-tudo')->group(function () {
        Route::get('/equipe', [TeamController::class, 'index'])->name('team.index');
        Route::get('/equipe/adicionar', [TeamController::class, 'create'])->name('team.create');
        Route::post('/equipe', [TeamController::class, 'store'])->name('team.store');
        Route::delete('/equipe/{id}', [TeamController::class, 'destroy'])->name('team.destroy');
    });

    // --- MÓDULO SECRETARIA (Diretor + Secretário) ---
    Route::middleware('can:acessar-secretaria')->group(function () {
        // CORREÇÃO: Forçamos o parâmetro a ser 'unidade' (singular)
        Route::resource('unidades', UnidadeController::class)
            ->parameters(['unidades' => 'unidade']);

        // CORREÇÃO: Forçamos o parâmetro a ser 'desbravador' e não 'desbravadore'
        Route::resource('desbravadores', DesbravadorController::class)
            ->parameters(['desbravadores' => 'desbravador']);

        Route::resource('especialidades', EspecialidadeController::class);

        // Sub-rotas de Especialidades
        Route::get('desbravadores/{desbravador}/especialidades', [DesbravadorEspecialidadeController::class, 'index'])
            ->name('desbravadores.especialidades');

        Route::post('desbravadores/{desbravador}/especialidades', [DesbravadorEspecialidadeController::class, 'store'])
            ->name('desbravadores.especialidades.store');

        Route::delete('desbravadores/{desbravador}/especialidades/{especialidade}', [DesbravadorEspecialidadeController::class, 'destroy'])
            ->name('desbravadores.especialidades.destroy');

        // Atas e Atos
        Route::resource('atas', AtaController::class);
        Route::resource('atos', AtoController::class);

        // Ficha Médica
        Route::get('desbravadores/{id}/ficha-medica', [FichaMedicaController::class, 'edit'])->name('desbravadores.ficha-medica');
        Route::post('desbravadores/{id}/ficha-medica', [FichaMedicaController::class, 'update'])->name('desbravadores.ficha-medica.update');
        Route::get('desbravadores/{id}/ficha-medica/imprimir', [FichaMedicaController::class, 'imprimir'])->name('desbravadores.ficha-medica.print');

        // Relatórios
        Route::get('relatorios/autorizacao/{id}', [RelatorioController::class, 'autorizacaoSaida'])->name('relatorios.autorizacao');
    });

    // --- MÓDULO FINANCEIRO (Diretor + Tesoureiro) ---
    Route::middleware('can:acessar-tesouraria')->group(function () {
        // CORREÇÃO: Forçamos o parâmetro a ser 'caixa'
        Route::resource('caixa', CaixaController::class)
            ->parameters(['caixa' => 'caixa']);

        Route::get('mensalidades', [MensalidadeController::class, 'index'])->name('mensalidades.index');
        Route::post('mensalidades/gerar', [MensalidadeController::class, 'gerarMassivo'])->name('mensalidades.gerar');
        Route::post('mensalidades/{id}/pagar', [MensalidadeController::class, 'pagar'])->name('mensalidades.pagar');

        // Relatórios
        Route::get('relatorios/financeiro', [RelatorioController::class, 'financeiro'])->name('relatorios.financeiro');
    });

    // --- MÓDULO PATRIMÔNIO (Compartilhado) ---
    Route::middleware('can:acessar-patrimonio')->group(function () {
        Route::resource('patrimonio', PatrimonioController::class);
        Route::get('relatorios/patrimonio', [RelatorioController::class, 'patrimonio'])->name('relatorios.patrimonio');
    });
});

require __DIR__ . '/auth.php';
