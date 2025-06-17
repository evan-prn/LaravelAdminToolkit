<?php

namespace AdminToolkit;

use Illuminate\Support\ServiceProvider;
use AdminToolkit\Commands\TruncateTables;
use AdminToolkit\Commands\AssignRolePermission;
use AdminToolkit\Commands\CreateUser;
use AdminToolkit\Commands\ListRoles;
use AdminToolkit\Commands\CleanLogs;

class AdminToolkitServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admin-toolkit.php', 'admin-toolkit');
    }

    public function boot()
    {
        // Publication de la config
        $this->publishes([
            __DIR__ . '/../config/admin-toolkit.php' => config_path('admin-toolkit.php'),
        ], 'admin-toolkit-config');

        // Enregistrement des commandes artisan
        if ($this->app->runningInConsole()) {
            $this->commands([
                TruncateTables::class,
                AssignRolePermission::class,
                CreateUser::class,
                ListRoles::class,
                CleanLogs::class,
            ]);
        }
    }
}
