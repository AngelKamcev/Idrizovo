<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogDescriptions;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(
        private ActivityLogService $activityLog,
    ) {}

    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin() || $user->isVospituvac()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isReviewer()) {
                return redirect()->route('admin.reviewer-dashboard');
            }
            return redirect()->route('index');
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

            if ($user->isAdmin() || $user->isVospituvac() || $user->isReviewer()) {
                $this->activityLog->logStaffAction(
                    user: $user,
                    request: $request,
                    description: ActivityLogDescriptions::forStaffRequest($request, 'login'),
                );
            }

            if ($user->isAdmin() || $user->isVospituvac()) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->isReviewer()) {
                return redirect()->intended(route('admin.reviewer-dashboard'));
            }

            return redirect()->intended(route('index'));
        }

        return back()->withErrors(['email' => 'Неуспешна најава. Проверете ја вашата е-пошта и лозинка.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && ($user->isAdmin() || $user->isVospituvac() || $user->isReviewer())) {
            $this->activityLog->logStaffAction(
                user: $user,
                request: $request,
                description: ActivityLogDescriptions::forStaffRequest($request, 'logout'),
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
