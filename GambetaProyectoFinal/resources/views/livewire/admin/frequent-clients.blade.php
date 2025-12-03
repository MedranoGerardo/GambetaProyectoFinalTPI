<div class="container py-4">
    <h2 class="fw-bold mb-4">Clientes Frecuentes</h2>

    @if ($clients->count() == 0)
        <div class="alert alert-secondary">
            No hay clientes registrados aún.
        </div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>Equipo</th>
                        <th>Total Reservas</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($clients as $client)
                    <tr>
                        <td class="fw-bold">{{ $client->name }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->team }}</td>
                        <td class="text-success fw-bold">{{ $client->total_reservas }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    @endif
</div>
