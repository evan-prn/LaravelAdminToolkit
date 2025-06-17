<?php

namespace AdminToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignRolePermission extends Command
{
    protected $signature = 'user:assign
        {user : ID ou email de l\'utilisateur}
        {--role=* : Rôles à attribuer}
        {--permission=* : Permissions à attribuer}
        {--remove : Supprime les rôles et permissions existants avant attribution}
        {--create : Crée les rôles ou permissions manquants}';

    protected $description = 'Assigne des rôles et permissions à un utilisateur avec création automatique et audit';

    public function handle()
    {
        $userInput = $this->argument('user');

        $user = is_numeric($userInput)
            ? User::find($userInput)
            : User::where('email', $userInput)->first();

        if (!$user) {
            $this->error("❌ Utilisateur non trouvé.");
            return;
        }

        $this->line("ℹ️ Utilisateur sélectionné : {$user->email} (ID: {$user->id})");
        $this->displayCurrentRolesAndPermissions($user);

        $roles = $this->option('role');
        $permissions = $this->option('permission');
        $create = $this->option('create');

        if ($this->option('remove')) {
            $user->syncRoles([]);
            $user->syncPermissions([]);
            $this->info("🧹 Rôles et permissions existants supprimés.");
            Log::info("[AssignRolePermission] Rôles et permissions supprimés pour {$user->email}.");
        }

        foreach ($roles as $role) {
            if (!Role::where('name', $role)->exists()) {
                if ($create) {
                    Role::create(['name' => $role]);
                    $this->info("✅ Rôle '{$role}' créé.");
                    Log::info("[AssignRolePermission] Rôle '{$role}' créé.");
                } else {
                    $this->warn("⚠️ Le rôle '{$role}' n'existe pas. Utilise --create pour le créer.");
                    continue;
                }
            }
            $user->assignRole($role);
            $this->info("🔐 Rôle '{$role}' assigné.");
            Log::info("[AssignRolePermission] Rôle '{$role}' assigné à {$user->email}.");
        }

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                if ($create) {
                    Permission::create(['name' => $permission]);
                    $this->info("✅ Permission '{$permission}' créée.");
                    Log::info("[AssignRolePermission] Permission '{$permission}' créée.");
                } else {
                    $this->warn("⚠️ La permission '{$permission}' n'existe pas. Utilise --create pour la créer.");
                    continue;
                }
            }
            $user->givePermissionTo($permission);
            $this->info("🔑 Permission '{$permission}' assignée.");
            Log::info("[AssignRolePermission] Permission '{$permission}' assignée à {$user->email}.");
        }

        $this->info("🎯 Attribution terminée pour l'utilisateur : {$user->email}");
        $this->displayCurrentRolesAndPermissions($user, "📊 Récapitulatif après modification :");
    }

    protected function displayCurrentRolesAndPermissions(User $user, $title = "📊 Rôles et permissions actuels :")
    {
        $this->line($title);
        $roles = $user->getRoleNames();
        $permissions = $user->getPermissionNames();

        $this->line("Rôles      : " . ($roles->isEmpty() ? 'Aucun' : $roles->implode(', ')));
        $this->line("Permissions: " . ($permissions->isEmpty() ? 'Aucune' : $permissions->implode(', ')));
    }

    public function completeOptionValues($optionName, array $input): array
    {
        if ($optionName === 'role') {
            return Role::pluck('name')->toArray();
        }

        if ($optionName === 'permission') {
            return Permission::pluck('name')->toArray();
        }

        return [];
    }
}
