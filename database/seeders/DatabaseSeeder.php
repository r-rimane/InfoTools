<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Prospect;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 👤 Utilisateur par défaut
        User::create([
            'nom' => 'Rimane',
            'prenom' => 'Rayan',
            'identifiant' => 'rayan',
            'mdp' => Hash::make('12345678'),
        ]);
        Client::factory(10)->create();
        Produit::factory(10)->create();
        Prospect::factory(10)->create();
        Appointment::factory(15)->create();
        
    }
}
