@extends('layouts.app')
@section('sidebar')
    <h2>Filtres clients</h2>

    <form method="GET" action="{{ route('clients.index') }}">

        <div class="stat-block">
            <strong>🔍 Recherche</strong>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Nom ou prénom"
                   style="width:100%; padding:6px; border-radius:6px;">
        </div>

        <div class="stat-block">
            <strong>🏢 Entreprise</strong>
            <input type="text"
                   name="entreprise"
                   value="{{ request('entreprise') }}"
                   placeholder="Nom de l'entreprise"
                   style="width:100%; padding:6px; border-radius:6px;">
        </div>

        <div class="stat-block">
            <strong>📧 Email</strong>
            <input type="text"
                   name="email"
                   value="{{ request('email') }}"
                   placeholder="Adresse email"
                   style="width:100%; padding:6px; border-radius:6px;">
        </div>

        <div class="stat-block">
            <strong>📞 Téléphone</strong>
            <input type="text"
                   name="tel"
                   value="{{ request('tel') }}"
                   placeholder="Numéro de téléphone"
                   style="width:100%; padding:6px; border-radius:6px;">
        </div>

        <button type="submit"
                style="width:100%; padding:10px; border:none; border-radius:10px;
                       background:#ff6600; color:white; font-weight:bold; margin-top:6px;">
            Appliquer
        </button>

        <button type="button"
        onclick="window.location='{{ route('clients.index') }}'"
        style="width:100%; padding:10px; border:none; border-radius:10px;
               background:#ff8533; color:white; font-weight:bold; margin-top:8px;">
    🔄 Réinitialiser
</button>


    </form>
@endsection

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    body {
        font-family: 'Madimi One', sans-serif;
        background-color: white;
        padding: 20px;
        box-sizing: border-box;
    }

    .blocks-container {
        display: flex;
        gap: 20px;
        height: calc(100vh - 80px);
    }

    .block {
        flex: 1;
        background-color: #f1f1f1;
        border-radius: 10px;
        padding: 10px;
        overflow-y: auto;
    }

    .block-title {
        font-weight: bold;
        font-size: 20px;
        color: #333;
        margin-bottom: 10px;
        text-shadow: 1px 1px 2px #ccc;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        text-align: left;
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    table tbody tr {
        transition: background-color 0.2s ease;
    }

    table tbody tr:hover {
        background-color: #d1e0ff;
        cursor: pointer;
    }

    /* --- Bouton retour stylisé --- */
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #2196f3;
        color: white;
        padding: 8px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .back-button:hover {
        background-color: #1976d2;
        transform: translateY(-2px);
    }

    .back-button svg {
        width: 18px;
        height: 18px;
    }

</style>

@if(session('success'))
    <div id="flash-message" style="
        background-color:#4caf50;
        color:white;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        font-weight: bold;
        text-align:center;
        opacity: 1;
        transition: opacity 0.5s ease-out;
    ">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            flash.style.opacity = 0;      // fade-out
            setTimeout(() => flash.remove(), 500); // suppression du DOM après fade-out
        }, 2000); // 2 secondes avant disparition
    </script>
@endif



<div class="blocks-container">
    <!-- Bloc gauche : liste complète des clients -->
    <div class="block">

     <!-- Boutons retour + ajouter -->
<div class="top" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
    <!-- Bouton retour à gauche -->
    <a href="{{ route('welcome') }}" class="back-button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Retour
    </a>

    <!-- Bouton ajouter à droite -->
    <a href="{{ route('clients.create') }}" class="back-button" style="background-color:#4caf50;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Ajouter un client
    </a>
</div>


        <div class="block-title">Clients</div>

        <table>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Entreprise</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $index => $client)
                    <tr onclick="showClientInRightBlock({{ $client->toJson() }})">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $client->nom }}</td>
                        <td>{{ $client->prenom }}</td>
                        <td>{{ $client->entreprise ?? '-' }}</td>
                        
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bloc droit : affichage du client sélectionné -->
    <div class="block" id="selected-client-block">
        <div class="block-title">Détails du client</div>
        <div id="client-details" style="margin-top:10px;">
            <p>Cliquez sur un client à gauche pour voir les détails ici.</p>
        </div>
    </div>
</div>

<script>
function showClientInRightBlock(client) {
    const container = document.getElementById('client-details');

    container.innerHTML = `
        <p style="background-color:#d1e0ff; padding:8px; border-radius:8px;"><strong>Nom :</strong> ${client.nom}</p>
        <p style="background-color:#d1e0ff; padding:8px; border-radius:8px;"><strong>Prénom :</strong> ${client.prenom}</p>
        <p style="background-color:#b3c6ff; padding:8px; border-radius:8px;"><strong>Entreprise :</strong> ${client.entreprise ?? '-'}</p>
        <p style="background-color:#d1e0ff; padding:8px; border-radius:8px;"><strong>Email :</strong> ${client.email}</p>
        <p style="background-color:#b3c6ff; padding:8px; border-radius:8px;"><strong>Téléphone :</strong> ${client.tel ?? '-'}</p>
        <p style="background-color:#d1e0ff; padding:8px; border-radius:8px;"><strong>Adresse :</strong> ${client.adresse ?? '-'}</p>

        <div style="margin-top:10px; display:flex; gap:10px;">
            <a href="/clients/${client.id}/edit" style="padding:8px 12px; border-radius:5px; background-color:#4caf50; color:white; text-decoration:none;">
                ✏️ Modifier
            </a>

            <form action="/clients/${client.id}" method="POST" 
      onsubmit="return confirm('Es-tu sûr de vouloir supprimer ce client ? Cette action est irréversible.');" 
      style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" 
        style="padding:8px 12px; border:none; border-radius:5px; background-color:#f44336; color:white; cursor:pointer;">
        🗑️ Supprimer
    </button>
</form>

        </div>
    `;
}
</script>
@endsection
