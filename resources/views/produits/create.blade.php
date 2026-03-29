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
    form input[type="number"],
    form textarea {
        width: 100%;
        padding: 8px 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    form input[type="file"] {
        margin-bottom: 15px;
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
    <h2>Ajouter un produit</h2>

    <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>

        <label for="catégorie">Catégorie</label>
        <input type="text" name="catégorie" id="catégorie" value="{{ old('catégorie') }}" required>

        <label for="prix">Prix (€)</label>
        <input type="number" name="prix" id="prix" value="{{ old('prix') }}" step="0.01" required>

        <label for="stock">Stock</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required>

        

        <button type="submit">Ajouter le produit</button>
    </form>
</div>
@endsection
