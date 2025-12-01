<div class="container-fluid p-4">
    <!-- Botón crear -->
    <button wire:click="openModal" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Agregar Cancha
    </button>

    <!-- Tabla -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Precio/Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($fields as $field)
                    <tr>
                        <td>{{ $field->name }}</td>
                        <td>{{ $field->type }}</td>
                        <td>${{ number_format($field->price_per_hour, 2) }}</td>
                        <td>
                            @if($field->is_active)
                                <span class="badge bg-success">Disponible</span>
                            @else
                                <span class="badge bg-danger">Inactiva</span>
                            @endif
                        </td>

                        <td>
                            <div class="btn-group" role="group">
                                <button wire:click="edit({{ $field->id }})" 
                                    class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>

                                <button wire:click="confirmDelete({{ $field->id }})" 
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-3">
        {{ $fields->links() }}
    </div>

    <!-- MODAL CREAR/EDITAR -->
    @if ($modal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    
                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $field_id ? 'Editar Cancha' : 'Nueva Cancha' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" wire:model="name" class="form-control" placeholder="Ej: Cancha 1">
                            @error('name') 
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div class="mb-3">
                            <label class="form-label">Tipo</label>
                            <input type="text" wire:model="type" class="form-control" placeholder="Ej: Fútbol 5">
                            @error('type') 
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Precio -->
                        <div class="mb-3">
                            <label class="form-label">Precio por hora</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" wire:model="price_per_hour" 
                                    class="form-control" placeholder="0.00">
                            </div>
                            @error('price_per_hour') 
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Imagen -->
                        <div class="mb-3">
                            <label class="form-label">Imagen (opcional)</label>
                            <input type="file" wire:model="image" class="form-control">
                            @error('image') 
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="mb-3">
                            <label class="form-label">Disponibilidad</label>
                            <select wire:model="is_active" class="form-select">
                                <option value="1">Disponible</option>
                                <option value="0">Inactiva</option>
                            </select>
                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">
                            Cancelar
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="save">
                            <i class="bi bi-save"></i> Guardar
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif

    <!-- MODAL CONFIRMAR ELIMINACIÓN -->
    @if ($deleteModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    
                    <!-- Header -->
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle"></i> Confirmar Eliminación
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeDeleteModal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body text-center py-4">
                        <i class="bi bi-trash3 text-danger" style="font-size: 4rem;"></i>
                        <h5 class="mt-3">¿Está seguro de eliminar esta cancha?</h5>
                        <p class="text-muted">Esta acción no se puede deshacer.</p>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDeleteModal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="button" class="btn btn-danger" wire:click="delete">
                            <i class="bi bi-trash"></i> Sí, Eliminar
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>