<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle Client - Représente l'entité client final dans le CRM.
 * Gère l'appartenance à un utilisateur (Commercial) et le lien avec les factures.
 */
class Client extends Model
{
    use HasFactory;

    /**
     * Nom de la table associée au modèle.
     * @var string
     */
    protected $table = 'client';

    /**
     * Indique si le modèle doit être horodaté.
     * @var bool
     */
    public $timestamps = false;

    /**
     * Les attributs pouvant être assignés massivement.
     * Inclut 'user_id' pour le contrôle d'accès (IDOR).
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'entreprise',
        'email',
        'tel',
        'adresse',
    ];

    /**
     * Obtient l'utilisateur (commercial) propriétaire de ce client.
     * * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtient la liste des factures associées au client.
     * Utilise la clé primaire personnalisée 'IdClient'.
     * * @return HasMany
     */
    public function factures(): HasMany
    {
        return $this->hasMany(Facture::class, 'client_id', 'IdClient');
    }
}