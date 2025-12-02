<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentPDFController;


Route::get('/', function () {
    return view('home');
});


Route::get('/fields', function () {
    return view('fields');
});


Route::get('/calendar', function () {
    return view('calendar');
});



Route::get('/reservations', function () {
    return view('reservations');
});


Route::get('/reservations/{id}/payments', function ($id) {
    return view('payments', ['reservation_id' => $id]);
});

Route::get('/reservations/{id}/pdf', [PaymentPDFController::class, 'generate']);
