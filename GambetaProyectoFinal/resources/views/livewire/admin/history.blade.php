<div class="container py-4">

    <h2 class="fw-bold mb-4 text-primary text-center">
        Historial de Reservas
    </h2>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle">

            <thead class="table-dark text-center">
                <tr>
                    <th>Cliente</th>
                    <th>Cancha</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($reservations as $res)
                    <tr class="text-center">
                        <td>{{ $res->client->name ?? 'N/A' }}</td>
                        <td>{{ $res->field->name }}</td>
                        <td>{{ $res->date }}</td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $res->start_time }} - {{ $res->end_time }}
                            </span>
                        </td>

                        <td class="fw-bold text-success">
                            ${{ $res->total_price }}
                        </td>

                        <td>
                            <span class="badge 
                                {{ $res->status === 'pendiente' ? 'bg-warning' : '' }}
                                {{ $res->status === 'confirmada' ? 'bg-info' : '' }}
                                {{ $res->status === 'finalizada' ? 'bg-success' : '' }}
                                {{ $res->status === 'cancelada' ? 'bg-danger' : '' }}
                            ">
                                {{ ucfirst($res->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No hay reservas registradas aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="mt-3">
        {{ $reservations->links() }}
    </div>
</div>
