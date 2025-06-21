<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|unique:user,email',
            'password' => 'required|string|min:6|confirmed',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'role' => 'customer',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login!');
    }
}
