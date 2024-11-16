<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateDefaultUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a default admin user for the application';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        User::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'adresse' => '123 Rue Exemple, Paris',
            'role' => 'admin',
            'dateNaiss' => '1990-05-15',
            'lieuNaiss' => 'Paris',
            'mail' => 'ma@gmail.com',
            'photo' => 'storage/pputi.png',
            'phone' => '0123456789',
            'password' => bcrypt('passer'), // Assurez-vous de hacher le mot de passe
        ]);

        $this->info('Utilisateur par défaut créé avec succès.');
    }
}
