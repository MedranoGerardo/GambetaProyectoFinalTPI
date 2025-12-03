<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de inicio de sesión
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Procesa el inicio de sesión
     */
    public function login(Request $request)
    {
        // Validación de campos
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Verificar si el correo existe
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'El correo no está registrado.']);
        }

        // Intentar iniciar sesión
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['password' => 'La contraseña es incorrecta.']);
        }

        // Redirección según rol
        if ($user->role === 'admin') {
            return redirect('/admin');
        }

        if ($user->role === 'recepcionista') {
            return redirect('/admin/reservas');
        }

        // Rol desconocido
        return redirect('/');
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}