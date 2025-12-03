<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold text-success" href="/">
            <i class="bi bi-lightning-charge-fill"></i> Gambeta
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">

            {{-- LINKS PÚBLICOS --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item"><a class="nav-link" href="/">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="/canchas">Canchas</a></li>
                <li class="nav-item"><a class="nav-link" href="/reservar">Reservar</a></li>

            </ul>

            {{-- PARTE DERECHA --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                {{-- SI NO ESTÁ LOGUEADO --}}
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Iniciar sesión</a>
                    </li>
                @endguest

                {{-- SI ESTÁ LOGUEADO --}}
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Panel</a>
                    </li>

                    <li class="nav-item">
                        <form action="/logout" method="POST">
                            @csrf
                            <button class="btn nav-link text-danger">Cerrar sesión</button>
                        </form>
                    </li>
                @endauth

                {{-- BOTÓN DE MODO --}}
                <li class="nav-item">
                    <button id="themeToggle" class="btn btn-outline-success ms-2">
                        <i id="themeIcon" class="bi bi-moon-fill"></i>
                    </button>
                </li>

            </ul>
        </div>

    </div>
</nav>
