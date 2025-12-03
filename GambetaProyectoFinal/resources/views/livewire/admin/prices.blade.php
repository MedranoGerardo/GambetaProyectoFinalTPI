<div class="container py-4">

    <h3 class="fw-bold mb-4">Gestión de Precios de Canchas</h3>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Cancha</th>
                <th>Precio actual</th>
                <th>Nuevo precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($fields as $field)
                <tr>
                    <td>{{ $field->name }}</td>

                    <td>${{ number_format($field->price_per_hour, 2) }}</td>

                    <td>
                        <input type="number"
                            step="0.01"
                            wire:model.defer="prices.{{ $field->id }}"
                            class="form-control">
                    </td>

                    <td>
                        <button class="btn btn-success btn-sm"
                                wire:click="updatePrice({{ $field->id }})">
                            Guardar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
