<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Field;
use Carbon\Carbon;

class Reservations extends Component
{
    use WithPagination;

    public $client_id, $name, $phone, $team;
    public $field_id, $date, $start_time, $duration, $total_price;
    public $reservation_id;
    public $status;

    public $successMessage, $errorMessage;
    public $modal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:50',
        'team' => 'nullable|string|max:255',
        'field_id' => 'required',
        'date' => 'required|date',
        'start_time' => 'required',
        'duration' => 'required|integer|min:1',
    ];

    public function openModal()
    {
        $this->resetFields();
        $this->modal = true;
    }

    public function closeModal()
    {
        $this->modal = false;
    }

    public function resetFields()
    {
        $this->reservation_id = null;
        $this->client_id = null;

        $this->name = '';
        $this->phone = '';
        $this->team = '';

        $this->field_id = '';
        $this->date = '';
        $this->start_time = '';
        $this->duration = '';
        $this->total_price = '';
        $this->status = 'pendiente';
    }

    public function calculateTotal()
    {
        if (!$this->field_id || !$this->duration) return;

        $field = Field::find($this->field_id);
        $this->total_price = $field->price_per_hour * intval($this->duration);
    }

    public function saveReservation()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->errorMessage = "Por favor complete todos los campos.";
            return;
        }

        // Guardar o encontrar cliente
        $client = Client::updateOrCreate(
            ['id' => $this->client_id],
            [
                'name' => $this->name,
                'phone' => $this->phone,
                'team' => $this->team
            ]
        );

        // Calcular hora final
        $duration = intval($this->duration);
        $end_time = Carbon::parse($this->start_time)->addHours($duration)->format('H:i');

        // Guardar reserva
        Reservation::updateOrCreate(
            ['id' => $this->reservation_id],
            [
                'client_id' => $client->id,
                'field_id' => $this->field_id,
                'user_id' => auth()->id() ?? 1,
                'date' => $this->date,
                'start_time' => $this->start_time,
                'end_time' => $end_time,
                'total_price' => $this->total_price,
                'status' => $this->status,
            ]
        );

        $this->successMessage = "Reserva guardada correctamente.";
        $this->closeModal();
    }

    public function edit($id)
    {
        $res = Reservation::with('client')->find($id);

        $this->reservation_id = $res->id;
        $this->client_id = $res->client->id;

        $this->name = $res->client->name;
        $this->phone = $res->client->phone;
        $this->team = $res->client->team;

        $this->field_id = $res->field_id;
        $this->date = $res->date;
        $this->start_time = $res->start_time;
        $this->duration = Carbon::parse($res->start_time)->diffInHours($res->end_time);
        $this->total_price = $res->total_price;
        $this->status = $res->status;

        $this->modal = true;
    }

    public function updateStatus($id, $newStatus)
    {
        $res = Reservation::find($id);
        $res->status = $newStatus;
        $res->save();

        $this->successMessage = "Estado actualizado.";
    }

    public function render()
    {
        return view('livewire.reservations', [
            'reservations' => Reservation::with(['client', 'field'])
                ->latest()->paginate(10),
            'fields' => Field::all()
        ]);
    }
}

