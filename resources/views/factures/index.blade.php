@extends('layouts.app')

@section('content')
<style>
    .blocks-container {
        display: flex;
        gap: 20px;
        height: calc(100vh - 80px);
    }

    .block {
        flex: 1;
        background-color: #f1f1f1;
        border-radius: 10px;
        padding: 15px;
        overflow-y: auto;
    }

    .block-title {
        font-weight: bold;
        font-size: 20px;
        color: #333;
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        text-align: left;
        padding: 12px;
        border-bottom: 1px solid #ccc;
    }

    table tbody tr {
        transition: background-color 0.2s ease;
        cursor: pointer;
    }

    table tbody tr:hover {
        background-color: #d1e0ff;
    }

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
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .back-button:hover { background-color: #1976d2; }
    
    .total-box {
        background-color: #ff6600;
        color: white;
        padding: 10px;
        border-radius: 8px;
        text-align: center;
        font-weight: bold;
        margin-top: 10px;
    }

    /* Style pour les étiquettes de détails */
    .detail-item {
        background-color: #d1e0ff;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 8px;
        border-left: 4px solid #2196f3;
    }
</style>

<div class="blocks-container">
    <div class="block">
        <div class="top" style="margin-bottom:15px;">
            <a href="{{ route('welcome') }}" class="back-button">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Retour Accueil
            </a>
        </div>

        <div class="block-title">Historique des Ventes</div>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Produit</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factures as $facture)
                    <tr onclick="showFactureDetails({{ $facture->load(['produit', 'client'])->toJson() }})">
                        <td>{{ \Carbon\Carbon::parse($facture->date_achat)->format('d/m/Y') }}</td>
                        <td>{{ $facture->client->nom ?? 'Inconnu' }}</td>
                        <td>{{ $facture->produit->nom ?? 'N/A' }}</td>
                        <td><strong>{{ number_format($facture->montant, 2, ',', ' ') }} €</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-box">
            Chiffre d'affaires total : {{ number_format($factures->sum('montant'), 2, ',', ' ') }} €
        </div>
    </div>

    <div class="block" id="selected-facture-block">
        <div class="block-title">🔍 Fiche détaillée</div>
        <div id="facture-details">
            <p style="color: #666; font-style: italic;">Cliquez sur une ligne à gauche pour consulter les détails de l'achat.</p>
        </div>
    </div>
</div>

@section('sidebar')
    <h2>Filtres & Tri</h2>
    <form method="GET" action="{{ route('factures.index') }}">
        <div class="stat-block">
            <strong>👤 Rechercher un Client</strong>
            <input type="text" name="search_client" value="{{ request('search_client') }}" placeholder="Nom ou prénom..." style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc; margin-top:5px;">
        </div>

        <div class="stat-block">
            <strong>📅 Date de l'achat</strong>
            <input type="date" name="date" value="{{ request('date') }}" style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc; margin-top:5px;">
        </div>

        <div class="stat-block">
            <strong>💰 Montant minimum</strong>
            <input type="number" name="montant_min" value="{{ request('montant_min') }}" placeholder="Ex: 500" style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc; margin-top:5px;">
        </div>

        <button type="submit" style="width:100%; padding:12px; border:none; border-radius:10px; background:#ff6600; color:white; font-weight:bold; cursor:pointer; margin-top:10px;">
            Filtrer les résultats
        </button>
        
        <button type="button" onclick="window.location='{{ route('factures.index') }}'" style="width:100%; padding:10px; border:none; border-radius:10px; background:#ccc; color:#333; font-weight:bold; margin-top:8px; cursor:pointer;">
            🔄 Réinitialiser
        </button>
    </form>
@endsection

<script>
function showFactureDetails(facture) {
    const container = document.getElementById('facture-details');
    const date = new Date(facture.date_achat).toLocaleDateString('fr-FR');

    container.innerHTML = `
        <div style="background-color:white; padding:20px; border-radius:10px; border: 1px solid #ddd;">
            <p style="font-size:18px; color:#2196f3; font-weight:bold; margin-bottom:20px; border-bottom: 2px solid #f1f1f1; padding-bottom: 10px;">
                Détails de la Facture #FT-${facture.Id}
            </p>
            
            <div class="detail-item"><strong>Date de transaction :</strong> ${date}</div>
            <div class="detail-item"><strong>Client :</strong> ${facture.client ? facture.client.prenom + ' ' + facture.client.nom : 'Client inconnu'}</div>
            <div class="detail-item"><strong>Entreprise :</strong> ${facture.client?.entreprise || 'N/A'}</div>
            <div class="detail-item"><strong>Produit acheté :</strong> ${facture.produit ? facture.produit.nom : 'Produit non référencé'}</div>
            <div class="detail-item"><strong>Quantité :</strong> ${facture.quantite} unité(s)</div>
            
            <div style="background-color:#ff6600; color:white; padding:15px; border-radius:8px; font-size:1.3em; margin-top:20px; text-align:center;">
                <strong>Montant Total : ${new Intl.NumberFormat('fr-FR').format(facture.montant)} €</strong>
            </div>
        </div>
    `;
}
</script>
@endsection