<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FactureController; // ➕ Ajouté
use App\Http\Controllers\AuthController;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Prospect;
use App\Models\Appointment;
use App\Models\Facture; // ➕ Ajouté

// 🟢 Routes publiques pour l'authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔒 Routes protégées par authentification
Route::middleware('auth')->group(function () {

    // 🏠 Page d’accueil
    Route::get('/', function () {
        $clients = Client::all();
        $produits = Produit::all();
        $prospects = Prospect::all();
        $appointments = Appointment::all();
        $factures = Facture::all(); // ➕ Ajouté

        $stats = [
            'totalClients' => $clients->count(),
            'totalProduits' => $produits->count(),
            'totalProspects' => $prospects->count(),
            'totalRendezVous' => $appointments->count(),
            'totalFactures' => $factures->count(), // ➕ Ajouté pour ton tableau de bord
        ];

        return view('welcome', compact('clients', 'produits', 'prospects', 'appointments', 'factures', 'stats'));
    })->name('welcome');

    // 👥 Clients
    Route::resource('clients', ClientController::class);

    // 🛒 Produits
    Route::resource('produits', ProduitController::class);

    // 📋 Prospects
    Route::resource('prospects', ProspectController::class);

    // 📅 Rendez-vous
    Route::resource('appointments', AppointmentController::class);

    // 🧾 Factures (Achats)
    Route::resource('factures', FactureController::class); // ➕ Ajouté
});