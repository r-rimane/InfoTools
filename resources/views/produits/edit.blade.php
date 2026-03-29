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

    .current-image {
        margin-bottom: 15px;
        text-align: center;
    }

    .current-image img {
        max-width: 200px;
        border-radius: 5px;
    }
</style>

<div class="edit-container">
    <h2>Modifier le produit</h2>

    <form action="{{ route('produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $produit->nom) }}" required>

        <label for="catégorie">Catégorie</label>
        <input type="text" name="catégorie" id="catégorie" value="{{ old('catégorie', $produit->catégorie) }}" required>

        <label for="prix">Prix (€)</label>
        <input type="number" name="prix" id="prix" value="{{ old('prix', $produit->prix) }}" step="0.01" required>

        <label for="stock">Stock</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', $produit->stock) }}" required>

        

        

        <button type="submit">Mettre à jour</button>
    </form>
</div>
@endsection
