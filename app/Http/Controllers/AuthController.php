<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * Contrôleur de gestion de l'authentification.
 * Gère l'inscription, la connexion personnalisée et la déconnexion des utilisateurs.
 */
class AuthController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     *
     * @return \Illuminate\View\View
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Traite la création d'un nouveau compte utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validation stricte des données d'inscription (Exigence Sécurité)
        $request->validate([
            'nom'         => 'required|string|max:255',
            'prenom'      => 'required|string|max:255',
            'identifiant' => 'required|string|max:255|unique:users',
            'mdp'         => 'required|string|min:6|confirmed', 
        ]);

        $user = User::create([
            'nom'         => $request->nom,
            'prenom'      => $request->prenom,
            'identifiant' => $request->identifiant,
            'mdp'         => bcrypt($request->mdp), // Hachage du mot de passe (Exigence Sécurité)
        ]);

        // Connexion automatique après inscription
        Auth::login($user);

        return redirect()->route('welcome');
    }

    /**
     * Affiche le formulaire de connexion.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Gère la tentative de connexion de l'utilisateur.
     * Utilise une logique personnalisée pour correspondre aux champs 'identifiant' et 'mdp'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'identifiant' => 'required|string',
            'mdp'         => 'required|string',
        ]);

        // Recherche de l'utilisateur par son identifiant unique
        $user = User::where('identifiant', $request->identifiant)->first();

        // Vérification manuelle du hachage du mot de passe (Exigence Sécurité)
        if ($user && Hash::check($request->mdp, $user->mdp)) {
            Auth::login($user);
            
            // Protection contre la fixation de session
            $request->session()->regenerate();
            
            return redirect()->intended(route('welcome'));
        }

        // Retour avec erreur en cas d'échec (Sécurité : message générique pour éviter l'énumération d'utilisateurs)
        return back()->withErrors([
            'identifiant' => 'Identifiant ou mot de passe incorrect.',
        ]);
    }

    /**
     * Déconnexion de l'utilisateur et sécurisation de la session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Destruction et régénération de la session pour la sécurité
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}