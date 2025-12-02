<div class="container py-4">

    <h3 class="mb-4 fw-bold text-center">Gestión de Reservas</h3>

    @if ($successMessage)
        <div class="alert alert-success fw-bold">{{ $successMessage }}</div>
    @endif

    @if ($errorMessage)
        <div class="alert alert-danger fw-bold">{{ $errorMessage }}</div>
    @endif

    <button class="btn btn-primary mb-3" wire:click="openModal">Nueva reserva</button>

    <!-- TABLA -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
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
                    <tr>
                        <td>{{ $res->client->name }}</td>
                        <td>{{ $res->field->name }}</td>
                        <td>{{ $res->date }}</td>
                        <td>{{ $res->start_time }} - {{ $res->end_time }}</td>
                        <td>$ {{ $res->total_price }}</td>
                        <td>
                            <select wire:change="updateStatus({{ $res->id }}, $event.target.value)"
                                    class="form-select">
                                <option value="pendiente" {{ $res->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmada" {{ $res->status == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="cancelada" {{ $res->status == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="finalizada" {{ $res->status == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm" wire:click="edit({{ $res->id }})">Editar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    {{ $reservations->links() }}

    <!-- MODAL -->
    @if ($modal)
        <div class="modal fade show d-block bg-dark bg-opacity-50">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">
                            {{ $reservation_id ? 'Editar Reserva' : 'Nueva Reserva' }}
                        </h5>
                        <button class="btn-close" wire:click="closeModal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="fw-bold">Nombre del cliente</label>
                            <input type="text" wire:model="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Teléfono</label>
                            <input type="text" wire:model="phone" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Equipo / Grupo</label>
                            <input type="text" wire:model="team" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Cancha</label>
                            <select wire:model="field_id" class="form-select" wire:change="calculateTotal">
                                <option value="">Seleccione cancha</option>
                                @foreach ($fields as $f)
                                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Fecha</label>
                            <input type="date" wire:model="date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Hora inicio</label>
                            <input type="time" wire:model="start_time" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Duración (horas)</label>
                            <input type="number" min="1" wire:model="duration"
                                wire:keyup="calculateTotal" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Total</label>
                            <input type="text" wire:model="total_price" class="form-control" readonly>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="closeModal">Cancelar</button>
                        <button class="btn btn-success" wire:click="saveReservation">Guardar</button>
                    </div>

                </div>
            </div>
        </div>
    @endif

</div>

