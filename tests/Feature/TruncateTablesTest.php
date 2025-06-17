<?php

namespace AdminToolkit\Tests\Feature;

use Orchestra\Testbench\TestCase;
use AdminToolkit\AdminToolkitServiceProvider;
use Illuminate\Support\Facades\DB;

class TruncateTablesTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            AdminToolkitServiceProvider::class,
        ];
    }

    /** @test */
    public function it_runs_list_option_without_errors()
    {
        $this->artisan('db:truncate --list')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_runs_pretend_option_without_errors()
    {
        $this->artisan('db:truncate --all --pretend')
            ->assertExitCode(0);
    }
}
