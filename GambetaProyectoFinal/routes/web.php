<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentPDFController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardController;


Route::get('/', function () {
    return view('home');
});


Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);



/*
|--------------------------------------------------------------------------
| PANEL DE ADMINISTRACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Dashboard (admin y recepcionista)
Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);


    // Accesibles por ambos roles
    Route::get('/calendario', fn() => view('admin.calendar'));
    Route::get('/reservas', fn() => view('admin.reservations'));

    Route::get('/reservas/{id}/pagos', fn($id) =>
        view('admin.payments', ['reservation_id' => $id])
    );

    Route::get('/reservas/{id}/pdf', [PaymentPDFController::class, 'generate']);

    /*
    |--------------------------------------------------------------------------
    | SOLO ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        Route::get('/canchas', fn() => view('admin.fields'));

        Route::get('/prices', fn() => view('admin.prices'));

        Route::get('/blocked-times', fn() => view('admin.blocked-times'));
    });

});

