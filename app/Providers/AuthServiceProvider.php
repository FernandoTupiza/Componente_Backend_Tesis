<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Providers para la gestion de carreras

        Gate::define('gestion-carreras-admin', function (User $user) {
            return $user->role->slug === 'admin'
                        ? Response::allow()
                        : Response::deny('Acción no autorizada para usuarios con rol estudiante.');
        });

        Gate::define('gestion-carreras', function (User $user) {
            return $user->role->slug === 'admin'
                        ? Response::allow()
                        : Response::deny('Usted debe se un administrador para realizar esta tarea.');
        });



        //Providers para la gestion de semestres

        Gate::define('gestion-semestres', function (User $user) {
            return $user->role->slug === 'admin'
                        ? Response::allow()
                        : Response::deny('Usted debe se un administrador para realizar esta tarea.');
        });
        
        Gate::define('gestion-semestres-admin', function (User $user) {
            return $user->role->slug === 'admin'
                        ? Response::allow()
                        : Response::deny('Accion no autorizada para usuarios con rol estudiante.');
        });


        //Providers para la gestion de materias

        Gate::define('gestion-materias', function (User $user) {
            return $user->role->slug === 'admin'
                        ? Response::allow()
                        : Response::deny('Usted debe se un administrador para realizar esta tarea.');
        });
        
        Gate::define('gestion-materias-admin', function (User $user) {
            return $user->role->slug === 'admin'
                        ? Response::allow()
                        : Response::deny('Accion no autorizada para usuarios con rol estudiante.');
        });

        //Providers para la gestion de documentos

        Gate::define('gestion-documentos', function (User $user) {
            return $user->role->slug === 'admin'
                        ? Response::allow()
                        : Response::deny('Usted debe se un administrador para realizar esta tarea.');
        });
        
        Gate::define('gestion-documentos-admin', function (User $user) {
            return $user->role->slug === 'admin'
                        ? Response::allow()
                        : Response::deny('Accion no autorizada para usuarios con rol estudiante.');
        });
        


    }
}
