<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle Appointment - Représente un rendez-vous dans le système.
 * Gère les relations avec les prospects et les clients.
 */
class Appointment extends Model
{
    /**
     * Nom de la table associée au modèle.
     * @var string
     */
    protected $table = 'rendezvous';

    /**
     * Indique si le modèle doit être horodaté (created_at/updated_at).
     * @var bool
     */
    public $timestamps = false;

    /**
     * Les attributs pouvant être assignés massivement.
     * @var array<int, string>
     */
    protected $fillable = [
        'titre', 
        'description', 
        'date_heure', 
        'lieu', 
        'prospect_id', 
        'client_id'
    ];

    /**
     * Obtient le prospect associé au rendez-vous.
     * * @return BelongsTo
     */
    public function prospect(): BelongsTo
    {
        return $this->belongsTo(Prospect::class, 'prospect_id');
    }

    /**
     * Obtient le client associé au rendez-vous.
     * * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}