@extends('layouts.app')
@section('sidebar')
    <h2>Filtres prospects</h2>

    <form method="GET" action="{{ route('prospects.index') }}">

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
                   placeholder="Email"
                   style="width:100%; padding:6px; border-radius:6px;">
        </div>

        <div class="stat-block">
            <strong>📞 Téléphone</strong>
            <select name="tel" style="width:100%; padding:6px; border-radius:6px;">
                <option value="">Tous</option>
                <option value="1" @selected(request('tel')=='1')>Avec téléphone</option>
                <option value="0" @selected(request('tel')=='0')>Sans téléphone</option>
            </select>
        </div>

        <button type="submit"
                style="width:100%; padding:10px; border:none; border-radius:10px;
                       background:#ff6600; color:white; font-weight:bold;">
            Appliquer
        </button>
        <button type="button"
        onclick="window.location='{{ route('prospects.index') }}'"
        style="width:100%; padding:10px; border:none; border-radius:10px;
               background:#ff8533; color:white; font-weight:bold; margin-top:8px;">
    🔄 Réinitialiser
</button>


    </form>
@endsection


@section('content')
<style>
    html, body { height: 100%; margin: 0; }
    body { font-family: 'Madimi One', sans-serif; background-color: white; padding: 20px; box-sizing: border-box; }
    .blocks-container { display: flex; gap: 20px; height: calc(100vh - 80px); }
    .block { flex: 1; background-color: #f1f1f1; border-radius: 10px; padding: 10px; overflow-y: auto; }
    .block-title { font-weight: bold; font-size: 20px; color: #333; margin-bottom: 10px; text-shadow: 1px 1px 2px #ccc; }
    table { width: 100%; border-collapse: collapse; }
    th, td { text-align: left; padding: 10px; border-bottom: 1px solid #ccc; }
    table tbody tr { transition: background-color 0.2s ease; }
    table tbody tr:hover { background-color: #d1e0ff; cursor: pointer; }
    .back-button { display: inline-flex; align-items: center; gap: 8px; background-color: #2196f3; color: white; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: background-color 0.2s ease, transform 0.1s ease; }
    .back-button:hover { background-color: #1976d2; transform: translateY(-2px); }
    .back-button svg { width: 18px; height: 18px; }
</style>

@if(session('success'))
    <div id="flash-message" style="
        background-color:#4caf50; color:white; padding: 12px 20px; border-radius: 8px; margin-bottom: 15px; box-shadow: 0 2px 6px rgba(0,0,0,0.15); font-weight: bold; text-align:center; opacity: 1; transition: opacity 0.5s ease-out;">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            flash.style.opacity = 0;
            setTimeout(() => flash.remove(), 500);
        }, 2000);
    </script>
@endif

<div class="blocks-container">
    <!-- Bloc gauche -->
    <div class="block">
        <!-- Boutons retour + ajouter -->
        <div class="top" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
            <a href="{{ route('welcome') }}" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour
            </a>
            <a href="{{ route('prospects.create') }}" class="back-button" style="background-color:#4caf50;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter un prospect
            </a>
        </div>

        <div class="block-title">Prospects</div>

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
                @foreach($prospects as $index => $prospect)
                    <tr onclick="showProspectInRightBlock({{ $prospect->toJson() }})">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $prospect->nom }}</td>
                        <td>{{ $prospect->prenom }}</td>
                        <td>{{ $prospect->entreprise ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bloc droit -->
    <div class="block" id="selected-prospect-block">
        <div class="block-title">Détails du prospect</div>
        <div id="prospect-details">
            <p>Cliquez sur un prospect à gauche pour voir les détails ici.</p>
        </div>
    </div>
</div>

<script>
function showProspectInRightBlock(prospect) {
    const container = document.getElementById('prospect-details');

    container.innerHTML = `
        <p style="background:#d1e0ff; padding:8px; border-radius:8px;"><strong>Nom :</strong> ${prospect.nom}</p>
        <p style="background:#b3c6ff; padding:8px; border-radius:8px;"><strong>Prénom :</strong> ${prospect.prenom}</p>
        <p style="background:#d1e0ff; padding:8px; border-radius:8px;"><strong>Email :</strong> ${prospect.email}</p>
        <p style="background:#b3c6ff; padding:8px; border-radius:8px;"><strong>Téléphone :</strong> ${prospect.tel ?? '-'}</p>
        <p style="background:#d1e0ff; padding:8px; border-radius:8px;"><strong>Entreprise :</strong> ${prospect.entreprise ?? '-'}</p>
        <p style="background:#b3c6ff; padding:8px; border-radius:8px;"><strong>Adresse :</strong> ${prospect.adresse ?? '-'}</p>

        <div style="margin-top:10px; display:flex; gap:10px;">
            <a href="/prospects/${prospect.id}/edit" style="padding:8px 12px; border-radius:5px; background:#4caf50; color:white; text-decoration:none;">
                ✏️ Modifier
            </a>

            <form action="/prospects/${prospect.id}" method="POST"
                  onsubmit="return confirm('Supprimer ce prospect ?');"
                  style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding:8px 12px; border:none; border-radius:5px; background:#f44336; color:white;">
                    🗑️ Supprimer
                </button>
            </form>
        </div>
    `;
}
</script>

@endsection
