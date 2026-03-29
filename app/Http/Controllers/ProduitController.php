<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Client;
use App\Models\Log;

/**
 * Contrôleur de gestion du catalogue produits.
 * Gère l'inventaire, le filtrage multicritère et la traçabilité des mouvements de stock.
 */
class ProduitController extends Controller
{
    /**
     * Liste et filtre les produits du catalogue.
     * Gère la recherche textuelle, les catégories, l'état du stock et le tri par prix.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Produit::query();

        // Recherche par nom de produit
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // Filtrage par catégorie
        if ($request->filled('categorie')) {
            $query->where('catégorie', $request->categorie);
        }

        // Filtrage selon la disponibilité du stock
        if ($request->stock === 'dispo') {
            $query->where('stock', '>', 0);
        } elseif ($request->stock === 'rupture') {
            $query->where('stock', 0);
        }

        // Tri par tarification
        if ($request->prix === 'asc') {
            $query->orderBy('prix', 'asc');
        } elseif ($request->prix === 'desc') {
            $query->orderBy('prix', 'desc');
        }

        $produits = $query->get();

        return view('produits.index', compact('produits'));
    }

    /**
     * Affiche la fiche détaillée d'un produit.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $produit = Produit::findOrFail($id);
        return view('produits.show', compact('produit'));
    }

    /**
     * Affiche le formulaire de création de produit.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('produits.create');
    }

    /**
     * Enregistre un nouveau produit et journalise l'entrée au catalogue.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation des données techniques et financières
        $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'catégorie'   => 'nullable|string',
            'prix'        => 'required|numeric',
            'stock'       => 'required|integer',
        ]);

        $produit = Produit::create($request->all());

        // Journalisation de la création (Audit Inventaire)
        Log::record('Création', "A ajouté le produit : {$produit->nom} (Stock initial: {$produit->stock})");

        return redirect()->route('produits.index')->with('success', 'Produit créé avec succès !');
    }

    /**
     * Affiche le formulaire de modification pour un produit existant.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $produit = Produit::findOrFail($id);
        return view('produits.edit', compact('produit'));
    }

    /**
     * Met à jour les informations d'un produit et trace la modification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom'         => 'required|string|max:255',
            'description' => 'nullable|string',
            'catégorie'   => 'nullable|string',
            'prix'        => 'required|numeric',
            'stock'       => 'required|integer',
        ]);

        $produit = Produit::findOrFail($id);
        $produit->update($request->all());

        // Journalisation de la mise à jour (Audit Inventaire)
        Log::record('Modification', "A mis à jour le produit : {$produit->nom}");

        return redirect()->route('produits.index')->with('success', 'Produit mis à jour !');
    }

    /**
     * Supprime un produit du catalogue et journalise l'action.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Produit $produit)
    {
        $nomProduit = $produit->nom;
        $produit->delete();

        // Journalisation de la suppression (Audit Inventaire)
        Log::record('Suppression', "A supprimé le produit : {$nomProduit}");

        return redirect()->route('produits.index')
            ->with('success', 'Produit supprimé avec succès !');
    }
}