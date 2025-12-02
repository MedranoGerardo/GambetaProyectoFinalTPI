<div class="container py-4">

    <h2 class="fw-bold text-center mb-4 text-primary">Gestión de Reservas</h2>

    @if ($successMessage)
        <div class="alert alert-success fw-bold shadow-sm">{{ $successMessage }}</div>
    @endif

    @if ($errorMessage)
        <div class="alert alert-danger fw-bold shadow-sm">{{ $errorMessage }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary shadow-sm px-4" wire:click="openModal">
            <i class="bi bi-plus-circle me-1"></i> Nueva reserva
        </button>
    </div>

    <!-- TABLA -->
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Cliente</th>
                    <th>Cancha</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservations as $res)
                    <tr class="text-center">
                        <td class="fw-semibold">{{ $res->client->name }}</td>
                        <td>{{ $res->field->name }}</td>
                        <td>{{ $res->date }}</td>
                        <td>
                            <span class="badge bg-dark text-light">
                                {{ $res->start_time }} - {{ $res->end_time }}
                            </span>
                        </td>
                        <td class="fw-bold text-success">$ {{ $res->total_price }}</td>

                        <td>
                            <select wire:change="updateStatus({{ $res->id }}, $event.target.value)"
                                    class="form-select form-select-sm shadow-sm">
                                <option value="pendiente" {{ $res->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmada" {{ $res->status == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="cancelada" {{ $res->status == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="finalizada" {{ $res->status == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                            </select>
                        </td>

                        <td>
                            <button class="btn btn-warning btn-sm shadow-sm" wire:click="edit({{ $res->id }})">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div class="mt-3">
        {{ $reservations->links() }}
    </div>

    <!-- MODAL -->
    @if ($modal)
        <div class="modal fade show d-block bg-dark bg-opacity-50">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow-lg border-0 rounded-4">

                    <div class="modal-header bg-primary text-white rounded-top">
                        <h5 class="modal-title fw-bold">
                            {{ $reservation_id ? 'Editar Reserva' : 'Nueva Reserva' }}
                        </h5>
                        <button class="btn-close btn-close-white" wire:click="closeModal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row g-3">

                            <style>
                                label {
                                    color: var(--bs-body-color) !important;
                                    font-weight: 600;
                                }
                                .form-control, .form-select {
                                    border: 1.5px solid #cdd6dd !important;
                                    border-radius: 8px;
                                    padding: 10px;
                                }
                                .form-control:focus, .form-select:focus {
                                    border-color: #0d6efd !important;
                                    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
                                }
                            </style>

                            <div class="col-md-6">
                                <label>Nombre del cliente</label>
                                <input type="text" wire:model="name" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6">
                                <label>Teléfono</label>
                                <input type="text" wire:model="phone" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6">
                                <label>Equipo / Grupo</label>
                                <input type="text" wire:model="team" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6">
                                <label>Cancha</label>
                                <select wire:model="field_id" class="form-select shadow-sm" wire:change="calculateTotal">
                                    <option value="">Seleccione cancha</option>
                                    @foreach ($fields as $f)
                                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Fecha</label>
                                <input type="date" wire:model="date" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6">
                                <label>Hora inicio</label>
                                <input type="time" wire:model="start_time" class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6">
                                <label>Duración (horas)</label>
                                <input type="number" min="1" wire:model="duration"
                                       wire:keyup="calculateTotal"
                                       class="form-control shadow-sm">
                            </div>

                            <div class="col-md-6">
                                <label>Total</label>
                                <input type="text" wire:model="total_price"
                                       class="form-control shadow-sm bg-light fw-bold"
                                       readonly>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary px-4" wire:click="closeModal">Cancelar</button>
                        <button class="btn btn-success px-4" wire:click="saveReservation">Guardar</button>
                    </div>

                </div>
            </div>
        </div>
    @endif

</div>
