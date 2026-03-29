<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modèle Log - Gère la traçabilité et l'audit des actions utilisateurs.
 * Permet de conserver un historique des créations, modifications et suppressions.
 */
class Log extends Model
{
    /**
     * Les attributs pouvant être assignés massivement.
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 
        'action', 
        'description', 
        'ip_address'
    ];

    /**
     * Enregistre une action spécifique dans la base de données.
     * Cette méthode centralise la capture du contexte (Utilisateur, IP).
     *
     * @param  string  $action      Type d'action (ex: 'Création', 'API_Modification')
     * @param  string  $description Détails textuels de l'opération
     * @return self
     */
    public static function record($action, $description)
    {
        return self::create([
            // Récupère l'ID de l'utilisateur connecté ou l'ID 1 (Administrateur) par défaut
            'user_id'     => auth()->id() ?? 1,
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }

    /**
     * Obtient l'utilisateur auteur de l'action journalisée.
     * * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}