<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    public function index() {
        return view('masuk');
    }
    public function daftar() {
        return view('daftar');
    }
    public function login(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $infologin = [
            'email'=>$request->email,
            'password'=>$request->password
        ];

        if(Auth::attempt($infologin)){
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin');
            } else {
                return redirect()->route('user');
            }
        } else {
            return redirect()->route('login')->withErrors('Email atau password salah')->withInput();
        }
    }

    public function register(Request $request) {

    $request->validate([
        'nama' => 'required',
        'username' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
    ]);

    User::create([
        'name' => $request->nama,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'pembeli',
        'image' => 'default.png', // atau bisa dikosongkan
    ]);

    return redirect()->route('login')->with('success', 'Pendaftaran berhasil!');
    }

    public function logout(){
        Auth::logout();
        return redirect('masuk');
    }

}
