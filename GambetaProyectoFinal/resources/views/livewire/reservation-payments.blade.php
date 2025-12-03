<div class="container py-5">
    <!-- Mensajes -->
    @if ($successMessage)
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>¡Éxito!</strong> {{ $successMessage }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if ($errorMessage)
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Error:</strong> {{ $errorMessage }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- ===============================
        ENCABEZADO DE LA RESERVA
    ================================ -->
    <div class="card shadow-lg border-0 mb-4 overflow-hidden">
        <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #1A7FB8 0%, #0d5a8a 100%);">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bi bi-receipt-cutoff fs-3 me-3"></i>
                    <div>
                        <h4 class="mb-0 fw-bold">Detalles de Reserva</h4>
                        <small class="opacity-75">Gestión de pagos</small>
                    </div>
                </div>
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                    <i class="bi bi-calendar-check me-1"></i>
                    ID: #{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}
                </span>
            </div>
        </div>

        <div class="card-body p-4" style="background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);">

            <!-- Cliente Info -->
            <div class="row g-0 mb-4 pb-3 border-bottom">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-person-fill text-primary fs-4"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">Cliente</small>
                            <h5 class="mb-0 fw-bold text-dark-emphasis">{{ $reservation->client->name }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="row g-3 mb-4">

                <div class="col-md-4">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(26, 127, 184, 0.05); border-left: 3px solid #1A7FB8;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-telephone-fill text-primary me-2"></i>
                            <small class="text-muted fw-semibold">Teléfono</small>
                        </div>
                        <p class="mb-0 fw-bold text-dark-emphasis">{{ $reservation->client->phone ?? 'No especificado' }}</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(52, 152, 219, 0.05); border-left: 3px solid #3498db;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-people-fill text-info me-2"></i>
                            <small class="text-muted fw-semibold">Equipo / Grupo</small>
                        </div>
                        <p class="mb-0 fw-bold text-dark-emphasis">{{ $reservation->client->team ?? 'No especificado' }}</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(46, 204, 113, 0.05); border-left: 3px solid #2ecc71;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-geo-alt-fill text-success me-2"></i>
                            <small class="text-muted fw-semibold">Cancha</small>
                        </div>
                        <p class="mb-0 fw-bold text-dark-emphasis">{{ $reservation->field->name }}</p>
                    </div>
                </div>

            </div>

            <div class="row g-3 mb-3">

                <div class="col-md-4">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(155, 89, 182, 0.05); border-left: 3px solid #9b59b6;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-calendar3 text-purple me-2"></i>
                            <small class="text-muted fw-semibold">Fecha</small>
                        </div>
                        <p class="mb-0 fw-bold text-dark-emphasis">
                            {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 rounded-3 h-100" style="background: rgba(241, 196, 15, 0.05); border-left: 3px solid #f1c40f;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-clock-fill text-warning me-2"></i>
                            <small class="text-muted fw-semibold">Horario</small>
                        </div>
                        <p class="mb-0 fw-bold text-dark-emphasis">
                            {{ $reservation->start_time }} - {{ $reservation->end_time }}
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 rounded-3 h-100" style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.1) 0%, rgba(39, 174, 96, 0.1) 100%); border-left: 3px solid #27ae60;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-cash-coin text-success me-2"></i>
                            <small class="text-muted fw-semibold">Total a Pagar</small>
                        </div>
                        <p class="mb-0 fs-4 fw-bold" style="color: #27ae60;">
                            ${{ number_format($reservation->total_price, 2) }}
                        </p>
                    </div>
                </div>

            </div>

            <!-- BOTÓN PDF CORREGIDO -->
            <div class="text-end mt-3">
                <a href="/reservations/{{ $reservation->id }}/payments/pdf"
                   class="btn btn-outline-primary btn-lg shadow-sm px-4">
                    <i class="bi bi-file-earmark-pdf me-2"></i>
                    Descargar Comprobante PDF
                </a>
            </div>

        </div>
    </div>

    <!-- ===============================
        FORMULARIO DE REGISTRO DE PAGO CON VALIDACIONES
    ================================ -->
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
            <div class="d-flex align-items-center">
                <i class="bi bi-wallet2 fs-3 me-3"></i>
                <div>
                    <h5 class="mb-0 fw-bold">Registrar Nuevo Pago</h5>
                    <small class="opacity-75">Complete los datos del pago</small>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            @php
                $totalPagado = $payments->sum('amount');
                $saldoPendiente = $reservation->total_price - $totalPagado;
                $saldoDisponible = max(0, $saldoPendiente);
                $estaPagadoCompleto = $saldoPendiente <= 0;
            @endphp

            @if($estaPagadoCompleto)
            <div class="alert alert-success border-0 mb-4">
                <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                <strong>¡Reserva Pagada en su Totalidad!</strong>
                <p class="mb-0 mt-2">No se pueden registrar más pagos para esta reserva.</p>
            </div>
            @else
            <form wire:submit.prevent="savePayment">
                <div class="row g-4">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark-emphasis">
                            Monto a Pagar
                        </label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-cash"></i>
                            </span>
                            <input type="number" 
                                   step="0.01" 
                                   wire:model="amount"
                                   wire:keyup="validateAmount"
                                   class="form-control border-start-0 ps-0 text-dark-emphasis bg-white {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                   placeholder="0.00"
                                   min="0.01"
                                   max="{{ $saldoDisponible }}"
                                   @if($saldoDisponible == 0) disabled @endif>
                        </div>
                        @error('amount')
                            <div class="text-danger small mt-1">
                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @else
                            <small class="text-body-secondary">
                                <i class="bi bi-info-circle me-1"></i>
                                Máximo: ${{ number_format($saldoDisponible, 2) }}
                            </small>
                        @enderror
                        
                        <!-- Botón para pagar saldo completo -->
                        @if($saldoDisponible > 0)
                        <div class="mt-2">
                            <button type="button" 
                                    wire:click="setFullAmount"
                                    class="btn btn-sm btn-outline-success">
                                <i class="bi bi-arrow-up-circle me-1"></i>
                                Pagar saldo completo (${{ number_format($saldoDisponible, 2) }})
                            </button>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark-emphasis">
                            Método de Pago
                        </label>
                        <select wire:model="method" 
                                class="form-select shadow-sm text-dark-emphasis bg-white {{ $errors->has('method') ? 'is-invalid' : '' }}"
                                @if($saldoDisponible == 0) disabled @endif>
                            <option value="">Seleccione método</option>
                            <option value="efectivo">Efectivo</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                        @error('method')
                            <div class="text-danger small mt-1">
                                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark-emphasis">
                            Tipo de Pago
                        </label>

                        <div class="p-3 rounded-3 shadow-sm d-flex align-items-center gap-3"
                            style="background: rgba(230, 126, 34, 0.08); border-left: 3px solid #e67e22;">

                            <div class="form-check form-switch m-0">
                                <input type="checkbox" 
                                       wire:model="is_advance"
                                       class="form-check-input"
                                       id="advanceCheck"
                                       style="cursor: pointer; width: 2.3rem; height: 1.2rem;"
                                       @if($saldoDisponible == 0) disabled @endif>
                            </div>

                            <label for="advanceCheck" class="fw-semibold m-0 text-dark-emphasis" style="cursor: pointer;">
                                {{ $is_advance ? 'Adelanto' : 'Pago Completo' }}
                                @if($is_advance)
                                <div class="small text-warning mt-1">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Se registrará como pago parcial
                                </div>
                                @else
                                <div class="small text-success mt-1">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Se registrará como pago total
                                </div>
                                @endif
                            </label>
                        </div>
                        <div class="mt-2">
                            @if($is_advance && $amount > 0)
                                @php
                                    $nuevoSaldo = $saldoDisponible - $amount;
                                @endphp
                                @if($nuevoSaldo > 0)
                                <div class="alert alert-warning border-0 py-2 small">
                                    <i class="bi bi-hourglass-split me-1"></i>
                                    Después de este pago faltará: ${{ number_format($nuevoSaldo, 2) }}
                                </div>
                                @elseif($nuevoSaldo == 0)
                                <div class="alert alert-success border-0 py-2 small">
                                    <i class="bi bi-check-circle me-1"></i>
                                    ¡Este pago completaría el saldo!
                                </div>
                                @endif
                            @endif
                        </div>
                    </div>

                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit"
                            class="btn btn-success btn-lg px-5 shadow"
                            @if($saldoDisponible == 0) disabled @endif>
                        <i class="bi bi-check-circle me-2"></i>
                        {{ $is_advance ? 'Registrar Adelanto' : 'Registrar Pago Completo' }}
                    </button>
                    
                    @if($saldoDisponible == 0)
                    <div class="mt-2 text-muted small">
                        <i class="bi bi-info-circle me-1"></i>
                        La reserva ya está pagada en su totalidad
                    </div>
                    @endif
                </div>
            </form>
            @endif

            <!-- Resumen de pago actual -->
            <div class="mt-4 pt-3 border-top">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border">
                            <small class="text-muted d-block mb-1">Total Reserva</small>
                            <h5 class="mb-0 fw-bold text-primary">
                                ${{ number_format($reservation->total_price, 2) }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border">
                            <small class="text-muted d-block mb-1">Total Pagado</small>
                            <h5 class="mb-0 fw-bold {{ $totalPagado > 0 ? 'text-success' : 'text-muted' }}">
                                ${{ number_format($totalPagado, 2) }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border">
                            <small class="text-muted d-block mb-1">Saldo Pendiente</small>
                            <h5 class="mb-0 fw-bold {{ $saldoPendiente > 0 ? 'text-danger' : 'text-success' }}">
                                @if($saldoPendiente > 0)
                                ${{ number_format($saldoPendiente, 2) }}
                                @else
                                <i class="bi bi-check-circle me-1"></i> Pagado
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===============================
        REGISTRO DE PAGO DE CANCHA
    ================================ -->
    <div class="card shadow-lg border-0">
        <div class="card-header py-3" style="background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bi bi-cash-coin fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-0 fw-bold">Historial de Pagos - Alquiler de Cancha</h5>
                        <small class="opacity-75">
                            {{ $payments->count() == 0 ? 'Sin pagos registrados' : ($payments->count() == 1 ? '1 pago registrado' : $payments->count() . ' pagos registrados') }}
                        </small>
                    </div>
                </div>
                @if($payments->count() > 0)
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                    <i class="bi bi-wallet2 me-1"></i>
                    Abonado: ${{ number_format($payments->sum('amount'), 2) }}
                </span>
                @endif
            </div>
        </div>

        <div class="card-body p-0">

            @if ($payments->count() == 0)

            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-cash text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                </div>
                <h5 class="text-muted mb-2">No hay pagos registrados</h5>
                <p class="text-muted small">Registra el primer pago del alquiler</p>
            </div>

            @else

            <ul class="list-group list-group-flush">

                @foreach ($payments as $p)
                <li class="list-group-item px-4 py-3 border-start-0 border-end-0">
                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="{{ $p->is_advance ? 'bg-warning' : 'bg-success' }} bg-opacity-10 rounded-circle p-3">
                                    @if($p->is_advance)
                                    <i class="bi bi-piggy-bank-fill text-warning fs-4"></i>
                                    @else
                                    <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold {{ $p->is_advance ? 'text-warning' : 'text-success' }}">
                                    ${{ number_format($p->amount, 2) }}
                                    <span class="badge ms-2 {{ $p->is_advance ? 'bg-warning text-dark' : 'bg-success text-white' }}">
                                        @if($p->is_advance)
                                        <i class="bi bi-arrow-up-circle me-1"></i> Adelanto
                                        @else
                                        <i class="bi bi-check-circle me-1"></i> Pago Total
                                        @endif
                                    </span>
                                </h5>
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-1">
                                        @if($p->method == 'efectivo')
                                        <i class="bi bi-cash-coin me-1"></i> Efectivo
                                        @elseif($p->method == 'transferencia')
                                        <i class="bi bi-bank me-1"></i> Transferencia
                                        @else
                                        <i class="bi bi-credit-card me-1"></i> Tarjeta
                                        @endif
                                    </span>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $p->created_at->format('d/m/Y') }}
                                    </small>
                                </div>

                                <!-- 💾 BOTÓN PDF CORREGIDO -->
                                <div class="mt-2">
                                    <a href="/payments/{{ $p->id }}/pdf" 
                                       class="btn btn-sm btn-outline-primary shadow-sm px-3" 
                                       target="_blank">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>
                                        Comprobante PDF
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <div class="mb-2">
                                @if($p->is_advance)
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning px-3 py-2">
                                    <i class="bi bi-hourglass-split me-1"></i>
                                    Pago Parcial
                                </span>
                                @else
                                <span class="badge bg-success-subtle text-success-emphasis border border-success px-3 py-2">
                                    <i class="bi bi-check2-all me-1"></i>
                                    Pago Completo
                                </span>
                                @endif
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-clock me-1"></i>
                                {{ $p->created_at->format('h:i A') }}
                            </div>
                        </div>

                    </div>
                </li>
                @endforeach

            </ul>

            <!-- Resumen de Pagos -->
            @php
            $totalPagado = $payments->sum('amount');
            $pendiente = $reservation->total_price - $totalPagado;
            $porcentajePagado = $reservation->total_price > 0 ? min(100, ($totalPagado / $reservation->total_price) * 100) : 0;
            @endphp

            <div class="p-4 border-top" style="background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);">

                <!-- Barra de progreso -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Progreso del Pago</span>
                        <span class="fw-bold {{ $porcentajePagado == 100 ? 'text-success' : ($porcentajePagado > 0 ? 'text-warning' : 'text-muted') }}">
                            {{ number_format($porcentajePagado, 1) }}%
                        </span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar {{ $porcentajePagado == 100 ? 'bg-success' : 'bg-warning' }}"
                            role="progressbar"
                            style="width: {{ $porcentajePagado }}%;"
                            aria-valuenow="{{ $porcentajePagado }}"
                            aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-center p-3 rounded-3 border" style="background: rgba(52, 152, 219, 0.05);">
                            <small class="text-muted d-block mb-1">Valor del Alquiler</small>
                            <h5 class="mb-0 fw-bold text-primary">
                                ${{ number_format($reservation->total_price, 2) }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 rounded-3 border" style="background: rgba(46, 204, 113, 0.05);">
                            <small class="text-muted d-block mb-1">Total Abonado</small>
                            <h5 class="mb-0 fw-bold {{ $totalPagado > 0 ? 'text-success' : 'text-muted' }}">
                                ${{ number_format($totalPagado, 2) }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 rounded-3 border"
                            style="background: {{ $pendiente > 0 ? 'rgba(231, 76, 60, 0.05)' : 'rgba(46, 204, 113, 0.05)' }};">
                            <small class="text-muted d-block mb-1">Saldo por Pagar</small>
                            <h5 class="mb-0 fw-bold {{ $pendiente > 0 ? 'text-danger' : 'text-success' }}">
                                @if($pendiente > 0)
                                ${{ number_format($pendiente, 2) }}
                                @else
                                <i class="bi bi-check-circle me-1"></i> Pagado Total
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>

                <!-- Estado de la deuda -->
                <div class="mt-4 text-center">
                    @if($pendiente == 0)
                    <div class="alert alert-success border-0 py-3">
                        <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                        <strong>¡Alquiler Pagado en su Totalidad!</strong>
                        <p class="mb-0 small mt-1">El pago del alquiler de cancha está completo.</p>
                    </div>
                    @elseif($pendiente > 0 && $totalPagado > 0)
                    <div class="alert alert-warning border-0 py-3">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
                        <strong>Pago Parcial Registrado</strong>
                        <p class="mb-0 small mt-1">Falta abonar ${{ number_format($pendiente, 2) }} para completar el pago.</p>
                    </div>
                    @endif
                </div>

            </div>
            @endif
        </div>
    </div>

</div>