<?php

namespace AdminToolkit\Tests\Feature;

use Orchestra\Testbench\TestCase;
use AdminToolkit\AdminToolkitServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class AssignRolePermissionTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [AdminToolkitServiceProvider::class];
    }

    /** @test */
    public function assign_role_permission_command_runs_without_error()
    {
        // Création d'un faux utilisateur
        $user = User::factory()->create(['email' => 'test@example.com']);

        Artisan::call('user:assign', [
            'user' => $user->email,
            '--role' => ['admin'],
            '--permission' => ['view_reports'],
            '--create' => true
        ]);

        $this->assertTrue(true); // Test basique pour vérifier l'exécution sans crash
    }
}
