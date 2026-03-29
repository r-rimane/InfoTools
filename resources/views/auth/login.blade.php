@extends('layouts.app')

@section('content')
<style>
    /* ... Tes styles restent identiques ... */
    .auth-container { max-width: 500px; margin: 40px auto; background-color: #f1f1f1; padding: 25px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .auth-container h2 { text-align: center; margin-bottom: 20px; color: #333; }
    .auth-container label { display: block; margin-bottom: 5px; font-weight: bold; }
    .auth-container input { width: 100%; padding: 8px 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
    .auth-container button { width: 100%; padding: 10px; background-color: #ED2F36; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
    .auth-container button:hover { background-color: #F7C13C; }
    .error { color: red; margin-bottom: 10px; text-align: center; }
</style>

<div class="auth-container">
    <h2>Connexion CRM</h2>

    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <label for="identifiant">Identifiant</label>
        <input type="text" name="identifiant" id="identifiant" value="{{ old('identifiant') }}" required>

        <label for="mdp">Mot de passe</label>
        <input type="password" name="mdp" id="mdp" required>

        <button type="submit">Se connecter</button>
    </form>

    {{-- Le lien d'inscription a été supprimé ici --}}
</div>
@endsection