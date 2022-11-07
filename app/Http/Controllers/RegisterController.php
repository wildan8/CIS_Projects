<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('Register.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ID_Karyawan' => 'required|numeric|unique:users,ID_Karyawan',
            'Nama_Karyawan' => 'required|regex: /^[a-zA-Z ]*$/|max:255|unique:users,Nama_Karyawan',
            'Bagian_Karyawan' => 'required',
            'password' => 'required|min:5|max:255',
        ]);
        // dd($validatedData);
        $validatedData['password'] = bcrypt($validatedData['password']);
        User::create($validatedData);
        $request->session()->flash('status', 'Pendaftaran Berhasil');
        return redirect('/Login');

    }
}
