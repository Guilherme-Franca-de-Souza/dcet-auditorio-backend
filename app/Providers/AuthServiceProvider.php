<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Libraries\Enums\ActionsEnum;
use App\Libraries\Enums\RolesEnum;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use ReflectionClass;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        foreach ((new ReflectionClass(ActionsEnum::class))->getConstants() as $action) {
            \Gate::define($action, function ($user) use ($action) {
                return $this->verifyPermissionByRole($user->role, $action);
            });
        }
    }

    private function verifyPermissionByRole(string $role, string $action): bool
    {
        // Define as permissões para cada role
        $rolesPermissoes = [
            RolesEnum::PROFESSOR => [
                ActionsEnum::VERIFY_DISPONIBILITY,  
            ],
            RolesEnum::COORDINATOR => [
                ActionsEnum::VERIFY_DISPONIBILITY,  
            ],
            RolesEnum::TECHNICIAN => [
                ActionsEnum::VERIFY_DISPONIBILITY,  
            ],
        ];

        // Verifica se a ação está permitida para o role
        return in_array($action, $rolesPermissoes[$role] ?? []);
    }
}
