<div class="admin-sidebar">

    <h3 class="text-center mb-4 fw-bold">
        <i class="bi bi-lightning-charge-fill text-success"></i> Gambeta
    </h3>

    <ul class="nav flex-column">

        {{-- Dashboard --}}
        <li class="nav-item mb-2">
            <a href="/admin" class="nav-link">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

                {{-- Solo ADMIN --}}
        @if(auth()->user()->role === 'admin')

            {{-- Canchas --}}
            <li class="nav-item mb-2">
                <a href="/admin/canchas" class="nav-link">
                    <i class="bi bi-dribbble me-2"></i>
                    Canchas
                </a>
            </li>

        {{-- Calendario (ambos roles) --}}
        <li class="nav-item mb-2">
            <a href="/admin/calendario" class="nav-link">
                <i class="bi bi-calendar-event me-2"></i>
                Calendario
            </a>
        </li>

        {{-- Reservas (ambos roles) --}}
        <li class="nav-item mb-2">
            <a href="/admin/reservas" class="nav-link">
                <i class="bi bi-journal-text me-2"></i>
                Reservas
            </a>
        </li>


            {{-- Bloqueos --}}
            <li class="nav-item mb-2">
                <a href="/admin/blocked-times" class="nav-link">
                    <i class="bi bi-lock-fill me-2"></i>
                    Bloqueos
                </a>
            </li>

            {{-- Precios --}}
            <li class="nav-item mb-4">
                <a href="/admin/prices" class="nav-link">
                    <i class="bi bi-cash-coin me-2"></i>
                    Precios
                </a>
            </li>

        @endif

        {{-- Cerrar sesión --}}
        <li class="nav-item mt-3">
            <form action="/logout" method="POST">
                @csrf
                <button class="btn btn-danger w-100 fw-bold">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Cerrar sesión
                </button>
            </form>
        </li>

    </ul>

</div>
