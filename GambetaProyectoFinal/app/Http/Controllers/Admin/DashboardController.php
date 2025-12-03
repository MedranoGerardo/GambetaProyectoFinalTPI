<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Reservas de hoy
        $reservasHoy = DB::table('reservations')
            ->whereDate('date', now()->toDateString())
            ->count();

        // Clientes frecuentes (cuántos clientes han reservado más de una vez)
        $clientesFrecuentes = DB::table('reservations')
            ->select('client_id', DB::raw('COUNT(*) as total'))
            ->groupBy('client_id')
            ->having('total', '>=', 2)
            ->count();

        // Canchas activas
        $canchasActivas = DB::table('fields')->count();

        return view('admin.dashboard', compact(
            'reservasHoy',
            'clientesFrecuentes',
            'canchasActivas'
        ));
    }
}
