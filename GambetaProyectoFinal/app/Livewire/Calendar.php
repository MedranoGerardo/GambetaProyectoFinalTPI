<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Field;
use App\Models\Reservation;
use Carbon\Carbon;

class Calendar extends Component
{
    public $selectedField;
    public $selectedDate;
    public $duration;
    public $start_time;

    public $currentMonth;
    public $currentYear;

    public $reservedDays = [];
    public $dayReservations = [];
    public $availableHours = [];

    public $successMessage;
    public $errorMessage;

    public function mount()
    {
        $this->selectedDate = null; 
        $this->currentMonth = now()->month;
        $this->currentYear  = now()->year;
    }

    public function updatedSelectedField()
    {
        $this->selectedDate = null;
        $this->dayReservations = [];
        $this->availableHours = [];
        $this->loadReservedDays();
    }

    public function loadReservedDays()
    {
        $this->reservedDays = [];

        if (!$this->selectedField) return;

        $start = Carbon::create($this->currentYear, $this->currentMonth, 1)->toDateString();
        $end   = Carbon::create($this->currentYear, $this->currentMonth, 1)->endOfMonth()->toDateString();

        $dates = Reservation::where('field_id', $this->selectedField)
            ->whereBetween('date', [$start, $end])
            ->pluck('date');

        foreach ($dates as $d) {
            $this->reservedDays[] = Carbon::parse($d)->day;
        }
    }

    public function goToNextMonth()
    {
        $new = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $new->month;
        $this->currentYear  = $new->year;

        $this->loadReservedDays();
    }

    public function goToPreviousMonth()
    {
        $today = Carbon::now()->startOfMonth();
        $current = Carbon::create($this->currentYear, $this->currentMonth, 1);

        if ($current->lessThanOrEqualTo($today)) return;

        $new = $current->subMonth();
        $this->currentMonth = $new->month;
        $this->currentYear  = $new->year;

        $this->loadReservedDays();
    }

    public function selectDay($day)
    {
        if (!$this->selectedField) return;

        $date = Carbon::create($this->currentYear, $this->currentMonth, $day);

        if ($date->isPast() && !$date->isToday()) return;

        $this->selectedDate = $date->format('Y-m-d');

        $this->loadDayReservations();
        $this->loadAvailability();
    }

    public function loadDayReservations()
    {
        $this->dayReservations = [];

        if (!$this->selectedDate) return;

        $this->dayReservations = Reservation::with('client')
            ->where('field_id', $this->selectedField)
            ->where('date', $this->selectedDate)
            ->orderBy('start_time', 'ASC')
            ->get();
    }

    public function loadAvailability()
    {
        $this->availableHours = [];

        if (!$this->selectedDate) return;

        $hours = [];
        for ($i = 6; $i <= 22; $i++) {
            $hours[] = sprintf('%02d:00', $i);
        }

        foreach ($this->dayReservations as $res) {

            $start = Carbon::parse($res->start_time)->format('H:00');
            $end   = Carbon::parse($res->end_time)->format('H:00');

            foreach ($hours as $i => $hour) {
                if ($hour >= $start && $hour < $end) {
                    unset($hours[$i]);
                }
            }
        }

        $this->availableHours = array_values($hours);
    }

    public function reserve()
    {
        $this->validate([
            'selectedField' => 'required',
            'selectedDate'  => 'required',
            'start_time'    => 'required',
            'duration'      => 'required|numeric|min:1'
        ]);

        $durationInt = floatval($this->duration);

        $end = Carbon::parse($this->start_time)
                    ->addHours($durationInt)
                    ->format('H:i');

        $conflict = Reservation::where([
                ['field_id', '=', $this->selectedField],
                ['date', '=', $this->selectedDate],
            ])
            ->where(function ($q) {
                $q->whereBetween('start_time', [$this->start_time, $this->start_time])
                  ->orWhereBetween('end_time', [$this->start_time, $this->start_time]);
            })
            ->first();

        if ($conflict) {
            $this->errorMessage = "Ese horario ya está reservado.";
            $this->successMessage = null;
            return;
        }

        Reservation::create([
            'client_id'   => 1,
            'field_id'    => $this->selectedField,
            'user_id'     => auth()->id() ?? 1,
            'date'        => $this->selectedDate,
            'start_time'  => $this->start_time,
            'end_time'    => $end,
            'total_price' => 10 * $durationInt,
            'status'      => 'pendiente'
        ]);

        $this->successMessage = "Reserva creada correctamente.";
        $this->errorMessage = null;

        $this->loadReservedDays();
        $this->loadDayReservations();
        $this->loadAvailability();
    }

    /* ==========================
        REINICIAR FORMULARIO
    ========================== */
    public function resetForm()
    {
        $this->selectedField = null;
        $this->selectedDate = null;
        $this->duration = null;
        $this->start_time = null;

        $this->successMessage = null;
        $this->errorMessage = null;

        $this->reservedDays = [];
        $this->dayReservations = [];
        $this->availableHours = [];
    }

    public function render()
    {
        return view('livewire.calendar', [
            'fields' => Field::all()
        ]);
    }
}
