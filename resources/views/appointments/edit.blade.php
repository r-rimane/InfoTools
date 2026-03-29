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
    form input[type="datetime-local"],
    form textarea,
    form select {
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

    <a href="{{ route('appointments.index') }}" class="back-btn">⬅ Retour au planning</a>

    <h2>Modifier le rendez-vous</h2>

    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" value="{{ old('titre', $appointment->titre) }}" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" rows="3">{{ old('description', $appointment->description) }}</textarea>

        <label for="date_heure">Date et heure</label>
        <input type="datetime-local" name="date_heure" id="date_heure" 
               value="{{ old('date_heure', \Carbon\Carbon::parse($appointment->date_heure)->format('Y-m-d\TH:i')) }}" required>

        <label for="lieu">Lieu</label>
        <input type="text" name="lieu" id="lieu" value="{{ old('lieu', $appointment->lieu) }}">

        <label for="prospect_id">Prospect associé</label>
        <select name="prospect_id" id="prospect_id">
            <option value="">Aucun</option>
            @foreach($prospects as $prospect)
                <option value="{{ $prospect->id }}" {{ old('prospect_id', $appointment->prospect_id) == $prospect->id ? 'selected' : '' }}>
                    {{ $prospect->nom }} {{ $prospect->prenom }}
                </option>
            @endforeach
        </select>

        <button type="submit">Mettre à jour</button>
    </form>
</div>
@endsection
