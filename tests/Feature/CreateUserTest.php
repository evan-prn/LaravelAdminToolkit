<?php

namespace AdminToolkit\Tests\Feature;

use Orchestra\Testbench\TestCase;
use AdminToolkit\AdminToolkitServiceProvider;

class CreateUserTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [AdminToolkitServiceProvider::class];
    }

    /** @test */
    public function create_user_command_runs_without_error()
    {
        $this->artisan('user:create', [
            'email' => 'newuser@example.com',
            'password' => 'password123',
            '--name' => 'Test User'
        ])->assertExitCode(0);
    }
}
