<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Redireccionar según el rol del usuario
            $user = Auth::user();
            
            // Debug: verificar el usuario
            \Log::info('Usuario logueado:', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $user->status
            ]);
            
            switch ($user->role) {
                case 'super_admin':
                    return redirect()->route('admin.dashboard');
                    
                case 'veterinarian':
                    if ($user->status === 'approved') {
                        return redirect()->route('veterinarian.dashboard');
                    } else {
                        Auth::logout();
                        return back()->withErrors([
                            'email' => 'Tu cuenta está pendiente de aprobación por el administrador.',
                        ]);
                    }
                    
                case 'tutor':
                    return redirect()->route('tutor.dashboard');
                    
                default:
                    return redirect()->route('home');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}