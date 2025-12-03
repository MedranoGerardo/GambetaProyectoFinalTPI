<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class Roles extends Component
{
    public $roles = [];

    public function mount()
    {
        foreach (User::all() as $u) {
            $this->roles[$u->id] = $u->role;
        }
    }

    public function updateRole($id)
    {
        $this->validate([
            "roles.$id" => "required|in:admin,recepcionista"
        ]);

        $user = User::find($id);
        $user->role = $this->roles[$id];
        $user->save();

        session()->flash('success', 'Rol actualizado correctamente.');
    }

    public function render()
    {
        return view('livewire.admin.roles', [
            'users' => User::all(),
        ]);
    }
}
