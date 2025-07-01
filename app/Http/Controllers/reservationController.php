<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_hotel' => 'required|exists:hotels,id',
            'date_arrivee' => 'required|date|after_or_equal:today',
            'date_depart' => 'required|date|after:date_arrivee',
            'nombre_de_personne' => 'required|integer|min:1',
        ]);

        Reservation::create($validated);

        return redirect()->back()->with('success', 'Réservation créée avec succès !');
    }
    ///////////////////////////////////////////////////////////////////////////
    public function afficherreservations()
{
    $reservations = Reservation::with(['user', 'hotel'])->get();

    return view('welcome', compact('reservations'));
}

    ///////////////////////////////////////////////////////////////////////////
}
