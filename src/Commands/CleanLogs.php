<?php

namespace AdminToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanLogs extends Command
{
    protected $signature = 'logs:clear';
    protected $description = 'Supprime tous les fichiers de logs Laravel (storage/logs)';

    public function handle()
    {
        $logPath = storage_path('logs');
        $files = File::glob($logPath . '/*.log');

        if (empty($files)) {
            $this->info('Aucun fichier de log à supprimer.');
            return;
        }

        foreach ($files as $file) {
            File::delete($file);
            $this->line("🗑️ Log supprimé : {$file}");
        }

        $this->info('✅ Tous les fichiers de logs ont été supprimés.');
    }
}
