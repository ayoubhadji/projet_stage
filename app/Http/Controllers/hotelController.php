<?php

namespace App\Http\Controllers;
use App\Models\hotel;
use Illuminate\Http\Request;

class hotelController extends Controller
{
///////////////////////////////////////////////////////////////////
 public function createhotel(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'categorie' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'photos' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $photoPath = null;

    if ($request->hasFile('photos')) {
        $file = $request->file('photos');
        $filename = time() . '_' . $file->getClientOriginalName();


        $file->move(public_path('photos'), $filename);


        $photoPath = 'photos/' . $filename;
    }

    Hotel::create([
        'nom' => $request->nom,
        'categorie' => $request->categorie,
        'adresse' => $request->adresse,
        'email' => $request->email,
        'photos' => $photoPath,
    ]);

    return redirect()->route('dashboard');
}

//////////////////////////////////////////////////////////////
public function afficherHotels()
{
    $hotels = Hotel::all();
    return view('dashboard', compact('hotels'));
}

///////////////////////////////////////////////////////////////
public function supprimerhotel($id)
{

    $hotel = Hotel::findOrFail($id);


    if ($hotel->photos && file_exists(public_path($hotel->photos))) {
        unlink(public_path($hotel->photos));
    }


    $hotel->delete();


    return redirect()->route('dashboard');
}
///////////////////////////////////////////////////////////////
public function updatehotel(Request $request, $id)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'categorie' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'photos' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $hotel = Hotel::findOrFail($id);


    if ($request->hasFile('photos')) {

        if ($hotel->photos && file_exists(public_path($hotel->photos))) {
            unlink(public_path($hotel->photos));
        }


        $file = $request->file('photos');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('photos'), $filename);
        $hotel->photos = 'photos/' . $filename;
    }


    $hotel->nom = $request->nom;
    $hotel->categorie = $request->categorie;
    $hotel->adresse = $request->adresse;
    $hotel->email = $request->email;

    $hotel->save();

    return redirect()->route('dashboard');
}

///////////////////////////////////////////////////////////////
}
