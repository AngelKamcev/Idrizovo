<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = $request->user();
        $isAdmin = $currentUser?->isAdmin();

        $users = $isAdmin
            ? User::with('role')->orderBy('first_name')->orderBy('last_name')->get()
            : collect();

        return view('admin.settings', [
            'currentUser' => $currentUser,
            'isAdmin' => $isAdmin,
            'users' => $users,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password_hash = Hash::make($validated['password']);
        $user->save();

        return redirect()
            ->route('admin.settings')
            ->with('success', 'Лозинката е успешно променета.');
    }

    public function storeUser(Request $request)
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'role_name' => ['required', Rule::in(['reviewer', 'vospituvac'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $role = Role::where('name', $validated['role_name'])->firstOrFail();

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role_id' => $role->id,
            'password_hash' => Hash::make($validated['password']),
            'language_preference' => 'mk',
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.settings')
            ->with('success', 'Новиот корисник е додаден.');
    }
}
