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

    public $errorModal = false;
    public $successModal = false;

    // Horas disponibles
    public $availableHours = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:50',
        'team' => 'nullable|string|max:255',
        'field_id' => 'required',
        'date' => 'required|date',
        'start_time' => 'required',
        'duration' => 'required|integer|min:1',
    ];

    protected $messages = [
        'name.required' => 'El nombre del cliente es obligatorio.',
        'field_id.required' => 'Debe seleccionar una cancha.',
        'date.required' => 'La fecha es obligatoria.',
        'start_time.required' => 'Debe ingresar una hora de inicio.',
        'duration.required' => 'Debe ingresar la duración.',
        'duration.integer' => 'La duración debe ser un número entero.',
        'duration.min' => 'La duración mínima es de 1 hora.',
    ];

    public function openModal()
    {
        $this->resetFields();
        $this->modal = true;
    }

    public function closeModal()
    {
        $this->modal = false;
        // limpiar errores y mensajes relacionados al cerrar
        $this->errorModal = false;
        $this->errorMessage = null;
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
        $this->duration = null;
        $this->total_price = null;
        $this->status = 'pendiente';

        $this->availableHours = [];
        $this->errorModal = false;
        $this->errorMessage = null;
    }


    /**
     * CALCULAR TOTAL
     */
    public function calculateTotal()
    {
        // Si falta cancha o duración, no calcular (pero dejar total_price en null/0)
        if (!$this->field_id || $this->duration === null || $this->duration === '') {
            $this->total_price = null;
            return;
        }

        // Forzar entero
        $this->duration = intval($this->duration);

        $field = Field::find($this->field_id);

        if (!$field) {
            $this->total_price = 0;
            return;
        }

        // Guardar total como float
        $this->total_price = floatval($field->price_per_hour) * $this->duration;
    }



    /**
     * VALIDAR RANGOS OCUPADOS
     *
     * Devuelve true si existe conflicto.
     */
    public function timeRangeHasConflict($field_id, $date, $start_time, $duration, $reservation_id = null)
    {
        
        if (!$start_time || $duration === null || $duration === '') {
            return false;
        }

        // Forzar tipos correctos
        $durationInt = intval($duration);
        try {
            $start = Carbon::parse($start_time);
        } catch (\Exception $e) {
            // formato inválido, devolver conflicto para evitar guardar
            return true;
        }

        $end = (clone $start)->addHours($durationInt);

        return Reservation::where('field_id', $field_id)
            ->where('date', $date)
            ->when($reservation_id, fn($q) => $q->where('id', '!=', $reservation_id))
            ->where(function ($q) use ($start, $end) {
                // Cualquier intersección entre [start, end)
                $q->where(function ($q2) use ($start, $end) {
                    // existing.start < new.end AND existing.end > new.start
                    $q2->where('start_time', '<', $end->format('H:i'))
                        ->where('end_time', '>', $start->format('H:i'));
                });
            })
            ->exists();
    }



    /**
     * CARGAR HORAS DISPONIBLES
     */
    public function loadAvailableHours()
    {
        $this->availableHours = [];

        if (!$this->field_id || !$this->date) return;

        $hours = [];
        for ($h = 6; $h <= 22; $h++) {
            $hours[] = sprintf('%02d:00', $h);
        }

        $reservations = Reservation::where('field_id', $this->field_id)
            ->where('date', $this->date)
            ->when($this->reservation_id, fn($q) => $q->where('id', '!=', $this->reservation_id))
            ->get();

        $available = [];

        foreach ($hours as $hour) {
            $hourCarbon = Carbon::createFromFormat('H:i', $hour);

            $isFree = true;

            foreach ($reservations as $res) {
                // Asegurarse de parsear como Carbon respetando formato H:i
                try {
                    $start = Carbon::parse($res->start_time);
                    $end   = Carbon::parse($res->end_time);
                } catch (\Exception $e) {
                    // si hay datos corruptos, considerarlos ocupados para mayor seguridad
                    $isFree = false;
                    break;
                }

                // Si la hora base está dentro de un rango reservado -> no está libre
                if ($hourCarbon->gte($start) && $hourCarbon->lt($end)) {
                    $isFree = false;
                    break;
                }
            }

            if ($isFree) $available[] = $hour;
        }

        $this->availableHours = $available;
    }


    public function updatedFieldId()
    {
        // limpiar posibles mensajes y recargar horas
        $this->errorMessage = null;
        $this->errorModal = false;
        $this->loadAvailableHours();
    }

    public function updatedDate()
    {
        $this->errorMessage = null;
        $this->errorModal = false;
        $this->loadAvailableHours();
    }

    /**
     * GUARDAR RESERVA
     */
    public function saveReservation()
    {
        // validación básica
        $this->validate();

        // Forzar duration entero (evita pasar string a addHours)
        $this->duration = intval($this->duration);

        // recalcular total
        $this->calculateTotal();

        if (!$this->total_price && $this->total_price !== 0) {
            $this->errorMessage = "Debe seleccionar duración y cancha para calcular el total.";
            $this->errorModal = true;
            return;
        }

        // VALIDAR RANGO COMPLETO: si hay conflicto -> mostrar error en modal y retornar
        if ($this->timeRangeHasConflict($this->field_id, $this->date, $this->start_time, $this->duration, $this->reservation_id)) {
            $this->errorMessage = "El horario seleccionado invade otro horario reservado.";
            $this->errorModal = true;
            return;
        }

        // Guardar cliente (updateOrCreate para soportar edición)
        $client = Client::updateOrCreate(
            ['id' => $this->client_id],
            [
                'name' => $this->name,
                'phone' => $this->phone,
                'team' => $this->team
            ]
        );

        // Hora final — usar duration int para addHours
        try {
            $end_time = Carbon::parse($this->start_time)->addHours(intval($this->duration))->format('H:i');
        } catch (\Exception $e) {
            $this->errorMessage = "Formato de hora inválido.";
            $this->errorModal = true;
            return;
        }

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
                'total_price' => $this->total_price ?? 0,
                'status' => $this->status,
            ]
        );

        $this->successMessage = "La reserva se guardó correctamente.";
        $this->successModal = true;

        // limpiar modal y estados
        $this->closeModal();

        // recargar horas por si se muestran inmediatamente
        $this->loadAvailableHours();
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
        // calcular duración como entero
        $this->duration = Carbon::parse($res->start_time)->diffInHours($res->end_time);
        $this->total_price = $res->total_price;
        $this->status = $res->status;

        $this->loadAvailableHours();
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
