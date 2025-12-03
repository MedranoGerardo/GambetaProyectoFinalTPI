<div class="container py-4">

    <h2 class="fw-bold mb-4">Gestión de Usuarios</h2>

    <button class="btn btn-primary mb-3" wire:click="openCreate">
        Nuevo Usuario
    </button>

    <table class="table table-hover shadow-sm">
        <thead class="table-primary">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>
                    <span class="badge bg-info text-dark">
                        {{ ucfirst($u->role) }}
                    </span>
                </td>

                <td class="text-center">
                    <button class="btn btn-warning btn-sm" wire:click="openEdit({{ $u->id }})">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <button class="btn btn-danger btn-sm" wire:click="openDelete({{ $u->id }})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- MODAL CREAR --}}
    @if ($modalCreate)
    <div class="modal fade show d-block bg-dark bg-opacity-50">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Crear Usuario</h5>
                    <button class="btn-close" wire:click="$set('modalCreate', false)"></button>
                </div>

                <div class="modal-body">
                    <label>Nombre</label>
                    <input type="text" wire:model="name" class="form-control mb-2">

                    <label>Email</label>
                    <input type="email" wire:model="email" class="form-control mb-2">

                    <label>Contraseña</label>
                    <input type="password" wire:model="password" class="form-control mb-2">

                    <label>Rol</label>
                    <select wire:model="role" class="form-select">
                        <option value="recepcionista">Recepcionista</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="$set('modalCreate', false)">Cancelar</button>
                    <button class="btn btn-success" wire:click="save">Guardar</button>
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- MODAL EDITAR --}}
    @if ($modalEdit)
    <div class="modal fade show d-block bg-dark bg-opacity-50">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Editar Usuario</h5>
                    <button class="btn-close" wire:click="$set('modalEdit', false)"></button>
                </div>

                <div class="modal-body">
                    <label>Nombre</label>
                    <input type="text" wire:model="name" class="form-control mb-2">

                    <label>Email</label>
                    <input type="email" wire:model="email" class="form-control mb-2">

                    <label>Nueva Contraseña (opcional)</label>
                    <input type="password" wire:model="password" class="form-control mb-2">

                    <label>Rol</label>
                    <select wire:model="role" class="form-select">
                        <option value="recepcionista">Recepcionista</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="$set('modalEdit', false)">Cancelar</button>
                    <button class="btn btn-primary" wire:click="update">Actualizar</button>
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- MODAL ELIMINAR --}}
    @if ($modalDelete)
    <div class="modal fade show d-block bg-dark bg-opacity-50">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Eliminar Usuario</h5>
                    <button class="btn-close btn-close-white" wire:click="$set('modalDelete', false)"></button>
                </div>

                <div class="modal-body">
                    ¿Seguro que deseas eliminar este usuario?
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" wire:click="$set('modalDelete', false)">Cancelar</button>
                    <button class="btn btn-danger" wire:click="delete">Eliminar</button>
                </div>

            </div>
        </div>
    </div>
    @endif

</div>