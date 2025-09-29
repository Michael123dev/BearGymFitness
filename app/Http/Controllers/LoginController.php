<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index()
    {
        return view('mms.login');
    }

    public function login(Request $request)
    {
        $attributes = $request->validate([
            'phone'     => 'required|string',
            'password'  => 'required',
        ]);

        $remember_me = $request->has('remember');

        if (Auth::attempt(['phone' => $attributes['phone'], 'password' => $attributes['password']], $remember_me)) 
        {
            return redirect()->route('dashboard.index');
        }

        return back()->withInput()->with('error', 'Nomor HP / password yang Anda masukkan salah');
    }
}
