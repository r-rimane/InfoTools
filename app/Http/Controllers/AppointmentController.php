<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Prospect;
use App\Models\Log;
use Illuminate\Http\Request;

/**
 * Contrôleur de gestion des rendez-vous (Web).
 * Gère la planification, le filtrage et le suivi des rendez-vous prospects/clients.
 */
class AppointmentController extends Controller
{
    /**
     * Liste et filtre les rendez-vous.
     * Inclut un moteur de recherche par nom, date, heure et type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Chargement des relations pour optimiser les requêtes (Eager Loading)
        $query = Appointment::with(['prospect', 'client']);

        // Recherche textuelle par nom ou prénom du prospect associé
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('prospect', function($sq) use ($search) {
                    $sq->where('nom', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%");
                });
            });
        }

        // Filtre calendaire (Date précise)
        if ($request->filled('date')) {
            $query->whereDate('date_heure', $request->date);
        }

        // Filtre horaire
        if ($request->filled('time')) {
            $query->whereTime('date_heure', $request->time);
        }

        // Filtre par catégorie de contact
        if ($request->filled('type') && $request->type === 'prospect') {
            $query->whereNotNull('prospect_id');
        }

        $appointments = $query->orderBy('date_heure', 'asc')->get();

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Affiche le formulaire de création de rendez-vous.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $prospects = Prospect::all();
        return view('appointments.create', compact('prospects'));
    }

    /**
     * Enregistre un nouveau rendez-vous avec traçabilité.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre'      => 'required|string|max:255',
            'date_heure' => 'required|date',
        ]);

        $appointment = Appointment::create($request->all());

        // Journalisation de la planification (Audit)
        Log::record('Création', "A planifié le RDV : {$appointment->titre} le {$appointment->date_heure}");

        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous créé avec succès !');
    }

    /**
     * Affiche les détails d'un rendez-vous.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\View\View
     */
    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Affiche le formulaire d'édition.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\View\View
     */
    public function edit(Appointment $appointment)
    {
        $prospects = Prospect::all();
        return view('appointments.edit', compact('appointment', 'prospects'));
    }

    /**
     * Met à jour un rendez-vous et trace la modification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'titre'      => 'required|string|max:255',
            'date_heure' => 'required|date',
        ]);

        $appointment->update($request->all());

        // Journalisation de la modification (Audit)
        Log::record('Modification', "A modifié le RDV : {$appointment->titre} (Prévu le {$appointment->date_heure})");

        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous mis à jour avec succès !');
    }

    /**
     * Supprime/Annule un rendez-vous.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Appointment $appointment)
    {
        $titreRdv = $appointment->titre;
        $dateRdv  = $appointment->date_heure;
        
        $appointment->delete();

        // Journalisation de la suppression (Audit)
        Log::record('Suppression', "A annulé/supprimé le RDV : {$titreRdv} du {$dateRdv}");

        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous supprimé avec succès !');
    }
}