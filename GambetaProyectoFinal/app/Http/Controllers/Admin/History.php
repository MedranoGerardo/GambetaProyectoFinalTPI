<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\Field;
use Livewire\WithPagination;

class History extends Component
{
    use WithPagination;

    public $field_id;
    public $date;

    public function render()
    {
        $query = Reservation::with(['field','client'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc');

        if ($this->field_id)
            $query->where('field_id', $this->field_id);

        if ($this->date)
            $query->where('date', $this->date);

        return view('livewire.admin.history', [
            'fields' => Field::all(),
            'history' => $query->paginate(10)
        ]);
    }
}
