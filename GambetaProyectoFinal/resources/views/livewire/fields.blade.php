<div class="p-4">

    <!-- Botón crear -->
    <button wire:click="openModal"
        class="bg-blue-600 text-white px-4 py-2 rounded mb-3">
        Agregar Cancha
    </button>

    <!-- Tabla -->
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">Nombre</th>
                <th class="p-2 border">Tipo</th>
                <th class="p-2 border">Precio/Hora</th>
                <th class="p-2 border">Estado</th>
                <th class="p-2 border">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($fields as $field)
                <tr>
                    <td class="border p-2">{{ $field->name }}</td>
                    <td class="border p-2">{{ $field->type }}</td>
                    <td class="border p-2">$ {{ $field->price_per_hour }}</td>
                    <td class="border p-2">
                        @if($field->is_active)
                            <span class="text-green-600 font-bold">Disponible</span>
                        @else
                            <span class="text-red-600 font-bold">Inactiva</span>
                        @endif
                    </td>

                    <td class="border p-2">
                        <button wire:click="edit({{ $field->id }})"
                            class="bg-yellow-500 text-white px-2 py-1 rounded">
                            Editar
                        </button>

                        <button wire:click="delete({{ $field->id }})"
                            class="bg-red-600 text-white px-2 py-1 rounded"
                            onclick="return confirm('¿Eliminar?')">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $fields->links() }}
    </div>

    <!-- MODAL -->
    @if ($modal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">

            <div class="bg-white p-6 rounded shadow-lg w-96">
                <h2 class="text-xl font-bold mb-4">
                    {{ $field_id ? 'Editar Cancha' : 'Nueva Cancha' }}
                </h2>

                <!-- FORM -->
                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" wire:model="name" class="w-full border p-2">
                </div>

                <div class="mb-3">
                    <label>Tipo</label>
                    <input type="text" wire:model="type" class="w-full border p-2">
                </div>

                <div class="mb-3">
                    <label>Precio por hora</label>
                    <input type="number" step="0.01" wire:model="price_per_hour" class="w-full border p-2">
                </div>

                <div class="mb-3">
                    <label>Imagen (opcional)</label>
                    <input type="file" wire:model="image">
                </div>

                <div class="mb-3">
                    <label>Disponibilidad</label>
                    <select wire:model="is_active" class="w-full border p-2">
                        <option value="1">Disponible</option>
                        <option value="0">Inactiva</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button wire:click="closeModal" class="px-3 py-1 bg-gray-500 text-white rounded">
                        Cancelar
                    </button>

                    <button wire:click="save" class="px-3 py-1 bg-blue-600 text-white rounded">
                        Guardar
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>
