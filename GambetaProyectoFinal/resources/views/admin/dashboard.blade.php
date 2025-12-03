@extends('layouts.admin')

@section('content')

    <h1 class="admin-header">
        <i class="bi bi-speedometer2"></i> Dashboard
    </h1>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow p-4">
                <h4><i class="bi bi-calendar-check text-primary"></i> Reservas hoy</h4>
                <p class="mt-2 fs-4 fw-bold text-success">{{ $reservasHoy }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow p-4">
                <h4><i class="bi bi-people text-primary"></i> Clientes frecuentes</h4>
                <p class="mt-2 fs-4 fw-bold">{{ $clientesFrecuentes }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow p-4">
                <h4><i class="bi bi-dribbble text-primary"></i> Canchas activas</h4>
                <p class="mt-2 fs-4 fw-bold">{{ $canchasActivas }}</p>
            </div>
        </div>

    </div>

@endsection
