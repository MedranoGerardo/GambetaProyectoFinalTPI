@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 75vh;">

    <div class="card shadow p-4" style="max-width: 420px; width: 100%;">

        {{-- ENCABEZADO --}}
        <div class="text-center mb-4">
            <i class="bi bi-lightning-charge-fill text-success" style="font-size: 2.8rem;"></i>
            <h3 class="fw-bold mt-2">Panel Administrativo</h3>
            <p class="text-soft">Ingrese sus credenciales</p>
        </div>

        {{-- ERROR CORREO --}}
        @error('email')
            <div class="alert alert-danger text-center">{{ $message }}</div>
        @enderror

        {{-- ERROR CONTRASEÑA --}}
        @error('password')
            <div class="alert alert-danger text-center">{{ $message }}</div>
        @enderror

        {{-- FORMULARIO --}}
        <form method="POST" action="/login">
            @csrf

            {{-- CORREO --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Correo electrónico</label>
                <input type="email" 
                       name="email" 
                       class="form-control" 
                       placeholder="Ingrese su correo"
                       required autofocus>
            </div>

{{-- CONTRASEÑA --}}
<div class="mb-3 input-eye-wrapper">
    <label class="form-label fw-bold">Contraseña</label>

    <input type="password"
           name="password"
           id="passwordInput"
           class="form-control"
           placeholder="Ingrese su contraseña"
           required
           style="padding-right: 45px;">

    <span class="eye-toggle-btn" onclick="togglePassword()">
        <i id="toggleIcon" class="bi bi-eye-fill eye-toggle-icon"></i>
    </span>
</div>


            {{-- BOTÓN --}}
            <button class="btn btn-success w-100 fw-bold py-2">
                Iniciar sesión
            </button>
        </form>

    </div>

</div>





<style>
    /* Ícono SIEMPRE negro */
.light-mode .eye-toggle-icon,
.dark-mode .eye-toggle-icon,
.form-control + .eye-toggle-btn i {
    color: #000 !important;
}

/* Contenedor para que la posición absoluta funcione */
.input-eye-wrapper {
    position: relative;
    width: 100%;
}

/* Icono dentro del input */
.eye-toggle-btn {
    position: absolute;
    right: 12px;
    top: 80%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 20;
}

</style>
{{-- TOGGLE PASSWORD --}}
<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('toggleIcon');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye-fill");
        icon.classList.add("bi-eye-slash-fill");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye-slash-fill");
        icon.classList.add("bi-eye-fill");
    }
}
</script>

@endsection