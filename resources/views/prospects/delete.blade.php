@extends('layouts.app')

@section('content')
<style>
    .delete-container {
        max-width: 500px;
        margin: 50px auto;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        text-align: center;
    }

    .delete-container h2 {
        margin-bottom: 20px;
        color: #c0392b;
    }

    .delete-container p {
        margin-bottom: 30px;
        color: #333;
    }

    .delete-container form button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        margin: 0 10px;
        cursor: pointer;
    }

    .delete-btn {
        background-color: #c0392b;
        color: white;
    }

    .delete-btn:hover {
        background-color: #a93226;
    }

    .cancel-btn {
        background-color: #bdc3c7;
        color: black;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }

    .cancel-btn:hover {
        background-color: #95a5a6;
    }
</style>

<div class="delete-container">
    <h2>Supprimer le prospect</h2>
    <p>Voulez-vous vraiment supprimer le prospect <strong>{{ $prospect->nom }} {{ $prospect->prenom }}</strong> ? Cette action est irréversible.</p>

    <form action="{{ route('prospects.destroy', $prospect->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-btn">Supprimer</button>
        <a href="{{ route('prospects.index') }}" class="cancel-btn">Annuler</a>
    </form>
</div>
@endsection
