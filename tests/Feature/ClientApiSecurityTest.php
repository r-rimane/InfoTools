<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * Suite de tests fonctionnels centrée sur la sécurité de l'API.
 * Vérifie la validation, les autorisations (IDOR), la journalisation et le throttling.
 */
class ClientApiSecurityTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * Configuration de l'environnement de test.
     * Prépare les tables nécessaires dans la base de données SQLite en mémoire.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Initialisation de la table 'client' pour les tests unitaires
        if (!Schema::hasTable('client')) {
            Schema::create('client', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable();
                $table->string('nom');
                $table->string('prenom');
                $table->string('email');
                $table->string('tel')->nullable();
                $table->timestamps();
            });
        }

        // Initialisation de la table 'logs' pour vérifier la journalisation
        if (!Schema::hasTable('logs')) {
            Schema::create('logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable();
                $table->string('action');
                $table->text('description')->nullable();
                $table->string('ip_address')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Test n°1 : Validation des données (Exigence Sécurité).
     * Vérifie que l'API rejette les requêtes incomplètes avec un code 422.
     */
    public function test_api_returns_422_on_invalid_data()
    {
        $user = User::create([
            'nom' => 'User', 'prenom' => 'Test', 'identifiant' => 'testuser',
            'email' => 'test@example.com', 'mdp' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user)->postJson('/api/api-clients', [
            'nom' => 'Incomplet',
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test n°2 : Contrôle d'accès et faille IDOR (Exigence Sécurité).
     * Vérifie qu'un utilisateur ne peut pas modifier les ressources d'un tiers.
     */
    public function test_user_cannot_update_other_users_client()
    {
        $owner = User::create([
            'nom' => 'Owner', 'prenom' => 'Jean', 'identifiant' => 'owner',
            'email' => 'owner@test.com', 'mdp' => Hash::make('password'),
        ]);

        $hacker = User::create([
            'nom' => 'Hacker', 'prenom' => 'Nolan', 'identifiant' => 'hacker',
            'email' => 'hacker@test.com', 'mdp' => Hash::make('password'),
        ]);
        
        $client = Client::create([
            'user_id' => $owner->id,
            'nom' => 'Bernard', 'prenom' => 'Jean', 'email' => 'jean@test.com',
        ]);

        $response = $this->actingAs($hacker)->putJson("/api/api-clients/{$client->id}", [
            'nom' => 'Piratage', 'prenom' => 'Jean', 'email' => 'jean@test.com'
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test n°3 : Journalisation / Audit (Exigence Journalisation).
     * Vérifie qu'une action sensible sur l'API génère bien une entrée en base de données.
     */
    public function test_api_action_records_a_log()
    {
        $user = User::create([
            'nom' => 'Logger', 'prenom' => 'User', 'identifiant' => 'logger' . time(),
            'email' => 'logger@test.com', 'mdp' => Hash::make('password'),
        ]);

        $this->actingAs($user)->postJson('/api/api-clients', [
            'nom' => 'NomTest',
            'prenom' => 'PrenomTest',
            'email' => 'unique' . time() . '@test.com',
        ]);

        $this->assertDatabaseHas('logs', [
            'action' => 'API_Création',
        ]);
    }

    /**
     * Test n°4 : Limitation de débit / Throttling (Exigence Sécurité).
     * Vérifie que l'API bloque les requêtes excessives (code 429).
     */
    public function test_api_throttling_is_active()
    {
        $user = User::create([
            'nom' => 'Throttler', 'prenom' => 'User', 'identifiant' => 'throttle',
            'email' => 'throttle@test.com', 'mdp' => Hash::make('password'),
        ]);
        
        // Simulation de 61 requêtes consécutives
        for ($i = 0; $i < 61; $i++) {
            $response = $this->actingAs($user)->getJson('/api/api-clients');
        }

        // Vérification de la restriction au-delà de la limite
        $response->assertStatus(429);
    }
}