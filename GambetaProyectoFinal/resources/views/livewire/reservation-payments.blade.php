<div class="container py-4">

    {{-- Mensajes --}}
    @if ($successMessage)
        <div class="alert alert-success fw-bold">{{ $successMessage }}</div>
    @endif

    @if ($errorMessage)
        <div class="alert alert-danger fw-bold">{{ $errorMessage }}</div>
    @endif

    {{-- ENCABEZADO: INFORMACIÓN DE LA RESERVA --}}
    <div class="card border-info mb-4 shadow">
        <div class="card-body">

            <h4 class="fw-bold mb-3">
                Pago para: {{ $reservation->client->name }}
            </h4>

            <div class="row mb-2">
                <div class="col-md-4">
                    <strong>Teléfono:</strong>
                    <br>{{ $reservation->client->phone ?? 'N/A' }}
                </div>

                <div class="col-md-4">
                    <strong>Equipo / Grupo:</strong>
                    <br>{{ $reservation->client->team ?? 'N/A' }}
                </div>

                <div class="col-md-4">
                    <strong>Cancha:</strong>
                    <br>{{ $reservation->field->name }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4">
                    <strong>Fecha:</strong>
                    <br>{{ $reservation->date }}
                </div>

                <div class="col-md-4">
                    <strong>Horario:</strong>
                    <br>{{ $reservation->start_time }} - {{ $reservation->end_time }}
                </div>

                <div class="col-md-4">
                    <strong>Total a pagar:</strong>
                    <br><span class="fw-bold text-success">
                        ${{ number_format($reservation->total_price, 2) }}
                    </span>
                </div>
            </div>

            <div class="mt-3">
                <a href="/reservations/{{ $reservation->id }}/pdf" class="btn btn-outline-primary btn-sm">
                    Descargar comprobante PDF
                </a>
            </div>

        </div>
    </div>



    {{-- FORMULARIO PARA REGISTRAR PAGO --}}
    <div class="card mb-4 shadow">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Registrar pago</h5>

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="fw-bold">Monto</label>
                    <input type="number" wire:model="amount" step="0.01" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="fw-bold">Método</label>
                    <select wire:model="method" class="form-select">
                        <option value="efectivo">Efectivo</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="tarjeta">Tarjeta</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" wire:model="is_advance" class="form-check-input" id="adelantoCheck">
                        <label class="form-check-label fw-bold" for="adelantoCheck">¿Es adelanto?</label>
                    </div>
                </div>

            </div>

            <button wire:click="savePayment" class="btn btn-success mt-3 px-4">
                Registrar pago
            </button>

        </div>
    </div>



    {{-- HISTORIAL DE PAGOS --}}
    <h5 class="fw-bold">Historial de pagos</h5>

    @if ($payments->count() == 0)
        <div class="alert alert-warning">No hay pagos registrados para esta reserva.</div>
    @else
        <ul class="list-group shadow">
            @foreach ($payments as $p)
                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        <strong>${{ number_format($p->amount, 2) }}</strong>
                        — {{ ucfirst($p->method) }}
                        @if($p->is_advance)
                            <span class="badge bg-warning text-dark ms-2">Adelanto</span>
                        @endif
                    </div>
                    <span class="text-muted">{{ $p->created_at->format('d/m/Y h:i A') }}</span>
                </li>
            @endforeach
        </ul>
    @endif

</div>
