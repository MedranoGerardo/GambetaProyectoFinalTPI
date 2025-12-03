<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class FrequentClients extends Component
{
    public function render()
    {
        // Clientes ordenados por más reservas
        $clients = Client::select(
                'clients.*',
                DB::raw('(SELECT COUNT(*) FROM reservations WHERE reservations.client_id = clients.id) as total_reservas')
            )
            ->orderByDesc('total_reservas')
            ->get();

        return view('livewire.admin.frequent-clients', [
            'clients' => $clients
        ])->layout('layouts.admin'); // ← ESTA ES LA LÍNEA IMPORTANTE
    }
}
