<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index() {
        return view('login');
    }
    function login(Request $request) {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ],[
            'email.required'=>'Email perlu diisi',
            'password.required'=>'Password perlu diisi'
        ]);

        $infologin = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        if (Auth::attempt($infologin)) {
            $user = Auth::user();
            if ($user->role == 'admin' || $user->role == 'pegawai') {
                return redirect('/admin');
            } elseif ($user->role == 'tamu') {
                return redirect('/');
            } else {
                return 'Anda Siapa?';
            }
        }else {
            return redirect('/login')->withErrors('Email dan Password tidak sesuai')->withInput();
        }
    }

    function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
