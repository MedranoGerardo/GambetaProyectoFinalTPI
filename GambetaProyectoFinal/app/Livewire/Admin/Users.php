<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    public $name, $email, $password, $role = 'recepcionista';
    public $user_id;

    public $modalCreate = false;
    public $modalEdit = false;
    public $modalDelete = false;

    protected function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $this->user_id,
            'role'     => 'required|string',
            'password' => $this->user_id ? 'nullable|min:6' : 'required|min:6',
        ];
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'recepcionista';
        $this->user_id = null;
    }

    /* ===========================
       CREAR USUARIO
    ============================ */
    public function openCreate()
    {
        $this->resetFields();
        $this->modalCreate = true;
    }

    public function save()
    {
        $this->validate();

        User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
            'role'     => $this->role,
        ]);

        $this->modalCreate = false;
    }

    /* ===========================
       EDITAR USUARIO
    ============================ */
    public function openEdit($id)
    {
        $user = User::find($id);

        $this->user_id = $user->id;
        $this->name    = $user->name;
        $this->email   = $user->email;
        $this->role    = $user->role;
        $this->password = '';

        $this->modalEdit = true;
    }

    public function update()
    {
        $this->validate();

        $user = User::find($this->user_id);

        $user->name  = $this->name;
        $user->email = $this->email;
        $user->role  = $this->role;

        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $this->modalEdit = false;
    }

    /* ===========================
       ELIMINAR USUARIO
    ============================ */
    public function openDelete($id)
    {
        $this->user_id = $id;
        $this->modalDelete = true;
    }

    public function delete()
    {
        User::find($this->user_id)?->delete();

        $this->modalDelete = false;
    }

    public function render()
    {
        return view('livewire.admin.users', [
            'users' => User::orderBy('name')->get(),
        ]);
    }
}
