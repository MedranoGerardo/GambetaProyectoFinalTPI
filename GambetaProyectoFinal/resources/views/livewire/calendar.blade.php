<div class="container py-4">

    <h3 class="mb-3 text-center fw-bold">Calendario de Reservas</h3>

    <!-- Notificaciones bonitas -->
    @if ($successMessage)
        <div class="alert alert-success shadow-sm fw-bold">{{ $successMessage }}</div>
    @endif

    @if ($errorMessage)
        <div class="alert alert-danger shadow-sm fw-bold">{{ $errorMessage }}</div>
    @endif

    <div class="row g-3">

        <!-- Selección de cancha -->
        <div class="col-md-4">
            <label class="form-label fw-bold">Cancha</label>
            <select wire:model="selectedField" class="form-select">
                <option value="">Seleccione</option>
                @foreach ($fields as $field)
                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Fecha -->
        <div class="col-md-4">
            <label class="form-label fw-bold">Fecha</label>
            <input type="date" wire:model="selectedDate" class="form-control">
        </div>

        <!-- Duración -->
        <div class="col-md-4">
            <label class="form-label fw-bold">Duración (horas)</label>
            <input type="number" wire:model="duration" class="form-control" min="1">
        </div>

    </div>

    <!-- Disponibilidad -->
    <div class="mt-4">

        <h5 class="fw-bold">Horas disponibles</h5>

        @if (count($availableHours) == 0)
            <div class="alert alert-warning">No hay horarios libres este día.</div>
        @else
            <div class="row g-2">
                @foreach ($availableHours as $hour)
                    <div class="col-4 col-md-2">
                        <button wire:click="$set('start_time','{{ $hour }}')"
                            class="btn w-100 
                            {{ $start_time == $hour ? 'btn-primary' : 'btn-outline-primary' }}">
                            {{ $hour }}
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Botón reservar -->
    <div class="text-center mt-4">
        <button wire:click="reserve" class="btn btn-success px-4 py-2 fw-bold">
            Reservar ahora
        </button>
    </div>

</div>
