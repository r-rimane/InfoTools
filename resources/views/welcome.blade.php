@extends('layouts.app')

@section('content')
    <style>
        /* --- Section Clients --- */
        .section-group {
            margin-bottom: 40px;
        }

        .section-title {
            color: #333333;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: left;
            font-size: 20px;
        }

        .clients-section {
            border-radius: 10px;
            padding: 10px;
            background-color: #f1f1f1;
        }

        /* Lignes du tableau cliquables */
.clients-section table tbody tr {
    transition: background-color 0.2s ease;
}

.clients-section table tbody tr:hover {
    background-color: #ffe0b3; /* couleur légère au survol */
    cursor: pointer;            /* indique que c'est cliquable */
}
.table-container table tbody tr:hover {
    background-color: #ffe0b3; /* couleur légère au survol */
    cursor: pointer;            /* indique que c'est cliquable */
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

        table p {
            word-wrap: break-word;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }

        /* --- Boxs --- */
        .boxes {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .box-group {
            flex: 1;
        }

        .box-title {
            color: #333333;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: left;
            font-size: 20px;
        }

        .box {
            background-color: #f1f1f1;
            border-radius: 15px;
            height: 150px;
            padding: 10px;
            overflow-y: auto; /* pour scroller si le contenu dépasse */
        }

        .sidebar strong {
            font-size: 20px;
        }

        .sidebar p {
    word-wrap: break-word; /* coupe les mots trop longs pour rester dans la sidebar */
    margin-bottom: 8px;
}


    </style>

    <!-- Section Clients -->
<div class="section-group">
    <div class="section-title">Clients</div>
    <div class="clients-section">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
    @foreach($clients as $index => $client)
        <tr onclick="window.location='{{ route('clients.index', $client->id) }}'" style="cursor:pointer;">
            <td>{{ $index + 1 }}</td>
            <td>{{ $client->nom }}</td>
            <td>{{ $client->prenom }}</td>
            <td>{{ $client->email }}</td>
        </tr>
    @endforeach
</tbody>

            </table>
        </div>
    </div>
</div>

<!-- Section Boxs -->
<div class="boxes">
    <!-- Section Prospects -->
<div class="box-group">
    <div class="box-title">Prospects</div>
    <div class="box">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($prospects as $index => $prospect)
                        <tr onclick="window.location='{{ route('prospects.index', $prospect->id) }}'" style="cursor:pointer;">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $prospect->nom }}</td>
                            <td>{{ $prospect->prenom }}</td>
                            <td>{{ $prospect->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


    <!-- Section Rendez-vous -->
<div class="box-group">
    <div class="box-title">Rendez-vous</div>
    <div class="box">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Titre</th>
                        <th>Date & Heure</th>
                        <th>Prospect associé</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($appointments as $index => $appointment)
                        <tr onclick="window.location='{{ route('appointments.index', $appointment->id) }}'" style="cursor:pointer;">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $appointment->titre }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->date_heure)->format('d/m/Y H:i') }}</td>
                            <td>{{ $appointment->prospect ? $appointment->prospect->nom . ' ' . $appointment->prospect->prenom : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


        <!-- Section Produits -->
    <div class="box-group">
        <div class="box-title">Produits</div>
        <div class="box">
            <div class="table-container">
                <table>
                <thead>
        <tr>
            <th>N°</th>
            
            <th>Nom</th>
            <th>Prix</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produits as $index => $produit)
            <tr onclick="window.location='{{ route('produits.index') }}'" style="cursor:pointer;">
                <td>{{ $index + 1 }}</td>
                
                <td>{{ $produit->nom }}</td>
                <td>{{ $produit->prix }} €</td>
            </tr>
        @endforeach
    </tbody>


            </table>
        </div>
    </div>
</div>

@endsection