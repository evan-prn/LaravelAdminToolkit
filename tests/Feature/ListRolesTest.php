<?php

namespace AdminToolkit\Tests\Feature;

use Orchestra\Testbench\TestCase;
use AdminToolkit\AdminToolkitServiceProvider;

class ListRolesTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [AdminToolkitServiceProvider::class];
    }

    /** @test */
    public function list_roles_command_runs_without_error()
    {
        $this->artisan('roles:list')
            ->assertExitCode(0);
    }
}
