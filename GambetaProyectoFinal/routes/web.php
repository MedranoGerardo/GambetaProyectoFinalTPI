<?php

use Illuminate\Support\Facades\Route;

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