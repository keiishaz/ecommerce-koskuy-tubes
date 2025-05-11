<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index() {
        return view('masuk');
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

    public function logout(){
        Auth::logout();
        return redirect('masuk');
    }

}
