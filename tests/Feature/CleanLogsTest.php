<?php

namespace AdminToolkit\Tests\Feature;

use Orchestra\Testbench\TestCase;
use AdminToolkit\AdminToolkitServiceProvider;

class CleanLogsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [AdminToolkitServiceProvider::class];
    }

    /** @test */
    public function clean_logs_command_runs_without_error()
    {
        $this->artisan('logs:clear')
            ->assertExitCode(0);
    }
}
