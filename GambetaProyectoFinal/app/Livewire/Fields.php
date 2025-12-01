<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Field;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Fields extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $type, $price_per_hour, $image, $is_active = true;
    public $field_id;
    public $modal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'price_per_hour' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048',
        'is_active' => 'boolean'
    ];

    public function openModal()
    {
        $this->resetInput();
        $this->modal = true;
    }

    public function closeModal()
    {
        $this->modal = false;
    }

    public function resetInput()
    {
        $this->field_id = null;
        $this->name = '';
        $this->type = '';
        $this->price_per_hour = '';
        $this->image = null;
        $this->is_active = true;
    }

    public function save()
    {
        $this->validate();

        $path = null;

        if ($this->image) {
            $path = $this->image->store('fields', 'public');
        }

        Field::updateOrCreate(
            ['id' => $this->field_id],
            [
                'name' => $this->name,
                'type' => $this->type,
                'price_per_hour' => $this->price_per_hour,
                'image' => $path ?? Field::find($this->field_id)->image ?? null,
                'is_active' => $this->is_active
            ]
        );

        $this->closeModal();
    }

    public function edit($id)
    {
        $field = Field::find($id);

        $this->field_id = $field->id;
        $this->name = $field->name;
        $this->type = $field->type;
        $this->price_per_hour = $field->price_per_hour;
        $this->is_active = $field->is_active;

        $this->modal = true;
    }

    public function delete($id)
    {
        Field::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.fields', [
            'fields' => Field::paginate(10)
        ]);
    }
}

