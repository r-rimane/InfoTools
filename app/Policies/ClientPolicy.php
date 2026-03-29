<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Politique d'autorisation pour le modèle Client.
 * Garantit le cloisonnement des données (Anti-IDOR) : 
 * un utilisateur ne peut agir que sur les clients qui lui sont rattachés.
 */
class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut consulter les détails du client.
     * * @param  \App\Models\User  $user
     * @param  \App\Models\Client  $client
     * @return bool
     */
    public function view(User $user, Client $client): bool
    {
        // Comparaison stricte entre l'ID de l'utilisateur connecté et le propriétaire du client
        return $user->id === $client->user_id;
    }

    /**
     * Détermine si l'utilisateur peut modifier les informations du client.
     * Utilisé par le contrôleur API et Web pour valider l'accès.
     * * @param  \App\Models\User  $user
     * @param  \App\Models\Client  $client
     * @return bool
     */
    public function update(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer définitivement le client.
     * * @param  \App\Models\User  $user
     * @param  \App\Models\Client  $client
     * @return bool
     */
    public function delete(User $user, Client $client): bool
    {
        return $user->id === $client->user_id;
    }
}