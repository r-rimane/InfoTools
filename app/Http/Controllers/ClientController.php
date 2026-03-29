<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Produit;
use App\Models\Prospect;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Log;

/**
 * Contrôleur de gestion des clients (Interface Web).
 * Gère le cycle de vie des clients, le filtrage multicritère et l'audit des actions.
 */
class ClientController extends Controller
{
    /**
     * Liste et filtre les clients de la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Client::query();

        // Moteur de recherche par nom ou prénom
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");
            });
        }

        // Filtre par raison sociale (entreprise)
        if ($request->filled('entreprise')) {
            $query->where('entreprise', 'like', "%{$request->entreprise}%");
        }

        // Filtre par coordonnées (email ou téléphone)
        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->email}%");
        }

        if ($request->filled('tel')) {
            $query->where('tel', 'like', "%{$request->tel}%");
        }

        // Récupération des résultats triés par nom
        $clients = $query->orderBy('nom')->get();

        return view('clients.index', compact('clients'));
    }

    /**
     * Affiche le formulaire de création de client.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Enregistre un nouveau client et génère un log d'audit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'        => 'required|string|max:255',
            'prenom'     => 'required|string|max:255',
            'email'      => 'required|email',
            'tel'        => 'nullable|string|max:255',
            'entreprise' => 'nullable|string|max:255',
            'adresse'    => 'nullable|string',
        ]);

        $client = Client::create($request->all());

        // Journalisation de la création (Traçabilité)
        Log::record('Création', "A ajouté le client {$client->prenom} {$client->nom} (Entreprise: {$client->entreprise})");

        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès.');
    }

    /**
     * Affiche la fiche détaillée d'un client.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\View\View
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Affiche le formulaire d'édition d'un client.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\View\View
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Met à jour les informations d'un client et journalise l'action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nom'        => 'required|string|max:255',
            'prenom'     => 'required|string|max:255',
            'email'      => 'required|email',
            'tel'        => 'nullable|string|max:255',
            'entreprise' => 'nullable|string|max:255',
            'adresse'    => 'nullable|string',
        ]);

        $client->update($request->all());

        // Journalisation de la modification
        Log::record('Modification', "A modifié la fiche du client {$client->prenom} {$client->nom}");

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Supprime définitivement un client.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Client $client)
    {
        $nomComplet = "{$client->prenom} {$client->nom}";
        
        $client->delete();

        // Journalisation de la suppression (Audit de sécurité)
        Log::record('Suppression', "A supprimé définitivement le client : {$nomComplet}");

        return redirect()->route('clients.index')->with('success', 'Le client a été supprimé.');
    }
}