<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\Payment;

class ReservationPayments extends Component
{
    public $reservation_id;
    public $amount;
    public $method = 'efectivo';
    public $is_advance = false;

    public $successMessage;
    public $errorMessage;

    protected $rules = [
        'amount' => 'required|numeric|min:0.01',
        'method' => 'required|string',
    ];

    public function mount($reservation_id)
    {
        $this->reservation_id = $reservation_id;
    }

    public function savePayment()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->errorMessage = "Complete los datos del pago.";
            return;
        }

        Payment::create([
            'reservation_id' => $this->reservation_id,
            'amount' => $this->amount,
            'method' => $this->method,
            'is_advance' => $this->is_advance,
        ]);

        $this->successMessage = "✔️ Pago registrado correctamente.";
        $this->reset('amount', 'method', 'is_advance');
    }

    public function render()
    {
        return view('livewire.reservation-payments', [
            'payments' => Payment::where('reservation_id', $this->reservation_id)->get(),
            'reservation' => Reservation::find($this->reservation_id)
        ]);
    }
}
