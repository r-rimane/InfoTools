<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Log;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Gestionnaire des ressources Clients via l'API.
 * Intègre le contrôle d'accès (Policies), la validation et la journalisation.
 */
class ClientController extends Controller
{
    use AuthorizesRequests;

    /**
     * Liste tous les clients.
     * * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ClientResource::collection(Client::all());
    }

    /**
     * Création d'un nouveau client avec journalisation.
     * * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validation des données entrantes (Exigence Sécurité)
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:client,email',
            'tel' => 'nullable|string',
        ]);

        // Association automatique du client à l'utilisateur connecté
        $data = $request->all();
        $data['user_id'] = auth()->id() ?? 1;

        $client = Client::create($data);

        // Enregistrement de l'action dans les logs d'audit (Exigence Journalisation)
        Log::record('API_Création', "Client {$client->nom} créé via l'API");

        return (new ClientResource($client))
                ->response()
                ->setStatusCode(201);
    }

    /**
     * Affiche les détails d'un client spécifique.
     * * @param  \App\Models\Client  $client
     * @return \App\Http\Resources\ClientResource
     */
    public function show(Client $client)
    {
        return new ClientResource($client);
    }

    /**
     * Mise à jour d'un client avec vérification des droits (IDOR).
     * * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \App\Http\Resources\ClientResource
     */
    public function update(Request $request, Client $client)
    {
        // Vérification de la Policy (Sécurité : Empêche un utilisateur de modifier les données d'autrui)
        $this->authorize('update', $client); 

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:client,email,' . $client->id,
        ]);

        $client->update($request->all());

        // Journalisation de la modification
        Log::record('API_Modification', "Client {$client->nom} modifié via l'API");

        return new ClientResource($client);
    }

    /**
     * Suppression d'un client.
     * * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Client $client)
    {
        $nom = $client->nom;
        $client->delete();

        // Journalisation de la suppression
        Log::record('API_Suppression', "Client {$nom} supprimé via l'API");

        return response()->json(['message' => 'Client supprimé'], 200);
    }
}