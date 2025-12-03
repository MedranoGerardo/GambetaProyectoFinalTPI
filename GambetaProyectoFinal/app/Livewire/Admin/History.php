<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reservation;

class History extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.history', [
            'reservations' => Reservation::with(['client', 'field'])
                ->orderBy('date', 'desc')
                ->orderBy('start_time', 'asc')
                ->paginate(15)
        ]);
    }
}
