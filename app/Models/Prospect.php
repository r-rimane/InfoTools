<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modèle Prospect - Représente un contact commercial potentiel.
 * Gère les informations de prospection avant la conversion en client.
 */
class Prospect extends Model
{
    use HasFactory;

    /**
     * Nom de la table associée au modèle.
     * @var string
     */
    protected $table = 'prospect';

    /**
     * Indique si le modèle doit être horodaté.
     * @var bool
     */
    public $timestamps = false;

    /**
     * Les attributs pouvant être assignés massivement.
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'tel',
        'entreprise',
        'adresse',
    ];

    /**
     * Obtient les rendez-vous associés à ce prospect.
     * * @return HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'prospect_id');
    }
}