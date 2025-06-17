<?php

namespace AdminToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TruncateTables extends Command
{
    protected $signature = 'db:truncate
        {tables?* : Les tables à truncater (autocomplétion disponible)}
        {--all : Truncate toutes les tables de la base}
        {--force : Exécute sans confirmation}
        {--list : Affiche la liste des tables disponibles}
        {--pretend : Simule sans rien exécuter}';

    protected $description = 'Truncate des tables spécifiques ou toutes les tables avec sécurité maximale, logs, dry-run et listing des tables.';

    public function handle(): void
    {
        if ($this->option('list')) {
            $this->listAllTables();
            return;
        }

        $tables = $this->resolveTables();

        if (empty($tables)) {
            return;
        }

        if ($this->option('pretend')) {
            $this->simulateTruncate($tables);
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            try {
                DB::table($table)->truncate();
                $this->info("✅ Table '{$table}' truncatée.");
                Log::info("[TruncateTables] Table '{$table}' truncatée.");
            } catch (\Exception $e) {
                $this->error("❌ Erreur sur '{$table}': " . $e->getMessage());
                Log::error("[TruncateTables] Erreur sur '{$table}': " . $e->getMessage());
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->info('🚀 Truncate terminé.');
    }

    protected function resolveTables(): array
    {
        if ($this->option('all')) {
            $tables = array_diff($this->getAllTables(), $this->getProtectedTables());

            if (empty($tables)) {
                $this->error('Aucune table à truncater (tout est protégé).');
                return [];
            }

            if (!$this->option('force') && !$this->confirm("⚠️ Confirmer le truncate de TOUTES ces tables : [ " . implode(', ', $tables) . " ] ?", false)) {
                $this->info('Opération annulée.');
                return [];
            }
        } else {
            $tables = array_diff($this->argument('tables'), $this->getProtectedTables());

            if (empty($tables)) {
                $this->warn('Toutes les tables spécifiées sont protégées ou non spécifiées, rien à faire.');
                return [];
            }

            if (!$this->option('force') && !$this->confirm("⚠️ Confirmer le truncate de ces tables : [ " . implode(', ', $tables) . " ] ?", false)) {
                $this->info('Opération annulée.');
                return [];
            }
        }

        return $tables;
    }

    protected function simulateTruncate(array $tables): void
    {
        $this->info('Simulation uniquement (aucune donnée supprimée) :');
        foreach ($tables as $table) {
            $this->line("💡 Pretend: table '{$table}' aurait été truncatée.");
        }
    }

    protected function getAllTables(): array
    {
        $database = DB::getDatabaseName();

        return DB::table('information_schema.tables')
            ->where('table_schema', $database)
            ->pluck('table_name')
            ->toArray();
    }

    protected function getProtectedTables(): array
    {
        return config('admin-toolkit.protected_tables', []);
    }

    protected function listAllTables(): void
    {
        $tables = $this->getAllTables();

        if (empty($tables)) {
            $this->warn("Aucune table trouvée dans la base de données.");
            return;
        }

        $this->info("Liste des tables dans la base de données :");
        foreach ($tables as $table) {
            $protected = in_array($table, $this->getProtectedTables()) ? ' (protégée)' : '';
            $this->line("- {$table}{$protected}");
        }
    }

    public function completeArgument(string $argumentName, array $input): array
    {
        return $argumentName === 'tables' ? $this->getAllTables() : [];
    }
}
