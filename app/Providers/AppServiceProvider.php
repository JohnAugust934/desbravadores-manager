<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate global: Super Admin passa por cima de tudo
        Gate::before(function (User $user, $ability) {
            if ($user->is_super_admin) {
                return true;
            }
        });

        // 1. Regra: A Acesso Geral de DIRETOR
        Gate::define('gerenciar-tudo', function (User $user) {
            return $user->role === 'diretor';
        });

        // 2. Regra: Acesso a SECRETARIA (Diretor ou Secretário)
        Gate::define('acessar-secretaria', function (User $user) {
            return in_array($user->role, ['diretor', 'secretario']);
        });

        // 3. Regra: Acesso a TESOURARIA (Diretor ou Tesoureiro)
        Gate::define('acessar-tesouraria', function (User $user) {
            return in_array($user->role, ['diretor', 'tesoureiro']);
        });

        // 4. Regra: Acesso a PATRIMÔNIO (Diretor, Tesoureiro ou Secretário)
        // Geralmente patrimônio fica com tesouraria ou secretaria dependendo do clube
        Gate::define('acessar-patrimonio', function (User $user) {
            return in_array($user->role, ['diretor', 'tesoureiro', 'secretario']);
        });
    }
}
