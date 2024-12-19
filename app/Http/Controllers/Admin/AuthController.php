<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->input('email'))->first();
        if ($admin) {
            if (Hash::check($request->input('password'), $admin->password)) {
                // Log the admin in
                Auth::guard('admin')->login($admin);
                return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully.');
            } else {
                return redirect()->back()->withErrors(['password' => 'The provided Password is incorrect.']);
            }
        }

        return redirect()->back()->withErrors(['email' => 'The provided Email is incorrect.']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
