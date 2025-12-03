<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    public $name, $email, $password, $role = 'recepcionista';
    public $user_id;
    public $modal = false;

    protected $rules = [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role'     => 'required|string'
    ];

    public function openModal()
    {
        $this->resetFields();
        $this->modal = true;
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'recepcionista';
        $this->user_id = null;
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

        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.admin.users', [
            'users' => User::all()
        ])->layout('layouts.app'); 
    }
}
