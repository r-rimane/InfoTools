@extends('layouts.app')

@section('content')
<div class="delete-container" style="max-width:500px;margin:50px auto;text-align:center;background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
    <h2>Supprimer le rendez-vous</h2>
    <p>Voulez-vous vraiment supprimer le rendez-vous <strong>{{ $appointment->titre }}</strong> prévu le <strong>{{ \Carbon\Carbon::parse($appointment->date_heure)->format('d/m/Y H:i') }}</strong> ?</p>

    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" style="padding:10px 20px;background:#f44336;color:white;border:none;border-radius:5px;cursor:pointer;">Supprimer</button>
        <a href="{{ route('appointments.index') }}" style="padding:10px 20px;background:#bdc3c7;color:black;border-radius:5px;text-decoration:none;">Annuler</a>
    </form>
</div>
@endsection
