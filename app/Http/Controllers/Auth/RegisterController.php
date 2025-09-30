<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['role'] = 'mahasiswa'; // Set role as user (mahasiswa)
            $user = User::create($validated);

            Auth::login($user);

            return redirect()->route('mahasiswa.dashboard')->with('success', 'Registration successful.');
        } catch (\Exception $e) {
            return back()->with(['error' => 'Registration failed. Please try again.']);
        }
    }
}
