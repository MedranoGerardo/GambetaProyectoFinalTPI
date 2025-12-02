<div class="container py-4 reservation-container">

    <div class="row g-4">

        <!-- ==========================
             PANEL IZQUIERDO
        =========================== -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">

                    <h3 class="text-center fw-bold mb-4 text-primary">
                        Calendario de Reservas
                    </h3>

                    <!-- Mensajes -->
                    @if ($successMessage)
                        <div class="alert alert-success shadow-sm fw-bold">
                            {{ $successMessage }}
                        </div>
                    @endif

                    @if ($errorMessage)
                        <div class="alert alert-danger shadow-sm fw-bold">
                            {{ $errorMessage }}
                        </div>
                    @endif

                    <div class="row g-3">

                        <!-- Cancha -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Cancha</label>
                            <select wire:model="selectedField" class="form-select shadow-sm">
                                <option value="">Seleccione una cancha</option>
                                @foreach ($fields as $field)
                                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Duración -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Duración (horas)</label>
                            <input type="number" min="1" wire:model="duration" class="form-control shadow-sm">
                        </div>

                    </div>

                </div>
            </div>
        </div>



        <!-- ==========================
             PANEL CALENDARIO
        =========================== -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">

                    <!-- Encabezado Mes -->
                    <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                        <button wire:click="goToPreviousMonth" class="btn btn-outline-primary btn-sm px-3">&lt;</button>

                        <h4 class="fw-bold m-0 text-capitalize">
                            {{ \Carbon\Carbon::create($currentYear, $currentMonth)->locale('es')->translatedFormat('F Y') }}
                        </h4>

                        <button wire:click="goToNextMonth" class="btn btn-outline-primary btn-sm px-3">&gt;</button>
                    </div>

                    <!-- Días de la semana -->
                    <div class="calendar-grid calendar-week-header mb-2">
                        <div>Lun</div>
                        <div>Mar</div>
                        <div>Mié</div>
                        <div>Jue</div>
                        <div>Vie</div>
                        <div>Sáb</div>
                        <div>Dom</div>
                    </div>

                    @php
                        $firstDay = \Carbon\Carbon::create($currentYear, $currentMonth, 1);
                        $startWeekDay = $firstDay->dayOfWeekIso;
                        $daysInMonth = $firstDay->daysInMonth;
                    @endphp

                    <div class="calendar-grid">

                        {{-- Espacios antes del día 1 --}}
                        @for ($i = 1; $i < $startWeekDay; $i++)
                            <div class="empty-day"></div>
                        @endfor

                        {{-- Días --}}
                        @for ($day = 1; $day <= $daysInMonth; $day++)

                            @php
                                $dateString = \Carbon\Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');

                                $isReserved = in_array($day, $reservedDays);
                                $isSelected = $selectedDate === $dateString;
                                $isPast = \Carbon\Carbon::create($currentYear, $currentMonth, $day)->isPast()
                                          && !\Carbon\Carbon::create($currentYear, $currentMonth, $day)->isToday();
                            @endphp

                            <div 
                                class="calendar-day 
                                    {{ $isReserved ? 'reserved' : '' }}
                                    {{ $isSelected ? 'selected' : '' }}
                                    {{ $isPast ? 'past' : '' }}"
                                wire:click="selectDay({{ $day }})"
                            >
                                {{ $day }}
                            </div>

                        @endfor

                    </div>

                </div>
            </div>
        </div>

    </div> <!-- row -->




    <!-- ==========================
         INFORMACIÓN DEL DÍA
    =========================== -->

    @if ($selectedDate && $selectedField)

        <div class="row mt-4">

            <!-- RESERVAS DEL DÍA -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h5 class="fw-bold text-danger mb-3">
                            Reservas para {{ $selectedDate }}
                        </h5>

                        @if (count($dayReservations) == 0)
                            <div class="alert alert-secondary">No hay reservas este día.</div>
                        @else
                            @foreach ($dayReservations as $res)
                                <div class="alert alert-info shadow-sm mb-3">
                                    <strong>Cliente:</strong> {{ $res->client->name ?? 'N/A' }} <br>
                                    <strong>Horario:</strong> {{ $res->start_time }} - {{ $res->end_time }} <br>
                                    <strong>Estado:</strong>
                                        <span class="badge bg-primary">{{ ucfirst($res->status) }}</span>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>


            <!-- HORAS DISPONIBLES -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">

                        <h5 class="fw-bold text-primary mb-3">
                            Horas disponibles para {{ $selectedDate }}
                        </h5>

                        @if (count($availableHours) == 0)
                            <div class="alert alert-warning">No hay horas libres este día.</div>
                        @else
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($availableHours as $hour)
                                    <button wire:click="$set('start_time','{{ $hour }}')"
                                        class="btn fw-bold px-3 py-2 shadow-sm 
                                        {{ $start_time == $hour ? 'btn-primary' : 'btn-outline-primary' }}">
                                        {{ $hour }}
                                    </button>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>

    @endif




    <!-- BOTÓN RESERVAR -->
    <div class="text-center mt-4 mb-5">
        <button wire:click="reserve" class="btn btn-success btn-lg px-5 fw-bold shadow">
            Reservar ahora
        </button>
    </div>

</div>
