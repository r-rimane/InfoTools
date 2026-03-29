<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ressource de transformation pour l'entité Client.
 * Permet de formater les données renvoyées par l'API de manière normalisée.
 */
class ClientResource extends JsonResource
{
    /**
     * Transforme la ressource en tableau.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'nom'        => $this->nom,
            'prenom'     => $this->prenom,
            'entreprise' => $this->entreprise,
            'email'      => $this->email,
            'telephone'  => $this->tel,
            'adresse'    => $this->adresse,
            
            // Formatage de la date pour une meilleure lisibilité côté client API
            'cree_le'    => $this->created_at ? $this->created_at->format('d/m/Y H:i') : null,
        ];
    }
}