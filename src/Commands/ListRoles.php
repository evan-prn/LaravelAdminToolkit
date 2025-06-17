<?php

namespace AdminToolkit\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ListRoles extends Command
{
    protected $signature = 'roles:list';
    protected $description = 'Liste les rôles et permissions existants dans l\'application';

    public function handle()
    {
        $this->info('📌 Rôles existants :');
        $roles = Role::all();

        if ($roles->isEmpty()) {
            $this->line('- Aucun rôle trouvé.');
        } else {
            foreach ($roles as $role) {
                $this->line("- {$role->name}");
            }
        }

        $this->info('📌 Permissions existantes :');
        $permissions = Permission::all();

        if ($permissions->isEmpty()) {
            $this->line('- Aucune permission trouvée.');
        } else {
            foreach ($permissions as $permission) {
                $this->line("- {$permission->name}");
            }
        }
    }
}
