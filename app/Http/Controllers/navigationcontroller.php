<?php

namespace App\Http\Controllers;
use App\Models\Reservation;

use Illuminate\Http\Request;

class navigationcontroller extends Controller
{
///////////////////////////////////////////////////////////////
public function goToWelcome()
{
    $reservations = Reservation::with(['user', 'hotel'])->get();
    return view('welcome', compact('reservations'));
}
///////////////////////////////////////////////////////////////
public function goTouserinterface()
    {
        return view('userinterface');
    }
///////////////////////////////////////////////////////////////
}
