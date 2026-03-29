<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle Facture - Représente une transaction commerciale.
 * Fait le lien entre un client, un produit et les détails de l'achat.
 */
class Facture extends Model
{
    /**
     * Nom de la table associée au modèle.
     * @var string
     */
    protected $table = 'facture';

    /**
     * Les attributs pouvant être assignés massivement.
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id', 
        'produit_id', 
        'quantite', 
        'montant', 
        'date_achat'
    ];

    /**
     * Obtient le client associé à cette facture.
     * * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Obtient le produit concerné par cette facture.
     * * @return BelongsTo
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}