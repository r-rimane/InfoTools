@extends('layouts.app')

@section('content')
<style>
    .edit-container {
        max-width: 600px;
        margin: 30px auto;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .edit-container h2 {
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
    form input[type="number"],
    form textarea {
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

    .back-btn {
        display: inline-block;
        margin-bottom: 15px;
        background-color: #2196f3;
        color: white;
        padding: 8px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .back-btn:hover {
        background-color: #1976d2;
    }
</style>

<div class="edit-container">

    <a href="{{ url()->previous() }}" class="back-btn">⬅ Retour</a>

    <h2>Modifier le prospect</h2>

    <form action="{{ route('prospects.update', $prospect->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $prospect->nom) }}" required>

        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $prospect->prenom) }}" required>

        <label for="entreprise">Entreprise</label>
        <input type="text" name="entreprise" id="entreprise" value="{{ old('entreprise', $prospect->entreprise) }}">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $prospect->email) }}" required>

        <label for="tel">Téléphone</label>
        <input type="text" name="tel" id="tel" value="{{ old('tel', $prospect->tel) }}">

        <label for="adresse">Adresse</label>
        <textarea name="adresse" id="adresse" rows="3">{{ old('adresse', $prospect->adresse) }}</textarea>

        <button type="submit">Mettre à jour</button>
    </form>
</div>
@endsection
