<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes - Configuration de la Sécurité et des Ressources
|--------------------------------------------------------------------------
| Ce fichier définit les points d'entrée de l'API. Chaque route est 
| soumise à une limitation de débit (Throttling) pour prévenir les abus.
*/

/**
 * Groupe de routes protégé par le middleware de Throttling.
 * Définit une limite de 60 requêtes par minute (Exigence Sécurité : Limitation de débit).
 */
Route::middleware(['throttle:api'])->group(function () {
    
    /**
     * Routes CRUD pour la ressource Clients.
     * Gère les endpoints : GET, POST, PUT, DELETE sur /api/api-clients.
     */
    Route::apiResource('api-clients', ClientController::class);
    
});

/**
 * Endpoint de vérification d'authentification (Sanctum).
 * Permet de récupérer les informations de l'utilisateur via son Token.
 */
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');