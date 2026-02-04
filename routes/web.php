<?php

use App\Http\Controllers\AtaController;
use App\Http\Controllers\AtoController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesbravadorController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\FrequenciaController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MensalidadeController;
use App\Http\Controllers\PatrimonioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ROTA PÚBLICA (Landing Page) ---
Route::get('/', function () {
    return view('welcome');
});

// --- REGISTRO VIA CONVITE (Público mas restrito por token) ---
Route::get('/register-invite', [RegisteredUserController::class, 'create'])->name('register.invite');
Route::post('/register-invite', [RegisteredUserController::class, 'store'])->name('register.store_invite');

// --- ÁREA RESTRITA (Requer Login) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. DASHBOARD E PERFIL
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. ADMINISTRAÇÃO MASTER (Gestão de Acessos)
    Route::middleware('can:master')->group(function () {
        Route::resource('usuarios', UsuarioController::class);

        // Sistema de Convites
        Route::prefix('invites')->name('invites.')->group(function () {
            Route::get('/', [InvitationController::class, 'index'])->name('index');
            Route::get('/create', [InvitationController::class, 'create'])->name('create');
            Route::post('/', [InvitationController::class, 'store'])->name('store');
            Route::delete('/{invite}', [InvitationController::class, 'destroy'])->name('destroy');
        });
    });

    // 3. SECRETARIA (Gestão de Membros e Clube)
    Route::middleware('can:secretaria')->group(function () {
        // Configurações do Clube
        Route::get('/clube', [ClubController::class, 'edit'])->name('club.edit');
        Route::patch('/clube', [ClubController::class, 'update'])->name('club.update');
        Route::delete('/clube/logo', [ClubController::class, 'destroyLogo'])->name('club.logo.destroy');

        // Documentos Oficiais
        Route::resource('atas', AtaController::class);
        Route::resource('atos', AtoController::class);

        // Gestão Completa (CRUD)
        Route::resource('desbravadores', DesbravadorController::class)->parameters(['desbravadores' => 'desbravador']);
        Route::resource('unidades', UnidadeController::class)->except(['index', 'show']);
    });

    // 4. VISUALIZAÇÃO GERAL (Conselheiros e Outros Cargos)
    Route::get('/unidades', [UnidadeController::class, 'index'])->name('unidades.index');
    Route::get('/unidades/{unidade}', [UnidadeController::class, 'show'])->name('unidades.show');
    Route::get('/desbravadores/{desbravador}', [DesbravadorController::class, 'show'])->name('desbravadores.show');

    // 5. PEDAGÓGICO (Classes, Especialidades e Frequência)
    Route::middleware('can:pedagogico')->group(function () {
        // Especialidades
        Route::resource('especialidades', EspecialidadeController::class);
        Route::get('/desbravadores/{desbravador}/especialidades', [DesbravadorController::class, 'gerenciarEspecialidades'])->name('desbravadores.especialidades');
        Route::post('/desbravadores/{desbravador}/especialidades', [DesbravadorController::class, 'salvarEspecialidades'])->name('desbravadores.salvar-especialidades');
        Route::delete('/desbravadores/{desbravador}/especialidades/{especialidade}', [DesbravadorController::class, 'removerEspecialidade'])->name('desbravadores.remover-especialidade');

        // Classes e Requisitos
        Route::prefix('classes')->name('classes.')->group(function () {
            Route::get('/', [ClassesController::class, 'index'])->name('index');
            Route::get('/{classe}', [ClassesController::class, 'show'])->name('show');
            Route::post('/toggle-requisito', [ClassesController::class, 'toggle'])->name('toggle');
        });

        // Frequência
        Route::prefix('frequencia')->name('frequencia.')->group(function () {
            Route::get('/', [FrequenciaController::class, 'index'])->name('index');
            Route::get('/chamada', [FrequenciaController::class, 'create'])->name('create');
            Route::post('/store', [FrequenciaController::class, 'store'])->name('store');
        });
    });

    // 6. FINANCEIRO (Caixa e Patrimônio)
    Route::middleware('can:financeiro')->group(function () {
        Route::resource('caixa', CaixaController::class);
        Route::resource('patrimonio', PatrimonioController::class);

        Route::get('mensalidades', [MensalidadeController::class, 'index'])->name('mensalidades.index');
        Route::post('mensalidades/gerar', [MensalidadeController::class, 'gerarMassivo'])->name('mensalidades.gerar');
        Route::post('mensalidades/{id}/pagar', [MensalidadeController::class, 'pagar'])->name('mensalidades.pagar');
    });

    // 7. EVENTOS
    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index'); // Listagem Geral

    Route::middleware('can:eventos')->group(function () {
        Route::get('/eventos/create', [EventoController::class, 'create'])->name('eventos.create');
        Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
        Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])->name('eventos.edit');
        Route::put('/eventos/{evento}', [EventoController::class, 'update'])->name('eventos.update');
        Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');

        // Gestão de Inscritos
        Route::post('eventos/{evento}/inscrever', [EventoController::class, 'inscrever'])->name('eventos.inscrever');
        Route::delete('eventos/{evento}/inscricao/{desbravador}', [EventoController::class, 'removerInscricao'])->name('eventos.remover-inscricao');
        Route::patch('eventos/{evento}/inscricao/{desbravador}', [EventoController::class, 'atualizarStatus'])->name('eventos.status');
        Route::get('eventos/{evento}/autorizacao/{desbravador}', [EventoController::class, 'gerarAutorizacao'])->name('eventos.autorizacao');
    });

    Route::get('/eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');

    // 8. RANKING (Gamificação)
    Route::prefix('ranking')->name('ranking.')->group(function () {
        Route::get('/unidades', [RankingController::class, 'unidades'])->name('unidades');
        Route::get('/desbravadores', [RankingController::class, 'desbravadores'])->name('desbravadores');
    });

    // 9. RELATÓRIOS
    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/', [RelatorioController::class, 'index'])->name('index');
        Route::post('/gerar-personalizado', [RelatorioController::class, 'gerarPersonalizado'])->name('custom');

        // Documentos Individuais
        Route::get('/autorizacao/{desbravador}', [RelatorioController::class, 'autorizacao'])->name('autorizacao');
        Route::get('/carteirinha/{desbravador}', [RelatorioController::class, 'carteirinha'])->name('carteirinha');
        Route::get('/ficha-medica/{desbravador}', [RelatorioController::class, 'fichaMedica'])->name('ficha-medica');

        // Relatórios Financeiros (Protegidos)
        Route::middleware('can:financeiro')->group(function () {
            Route::get('/financeiro', [RelatorioController::class, 'financeiro'])->name('financeiro');
            Route::get('/patrimonio', [RelatorioController::class, 'patrimonio'])->name('patrimonio');
        });
    });

});

require __DIR__.'/auth.php';
