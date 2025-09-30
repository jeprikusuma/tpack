<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            
            // Check if user is a mahasiswa (user role)
            if (auth()->user()->role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            }
            if (auth()->user()->role === 'dosen') {
                return redirect()->route('dosen.dashboard');
            }

            // If not a mahasiswa, logout and return with error
            auth()->logout();
            return back()->withErrors([
                'email' => 'You are not authorized to access this system.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
