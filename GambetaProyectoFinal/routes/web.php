<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentPDFController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('home'));

Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);


/*
|--------------------------------------------------------------------------
| PANEL ADMIN (+ RECEPCIONISTA)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);

    // Calendario y reservas (ambos roles)
    Route::get('/calendario', fn() => view('admin.calendar'));
    Route::get('/reservas', fn() => view('admin.reservations'));

    // Vista de pagos
    Route::get('/reservas/{id}/pagos', fn($id) =>
        view('admin.payments', ['reservation_id' => $id])
    );

    // Historial (ambos roles)
    Route::get('/historial', fn() => view('admin.history'));


    /*
    |--------------------------------------------------------------------------
    | SOLO ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        // Canchas
        Route::get('/canchas', fn() => view('admin.fields'));

        // Precios
        Route::get('/prices', fn() => view('admin.prices'));

        // Bloqueos
        Route::get('/blocked-times', fn() => view('admin.blocked-times'));

        // Usuarios
        Route::get('/users', fn() => view('admin.users'));

        // Clientes Frecuentes (Livewire)
        Route::get('/clientes-frecuentes', \App\Livewire\Admin\FrequentClients::class);
    });
});


/*
|--------------------------------------------------------------------------
| RUTAS PARA PDFs
|--------------------------------------------------------------------------
*/
Route::get('/reservations/{id}/pdf', [PaymentPDFController::class, 'generate']);
Route::get('/payments/{id}/pdf', [PaymentPDFController::class, 'generate']);
