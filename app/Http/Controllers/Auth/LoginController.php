<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email/Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $loginField = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Try to find user by email or username
        $user = \App\Models\User::where('email', $loginField)
                    ->orWhere('username', $loginField)
                    ->first();

        if ($user && \Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();

            // Redirect based on user role using direct URLs
            $redirectUrl = match($user->role ?? 'anggota') { // Default to anggota if no role
                'admin' => '/dashboard/admin',
                'petugas' => '/dashboard/petugas',
                'anggota' => '/dashboard/anggota',
                default => '/dashboard/anggota' // Default fallback
            };

            return redirect()->intended($redirectUrl);
        }

        throw ValidationException::withMessages([
            'email' => 'Email/Username atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Handle logout request.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}