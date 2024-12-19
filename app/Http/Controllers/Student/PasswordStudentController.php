<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordStudentController extends Controller
{
    public function changePassword(Request $request)
    {
        $student = auth()->guard('student')->user();

        // Check if the user is authenticated
        if (!$student) {
            return redirect()->back()->withErrors(['error' => 'User not authenticated']);
        }

        // Validate the request
        $request->validate([
            'password' => 'required|min:8',
        ]);

        // Update the password and plain_password fields
        $student->password = bcrypt($request->password);
        $student->plain_password = $request->password;
        $student->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Password changed successfully');
    }
}
