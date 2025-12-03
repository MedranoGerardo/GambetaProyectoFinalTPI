<div class="container py-4">

    <h3 class="fw-bold mb-4">Bloqueo de horarios</h3>

    {{-- Mensajes --}}
    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Agregar bloqueo</h5>

            <div class="row g-3">

                {{-- Cancha --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">Cancha</label>
                    <select wire:model="field" class="form-select">
                        <option value="">Seleccione</option>
                        @foreach ($fields as $f)
                            <option value="{{ $f->id }}">{{ $f->name }}</option>
                        @endforeach
                    </select>
                    @error('field') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Fecha --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">Fecha</label>
                    <input type="date" wire:model="date" class="form-control">
                    @error('date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Hora inicio --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">Hora de inicio</label>
                    <input type="time" wire:model="start_time" class="form-control">
                    @error('start_time') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Hora fin --}}
                <div class="col-md-3">
                    <label class="form-label fw-bold">Hora final</label>
                    <input type="time" wire:model="end_time" class="form-control">
                    @error('end_time') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Motivo --}}
                <div class="col-md-12">
                    <label class="form-label fw-bold">Motivo (opcional)</label>
                    <input type="text" wire:model="reason" class="form-control" placeholder="Mantenimiento, limpieza, evento…">
                    @error('reason') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

            </div>

            <button wire:click="save" class="btn btn-danger mt-3">
                Bloquear horario
            </button>

        </div>
    </div>


    {{-- Tabla de bloqueos --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Lista de horarios bloqueados</h5>

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Cancha</th>
                        <th>Fecha</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($blocked as $b)
                        <tr>
                            <td>{{ $b->field->name }}</td>
                            <td>{{ $b->date }}</td>
                            <td>{{ substr($b->start_time, 0, 5) }}</td>
                            <td>{{ substr($b->end_time, 0, 5) }}</td>
                            <td>{{ $b->reason ?? '—' }}</td>

                            <td>
                                <button wire:click="delete({{ $b->id }})" class="btn btn-sm btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                No hay horarios bloqueados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
