<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login',[
            'judul' => 'Login'
        ]);
    }

    public function auth(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email Wajib Di Isi',
                'password.required' => 'Password Wajib Di Isi',
            ],
        );

        $logininfo = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($logininfo)) {
            if (Auth::user()->role == 'admin') {
                return redirect()
                    ->route('admin.index')
                    ->with('status', Auth::user()->nama)->with('status', Auth::user()->nama);
            } elseif (Auth::user()->role == 'customer') {
                return redirect()
                    ->route('index')
                    ->with('status', Auth::user()->nama);
            }
        } else {
            return redirect()->route('login')->with('error','Data Yang Di Masukan Tidak Sesuai');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('index')->with('logout', 'Berhasil logout');
    }

    public function unlogin(){
        return view('unlogin');
    }
}
