<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('guru_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $guru = Guru::where('username', $request->username)->first();

        if ($guru && Hash::check($request->password, $guru->password)) {
            session()->put('guru_id', $guru->id);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['username' => 'Username atau Password salah'])->onlyInput('username');
    }

    public function logout()
    {
        session()->forget('guru_id');
        return redirect()->route('login');
    }
}
