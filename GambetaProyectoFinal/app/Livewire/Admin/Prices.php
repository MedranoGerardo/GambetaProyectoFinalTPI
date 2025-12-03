<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Field;

class Prices extends Component
{
    public $prices = [];

    public function mount()
    {
        foreach (Field::all() as $field) {
            $this->prices[$field->id] = $field->price_per_hour;
        }
    }

    public function updatePrice($id)
    {
        $this->validate([
            "prices.$id" => 'required|numeric|min:0'
        ]);

        $field = Field::find($id);
        $field->price_per_hour = $this->prices[$id];
        $field->save();

        session()->flash('success', 'Precio actualizado correctamente.');
    }

    public function render()
    {
        return view('livewire.admin.prices', [
            'fields' => Field::all()
        ]);
    }
}