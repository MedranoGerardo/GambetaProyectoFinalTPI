<div class="container py-4">

    <h3 class="fw-bold mb-4">Gestión de Roles</h3>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol actual</th>
                <th>Cambiar rol</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        <span class="badge bg-{{ $user->role == 'admin' ? 'primary' : 'secondary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    <td>
                        <select wire:model="roles.{{ $user->id }}"
                                wire:change="updateRole({{ $user->id }})"
                                class="form-select">

                            <option value="admin">Administrador</option>
                            <option value="recepcionista">Recepcionista</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
