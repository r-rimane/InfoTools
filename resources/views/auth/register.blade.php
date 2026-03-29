@extends('layouts.app')

@section('content')
<style>
    .auth-container {
        max-width: 500px;
        margin: 40px auto;
        background-color: #f1f1f1;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .auth-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .auth-container label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .auth-container input {
        width: 100%;
        padding: 8px 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .auth-container button {
        width: 100%;
        padding: 10px;
        background-color: #ED2F36 ;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .auth-container button:hover {
        background-color: #F7C13C ;
    }

    .auth-container p {
        margin-top: 15px;
        text-align: center;
    }
</style>

<div class="auth-container">
    <h2>Inscription</h2>

    <form action="{{ route('register') }}" method="POST">
    @csrf

    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>

    <label for="prenom">Prénom</label>
    <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required>

    <label for="identifiant">Identifiant</label>
    <input type="text" name="identifiant" id="identifiant" value="{{ old('identifiant') }}" required>

    <label for="mdp">Mot de passe</label>
    <input type="password" name="mdp" id="mdp" required>

    <label for="mdp_confirmation">Confirmez le mot de passe</label>
    <input type="password" name="mdp_confirmation" id="mdp_confirmation" required>

    <button type="submit">S’inscrire</button>
</form>



    <p>
        Déjà inscrit ?
        <a href="{{ route('login') }}">Connexion</a>
    </p>
</div>
@endsection
