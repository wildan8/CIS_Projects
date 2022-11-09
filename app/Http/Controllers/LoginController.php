<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('Login.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'ID_Karyawan' => 'required|numeric',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/' . auth()->user()->Bagian_Karyawan);
        }
        return back()->with('LoginError', 'Proses Login Gagal!');
        // dd('Login Berhasil');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/Login');
    }
}
