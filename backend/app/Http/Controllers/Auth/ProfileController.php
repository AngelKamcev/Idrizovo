<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('auth.account');
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $user->id],
        ];

        if ($request->filled('password')) {
            $rules['current_password'] = ['required', 'string'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $data = $request->validate($rules);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if ($request->filled('password')) {
            if (!Hash::check($data['current_password'], $user->password_hash)) {
                return back()->withErrors(['current_password' => 'Погодете ја тековната лозинка правилно.']);
            }

            $user->password_hash = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('status', 'Вашите податоци се зачувани.');
    }
}
