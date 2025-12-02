<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Field;
use App\Models\Reservation;
use Carbon\Carbon;

class Calendar extends Component
{
    public $selectedDate;
    public $selectedField;
    public $start_time;
    public $duration;
    public $availableHours = [];

    public $successMessage;
    public $errorMessage;

    public function mount()
    {
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function updatedSelectedField()
    {
        $this->loadAvailability();
    }

    public function updatedSelectedDate()
    {
        $this->loadAvailability();
    }

    public function loadAvailability()
    {
        if (!$this->selectedField || !$this->selectedDate) return;

        $reservations = Reservation::where('field_id', $this->selectedField)
            ->where('date', $this->selectedDate)
            ->get();

        // Horas disponibles 6am - 10pm
        $hours = [];
        for ($i = 6; $i <= 22; $i++) {
            $hours[] = sprintf('%02d:00', $i);
        }

        // Eliminar horas ocupadas
        foreach ($reservations as $res) {
            $busyStart = Carbon::parse($res->start_time)->format('H:00');
            $busyEnd = Carbon::parse($res->end_time)->format('H:00');

            foreach ($hours as $index => $h) {
                if ($h >= $busyStart && $h < $busyEnd) {
                    unset($hours[$index]);
                }
            }
        }

        $this->availableHours = array_values($hours);
    }


    public function reserve()
    {
        $this->validate([
            'selectedField' => 'required',
            'selectedDate' => 'required',
            'start_time' => 'required',
            'duration' => 'required|numeric|min:1'
        ]);
        

        // Calcular hora final
    $duration = intval($this->duration);  // convertir string → entero
    $end = Carbon::parse($this->start_time)
                ->addHours($duration)
                ->format('H:i');


        // Verificar choque
        $check = Reservation::where('field_id', $this->selectedField)
            ->where('date', $this->selectedDate)
            ->where(function ($q) {
                $q->whereBetween('start_time', [$this->start_time, $this->start_time])
                  ->orWhereBetween('end_time', [$this->start_time, $this->start_time]);
            })->first();

        if ($check) {
            $this->errorMessage = "Este horario ya está ocupado.";
            $this->successMessage = null;
            return;
        }

        Reservation::create([
            'client_id' => 1, // temporal para pruebas
            'field_id' => $this->selectedField,
            'user_id' => auth()->id() ?? 1,
            'date' => $this->selectedDate,
            'start_time' => $this->start_time,
            'end_time' => $end,
            'total_price' => 10 * $this->duration,
            'status' => 'pendiente'
        ]);

        $this->successMessage = "Reserva creada correctamente.";
        $this->errorMessage = null;

        $this->loadAvailability();
    }


    public function render()
    {
        return view('livewire.calendar', [
            'fields' => Field::all()
        ]);
    }
}
