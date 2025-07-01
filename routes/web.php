<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\navigationcontroller;
use App\Http\Controllers\reservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('auth/login');
});
////////////////////////////////////////////////////////////////////////////
Route::get('/dashboard', [HotelController::class, 'afficherHotels'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
//////////////////////////////////////////////////////////////////////////
Route::get('/welcome', [navigationcontroller::class, 'goToWelcome'])->name('welcome.page');
//////////////////////////////////////////////////////////////////////////
Route::get('/userinterface', [navigationcontroller::class, 'goTouserinterface'])->name('userinterface.page');
//////////////////////////////////////////////////////////////////////////
Route::middleware('auth')->group(function () {

    Route::get('/userinterface', [hotelController::class, 'showHotelsForUser'])->name('userinterface.page');

    Route::get('/hotels', [HotelController::class, 'afficherHotels'])->name('afficherHotels');

    Route::post('/createhotel', [HotelController::class, 'createhotel'])->name('createhotel');

    Route::delete('/hotel/{id}', [HotelController::class, 'supprimerhotel'])->name('supprimerhotel');

    Route::post('/reservations', [reservationController::class, 'store'])->name('createReservation');

    Route::post('/reservation', [reservationController::class, 'afficherreservations'])->name('affciherReservation');

    Route::post('/updatehotel/{id}', [HotelController::class, 'updatehotel'])->name('updatehotel');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';
