<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use App\Models\Log;
use Illuminate\Http\Request;

/**
 * Contrôleur de gestion des prospects (Interface Web).
 * Gère l'acquisition de nouveaux contacts, le filtrage et la traçabilité des modifications.
 */
class ProspectController extends Controller
{
    /**
     * Liste et filtre les prospects.
     * Permet une recherche par entreprise, email et présence de coordonnées téléphoniques.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Prospect::query();

        // Filtre par raison sociale
        if ($request->filled('entreprise')) {
            $query->where('entreprise', 'like', '%' . $request->entreprise . '%');
        }

        // Filtre par adresse mail
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Filtre sur la présence ou l'absence de numéro de téléphone
        if ($request->filled('tel')) {
            if ($request->tel == '1') {
                $query->whereNotNull('tel');
            } else {
                $query->whereNull('tel');
            }
        }

        $prospects = $query->get();

        return view('prospects.index', compact('prospects'));
    }

    /**
     * Affiche le formulaire de création de prospect.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('prospects.create');
    }

    /**
     * Enregistre un nouveau prospect avec audit de création.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation des données (Exigence Sécurité : intégrité des données)
        $request->validate([
            'nom'    => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email'  => 'required|email|unique:prospect,email',
        ]);

        $prospect = Prospect::create($request->all());

        // Journalisation de l'action d'ajout (Traçabilité CRM)
        Log::record('Création', "A ajouté le prospect : {$prospect->prenom} {$prospect->nom} (Entreprise: {$prospect->entreprise})");

        return redirect()->route('prospects.index')
            ->with('success', 'Prospect créé avec succès !');
    }

    /**
     * Affiche la fiche détaillée d'un prospect.
     *
     * @param  \App\Models\Prospect  $prospect
     * @return \Illuminate\View\View
     */
    public function show(Prospect $prospect)
    {
        return view('prospects.show', compact('prospect'));
    }

    /**
     * Affiche le formulaire d'édition.
     *
     * @param  \App\Models\Prospect  $prospect
     * @return \Illuminate\View\View
     */
    public function edit(Prospect $prospect)
    {
        return view('prospects.edit', compact('prospect'));
    }

    /**
     * Met à jour un prospect et journalise l'audit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prospect  $prospect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Prospect $prospect)
    {
        $request->validate([
            'nom'    => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email'  => 'required|email|unique:prospect,email,' . $prospect->id,
        ]);

        $prospect->update($request->all());

        // Journalisation de la mise à jour (Traçabilité CRM)
        Log::record('Modification', "A mis à jour la fiche du prospect : {$prospect->prenom} {$prospect->nom}");

        return redirect()->route('prospects.index')
            ->with('success', 'Prospect mis à jour avec succès !');
    }

    /**
     * Supprime un prospect et archive l'action dans les logs.
     *
     * @param  \App\Models\Prospect  $prospect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Prospect $prospect)
    {
        $nomProspect = "{$prospect->prenom} {$prospect->nom}";
        
        $prospect->delete();

        // Journalisation de la suppression (Audit de sécurité)
        Log::record('Suppression', "A supprimé le prospect : {$nomProspect}");

        return redirect()->route('prospects.index')
            ->with('success', 'Prospect supprimé avec succès !');
    }
}