@extends('layouts.app')

@section('content')
<style>
    .create-container {
        max-width: 600px;
        margin: 30px auto;
        background-color: #f1f1f1;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .create-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="tel"] {
        width: 100%;
        padding: 8px 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    form button {
        padding: 10px 20px;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    form button:hover {
        background-color: #45a049;
    }
</style>

<div class="create-container">
    <h2>Ajouter un prospect</h2>

    <form action="{{ route('prospects.store') }}" method="POST">
        @csrf

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>

        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required>

        <label for="entreprise">Entreprise</label>
        <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise') }}">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="tel">Téléphone</label>
        <input type="tel" name="tel" id="tel" value="{{ old('tel') }}">

        <label for="adresse">Adresse</label>
        <input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}">

        <button type="submit">Ajouter le prospect</button>
    </form>
</div>
@endsection
