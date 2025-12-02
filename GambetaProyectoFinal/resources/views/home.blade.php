@extends('layouts.app')

@section('content')


    <!-- HERO -->
    <section class="hero-section d-flex align-items-center justify-content-center text-center">
        <div class="container">

            <h1 class="display-4 fw-bold text-success mb-3 hero-title">
                Reserva tu cancha en segundos
            </h1>

            <p class="lead text-light mb-4">
                Disponibilidad en tiempo real. Pagos rápidos. Confirmaciones inmediatas.
            </p>

            <a href="/reservar" class="btn btn-success btn-lg me-2">Reservar Ahora</a>
            <a href="/canchas" class="btn btn-outline-light btn-lg">Ver Canchas</a>

        </div>
    </section>


@endsection
