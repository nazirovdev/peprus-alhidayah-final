<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authUserLogin()
    {
        return view('auth.authUserLogin');
    }

    public function proccessAuthUserLogin(Request $request)
    {
        if (Auth::guard('web')->attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->with([
            'status' => 'Username atau Password anda salah',
            'error' => true
        ]);
    }

    public function proccessAuthUserLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Student

    public function authStudentLogin()
    {
        return view('auth.authStudentLogin');
    }

    public function proccessAuthStudentLogin(Request $request)
    {
        if (Auth::guard('student')->attempt([
            'nis' => $request->nis,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();

            return redirect('/dashboard/siswa');
        }

        return back()->with([
            'status' => 'NIS atau Password anda salah',
            'error' => true
        ]);
    }

    public function proccessAuthStudentLogout(Request $request)
    {
        Auth::guard('student')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/dashboard/siswa');
    }
}
