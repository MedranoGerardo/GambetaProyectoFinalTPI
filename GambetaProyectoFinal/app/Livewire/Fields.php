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

    public $deleteModal = false;
    public $deleteId;

    public $duplicateModal = false;
    public $duplicateMessage = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'price_per_hour' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048',
        'is_active' => 'boolean'
    ];

    //Mensajes personalizados
    protected $messages = [
        'name.required' => 'El nombre de la cancha es obligatorio.',
        'name.string' => 'El nombre de la cancha debe ser texto válido.',
        'name.max' => 'El nombre no puede superar los 255 caracteres.',

        'type.required' => 'El tipo de cancha es obligatorio.',
        'type.string' => 'El tipo debe ser texto válido.',
        'type.max' => 'El tipo no puede superar los 255 caracteres.',

        'price_per_hour.required' => 'El precio por hora es obligatorio.',
        'price_per_hour.numeric' => 'El precio debe ser un número.',
        'price_per_hour.min' => 'El precio no puede ser negativo.',

        'image.image' => 'El archivo debe ser una imagen válida.',
        'image.max' => 'La imagen no puede pesar más de 2MB.',

        'is_active.boolean' => 'El estado debe ser verdadero o falso.',
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

        // Validación de duplicado
        $exists = Field::where('name', $this->name)
            ->when($this->field_id, function ($query) {
                $query->where('id', '!=', $this->field_id);
            })
            ->exists();

        if ($exists) {
            $this->duplicateMessage = "El nombre de la cancha ya está registrado. Cambie el nombre para continuar.";
            $this->duplicateModal = true;
            return;
        }

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

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->deleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->deleteModal = false;
        $this->deleteId = null;
    }

    public function delete()
    {
        if ($this->deleteId) {
            Field::find($this->deleteId)->delete();
            $this->closeDeleteModal();
        }
    }

    public function render()
    {
        return view('livewire.fields', [
            'fields' => Field::paginate(10)
        ]);
    }
}
