<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\Payment;

class ReservationPayments extends Component
{
    public $reservation_id;
    public $amount;
    public $method = '';
    public $is_advance = false;

    public $successMessage;
    public $errorMessage;

    protected $rules = [
        'amount' => 'required|numeric|min:0.01',
        'method' => 'required|string|in:efectivo,transferencia',
    ];

    protected $messages = [
        'amount.required' => 'El monto es obligatorio.',
        'amount.numeric' => 'El monto debe ser un número válido.',
        'amount.min' => 'El monto mínimo es $0.01.',
        'method.required' => 'Debe seleccionar un método de pago.',
        'method.in' => 'Método de pago no válido.',
    ];

    public function mount($reservation_id)
    {
        $this->reservation_id = $reservation_id;
    }

    public function savePayment()
    {
        // Validar que la reserva existe
        $reservation = Reservation::findOrFail($this->reservation_id);
        
        // Calcular saldo pendiente
        $totalPagado = Payment::where('reservation_id', $this->reservation_id)->sum('amount');
        $saldoPendiente = $reservation->total_price - $totalPagado;
        
        // Validar que hay saldo pendiente
        if ($saldoPendiente <= 0) {
            $this->errorMessage = "La reserva ya está pagada en su totalidad.";
            return;
        }

        // Validar monto máximo
        $this->rules['amount'] .= '|max:' . $saldoPendiente;
        $this->messages['amount.max'] = "El monto máximo permitido es $" . number_format($saldoPendiente, 2);

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->errorMessage = "Por favor corrija los errores en el formulario.";
            throw $e;
        }

        // Verificar que no sea negativo
        if ($this->amount <= 0) {
            $this->errorMessage = "El monto debe ser mayor a cero.";
            return;
        }

        // Verificar que no exceda el saldo pendiente
        if ($this->amount > $saldoPendiente) {
            $this->errorMessage = "El monto excede el saldo pendiente de $" . number_format($saldoPendiente, 2);
            return;
        }

        try {
            Payment::create([
                'reservation_id' => $this->reservation_id,
                'amount' => $this->amount,
                'method' => $this->method,
                'is_advance' => $this->is_advance,
            ]);

            $this->successMessage = "✔️ Pago registrado correctamente.";
            $this->reset(['amount', 'method', 'is_advance', 'errorMessage']);
            
            // Si se pagó completamente, actualizar estado de la reserva
            $nuevoTotalPagado = $totalPagado + $this->amount;
            if ($nuevoTotalPagado >= $reservation->total_price) {
                // Opcional: actualizar estado de la reserva
                // $reservation->update(['status' => 'pagado']);
                $this->successMessage = "✔️ ¡Pago completado! La reserva ha sido pagada en su totalidad.";
            }
            
        } catch (\Exception $e) {
            $this->errorMessage = "Error al registrar el pago: " . $e->getMessage();
        }
    }

    public function setFullAmount()
    {
        $reservation = Reservation::findOrFail($this->reservation_id);
        $totalPagado = Payment::where('reservation_id', $this->reservation_id)->sum('amount');
        $saldoPendiente = $reservation->total_price - $totalPagado;
        
        if ($saldoPendiente > 0) {
            $this->amount = $saldoPendiente;
            $this->is_advance = false; // Si es el monto completo, no es adelanto
        }
    }

    public function validateAmount()
    {
        if ($this->amount) {
            $reservation = Reservation::findOrFail($this->reservation_id);
            $totalPagado = Payment::where('reservation_id', $this->reservation_id)->sum('amount');
            $saldoPendiente = $reservation->total_price - $totalPagado;
            
            if ($this->amount < 0.01) {
                $this->addError('amount', 'El monto mínimo es $0.01.');
            } elseif ($this->amount > $saldoPendiente) {
                $this->addError('amount', "Monto excede el saldo pendiente de $" . number_format($saldoPendiente, 2));
            } else {
                $this->resetErrorBag('amount');
            }
        }
    }

    public function render()
    {
        return view('livewire.reservation-payments', [
            'payments' => Payment::where('reservation_id', $this->reservation_id)
                                ->orderBy('created_at', 'desc')
                                ->get(),
            'reservation' => Reservation::with(['client', 'field'])->findOrFail($this->reservation_id)
        ]);
    }
}