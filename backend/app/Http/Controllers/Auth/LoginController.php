<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return redirect()->route($user->isAdmin() || $user->isVospituvac() ? 'admin.dashboard' : 'index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Вашата сметка е деактивирана.']);
            }

            $user->last_login = now();
            $user->save();

            return redirect()->intended($user->isAdmin() || $user->isVospituvac() ? route('admin.dashboard') : route('index'));
        }

        return back()->withErrors(['email' => 'Неуспешна најава. Проверете ја вашата е-пошта и лозинка.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
