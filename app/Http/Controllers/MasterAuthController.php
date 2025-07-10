<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterAuthController extends Controller
{
    public function index()
    {
        return view('master.auth.auth');
    }

    public function login(Request $request)
    {
        $data = $request->only([
            'username',
            'password'
        ]);

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($data)) {
            return redirect('/')->with('success', 'Selamat Datang ' . Auth::guard('admin')->user()->name);
        }

        return redirect()->back()->with('error', 'Username atau Password Salah');
    }
}
