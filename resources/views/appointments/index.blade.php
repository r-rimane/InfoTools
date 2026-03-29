@extends('layouts.app')

@section('sidebar')
    <h2>Filtres Rendez-vous</h2>

    <form method="GET" action="{{ route('appointments.index') }}">

        <div class="stat-block">
            <strong>🔍 Recherche</strong>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Nom client ou prospect"
                   style="width:100%; padding:6px; border-radius:6px;">
        </div>

        <div class="stat-block">
            <strong>📅 Date</strong>
            <input type="date" name="date"
                   value="{{ request('date') }}"
                   style="width:100%; padding:6px; border-radius:6px;">
        </div>

        <div class="stat-block">
            <strong>⏰ Heure</strong>
            <input type="time" name="time"
                   value="{{ request('time') }}"
                   style="width:100%; padding:6px; border-radius:6px;">
        </div>

        <div class="stat-block">
            <strong>👤 Type</strong>
            <select name="type" style="width:100%; padding:6px; border-radius:6px;">
                <option value="">Tous</option>
                <option value="client" @selected(request('type')=='client')>Client</option>
                <option value="prospect" @selected(request('type')=='prospect')>Prospect</option>
            </select>
        </div>

        <button type="submit"
                style="width:100%; padding:10px; border:none; border-radius:10px;
                       background:#ff6600; color:white; font-weight:bold;">
            Appliquer
        </button>

        <button type="button"
        onclick="window.location='{{ route('appointments.index') }}'"
        style="width:100%; padding:10px; border:none; border-radius:10px;
               background:#ff8533; color:white; font-weight:bold; margin-top:8px;">
    🔄 Réinitialiser
</button>


    </form>
@endsection


@section('content')
<style>
    .planning-container {
        display: flex;
        flex-direction: column;
        gap: 30px;
        margin: 20px;
    }

    .month-block {
        background-color: #f1f1f1;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .month-title {
        font-weight: bold;
        font-size: 22px;
        color: #333;
        margin-bottom: 15px;
    }

    .day-block {
        background-color: white;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }

    .day-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 8px;
        color: #555;
    }

    .appointment {
        background-color: #d1e0ff;
        padding: 8px 10px;
        margin-bottom: 6px;
        border-radius: 6px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .appointment-buttons button,
    .appointment-buttons a {
        margin-left: 5px;
        padding: 5px 8px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        color: white;
        text-decoration: none;
    }

    .edit-btn { background-color: #4caf50; }
    .delete-btn { background-color: #f44336; }

    .add-btn {
        background-color: #2196f3;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        margin-bottom: 20px;
        display: inline-block;
    }
</style>



<div class="planning-container">
<h1 style="font-size:36px; font-weight:bold; text-align:center; margin-bottom:25px; color:#333;">
    Planning des Rendez-vous
</h1>
<a href="{{ route('appointments.create') }}" class="add-btn">➕ Ajouter un rendez-vous</a>
    @php
        use Illuminate\Support\Carbon;
        setlocale(LC_TIME, 'fr_FR.UTF-8');

        $appointmentsByMonth = $appointments->sortBy('date_heure')->groupBy(function($appt) {
            return Carbon::parse($appt->date_heure)->format('Y-m');
        });
    @endphp

        <!-- reste du code inchangé -->


    @foreach($appointmentsByMonth as $month => $monthAppointments)
        <div class="month-block">
        <div class="month-title">{{ ucfirst(Carbon::parse($month.'-01')->translatedFormat('F Y')) }}</div>


            @php
                // Grouper les rendez-vous du mois par jour
                $appointmentsByDay = $monthAppointments->groupBy(function($appt) {
                    return Carbon::parse($appt->date_heure)->format('Y-m-d');
                });
            @endphp

            @foreach($appointmentsByDay as $day => $dayAppointments)
                <div class="day-block">
                    <div class="day-title">{{ Carbon::parse($day)->translatedFormat('l d F Y') }}</div>

                    @foreach($dayAppointments as $appt)
                        <div class="appointment">
                            <div>
                                <strong>{{ Carbon::parse($appt->date_heure)->format('H:i') }}</strong> - {{ $appt->titre }} ({{ $appt->prospect->nom ?? 'Sans prospect' }})
                            </div>
                            <div class="appointment-buttons">
                                <a href="{{ route('appointments.edit', $appt->id) }}" class="edit-btn">✏️</a>
                                <form action="{{ route('appointments.destroy', $appt->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer ce rendez-vous ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">🗑️</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
