<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info-Tools - CRM</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Madimi+One&display=swap');

        body {
            margin: 0;
            padding: 20px;
            font-family: 'Madimi One', sans-serif;
            background-color: #ffffff;
            box-sizing: border-box;
        }

        header {
            background-color: #fff3da;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ff6600;
        }

        .logo img {
            height: 100px;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            text-decoration: none;
        }

        nav a button,
        nav a span,
        nav form button {
            margin: 0 10px;
            background-color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s ease;
            color: #333;
        }

        nav a button:hover,
        nav form button:hover,
        nav a span:hover {
            background-color: #ffe0b3;
        }

        .nav-btn {
            background-color: white;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
            color: #333;
            text-decoration: none;
        }

        .nav-btn:hover {
            background-color: #ffe0b3;
        }

        .container {
            display: flex;
            gap: 20px;
        }

        .sidebar {
            width: 250px;
            background-color: #ffc233;
            padding: 20px;
            color: #333;
            border-radius: 20px;
            overflow-y: auto;
            box-sizing: border-box;
        }

        .sidebar h2 {
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            margin-bottom: 15px;
        }

        .stat-block {
            background-color: white;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-block:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .stat-block strong {
            display: block;
            font-size: 16px;
            color: #555;
        }

        .stat-block p {
            margin: 8px 0 0;
            font-size: 22px;
            font-weight: bold;
            color: #ff6600;
        }

        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>

<body>
<header>
    <div class="logo">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('logo-infotools.png') }}" alt="Logo Info-Tools">
        </a>
    </div>

    <nav>
        <a href="{{ route('produits.index') }}"><button>Produits</button></a>
        <a href="{{ route('clients.index') }}"><button>Clients</button></a>
        <a href="{{ route('factures.index') }}"><button>Factures</button></a>
        <a href="{{ route('prospects.index') }}"><button>Prospects</button></a>
        <a href="{{ route('appointments.index') }}"><button>Rendez-vous</button></a>

        @auth
            <span class="nav-btn">
                Bonjour, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
            </span>

            <form action="{{ route('logout') }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="nav-btn">Déconnexion</button>
            </form>
        @else
            {{-- Le lien register (icône 👤) a été supprimé ici --}}
            <a href="{{ route('login') }}" class="nav-btn">Connexion</a>
        @endauth
    </nav>
</header>

<div class="container">
{{-- On n'affiche la sidebar QUE sur l'accueil ou les pages de listes (.index) --}}
@if(Route::is('welcome') || Route::is('*.index'))
    <aside class="sidebar">
        @hasSection('sidebar')
            @yield('sidebar')
        @else
            <h2>Statistiques</h2>

            <div class="stat-block">
                <strong>👥 Clients</strong>
                <p>{{ $stats['totalClients'] ?? '/' }}</p>
            </div>

            <div class="stat-block">
                <strong>🛍️ Produits</strong>
                <p>{{ $stats['totalProduits'] ?? '/' }}</p>
            </div>

            <div class="stat-block">
                <strong>📞 Prospects</strong>
                <p>{{ $stats['totalProspects'] ?? '/' }}</p>
            </div>

            <div class="stat-block">
                <strong>📅 Rendez-vous</strong>
                <p>{{ $stats['totalRendezVous'] ?? '/' }}</p>
            </div>
        @endif
    </aside>
@endif

    <main class="content">
        @yield('content')
    </main>
</div>
</body>
</html>