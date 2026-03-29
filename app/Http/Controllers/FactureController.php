<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;

/**
 * Contrôleur de gestion des factures.
 * Permet le suivi des transactions, la liaison client-produit et le filtrage des ventes.
 */
class FactureController extends Controller
{
    /**
     * Liste et filtre les factures avec chargement des relations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Optimisation de la requête avec les relations client et produit
        $query = Facture::with(['client', 'produit']);

        // Recherche par nom ou prénom du client lié
        if ($request->filled('search_client')) {
            $search = $request->input('search_client');
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('Nom', 'like', "%{$search}%")
                  ->orWhere('Prenom', 'like', "%{$search}%");
            });
        }

        // Filtre par date d'achat précise
        if ($request->filled('date')) {
            $query->whereDate('date_achat', $request->date);
        }

        // Filtre par montant minimum (seuil de facturation)
        if ($request->filled('montant_min')) {
            $query->where('montant', '>=', $request->montant_min);
        }

        // Récupération des factures classées par date de création décroissante
        $factures = $query->orderBy('date_achat', 'desc')->get();

        return view('factures.index', compact('factures'));
    }

    /**
     * Affiche le formulaire de création de facture.
     * Récupère les listes nécessaires pour les sélecteurs de la vue.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $clients = Client::orderBy('Nom')->get();
        $produits = Produit::all(); 

        return view('factures.create', compact('clients', 'produits'));
    }

    /**
     * Enregistre une nouvelle facture après validation des contraintes d'intégrité.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id'  => 'required|exists:client,IdClient',
            'produit_id' => 'required|exists:produit,Id',
            'quantite'   => 'required|integer|min:1',
            'montant'    => 'required|numeric|min:0',
            'date_achat' => 'required|date',
        ]);

        Facture::create($request->all());

        return redirect()->route('factures.index')->with('success', 'Facture enregistrée avec succès.');
    }

    /**
     * Affiche les détails d'une facture spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $facture = Facture::with(['client', 'produit'])->findOrFail($id);
        return view('factures.show', compact('facture'));
    }

    /**
     * Affiche le formulaire d'édition pour une facture existante.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $facture = Facture::findOrFail($id);
        $clients = Client::orderBy('Nom')->get();
        $produits = Produit::all();

        return view('factures.edit', compact('facture', 'clients', 'produits'));
    }

    /**
     * Met à jour les informations d'une facture.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $facture = Facture::findOrFail($id);

        $request->validate([
            'client_id'  => 'required|exists:client,IdClient',
            'produit_id' => 'required|exists:produit,Id',
            'quantite'   => 'required|integer|min:1',
            'montant'    => 'required|numeric|min:0',
            'date_achat' => 'required|date',
        ]);

        $facture->update($request->all());

        return redirect()->route('factures.index')->with('success', 'Facture mise à jour.');
    }

    /**
     * Supprime une facture de la base de données.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $facture = Facture::findOrFail($id);
        $facture->delete();

        return redirect()->route('factures.index')->with('success', 'Facture supprimée.');
    }
}