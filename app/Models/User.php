<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle User - Entité principale pour l'authentification et l'autorisation.
 * Définit les accès des commerciaux et la liaison avec leurs portefeuilles clients.
 */
class User extends Authenticatable
{
    use Notifiable, HasFactory;

    /**
     * Nom de la table associée au modèle.
     * @var string
     */
    protected $table = 'users';

    /**
     * Les attributs pouvant être assignés massivement.
     * @var array<int, string>
     */
    protected $fillable = [
        'identifiant', 
        'nom', 
        'prenom', 
        'mdp',
    ];

    /**
     * Redéfinition du champ de mot de passe pour l'authentification Laravel.
     * Permet d'utiliser la colonne 'mdp' au lieu du standard 'password'.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->mdp;
    }

    /**
     * Obtient la liste des clients rattachés à ce commercial.
     * Base du contrôle d'accès IDOR (Exigence Sécurité).
     * * @return HasMany
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Obtient l'historique des actions effectuées par cet utilisateur.
     * * @return HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }
}