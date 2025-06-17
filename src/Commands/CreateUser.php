<?php

namespace AdminToolkit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateUser extends Command
{
    protected $signature = 'user:create
        {email : Email de l\'utilisateur}
        {password : Mot de passe de l\'utilisateur}
        {--name= : Nom de l\'utilisateur (optionnel)}';

    protected $description = 'Création rapide d\'un utilisateur avec email et mot de passe';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->option('name') ?? $email;

        if (User::where('email', $email)->exists()) {
            $this->error("L'utilisateur avec l'email {$email} existe déjà.");
            return;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("✅ Utilisateur {$user->email} créé avec succès.");
    }
}
