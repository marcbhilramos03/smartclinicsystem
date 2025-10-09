<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    // Show admin/staff login
    public function showLoginForm()
    {
        return view('auth.admin-login'); // email + password login
    }

    // Show patient login
    public function showPatientLoginForm()
    {
        return view('auth.patient-login'); // school_id login
    }

    // Admin/staff login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Ensure user is admin or staff
        $user = User::where('email', $credentials['email'])
                    ->whereIn('role', ['admin', 'staff'])
                    ->first();

        if ($user && Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login_error' => 'The provided credentials are incorrect',
        ]);
    }

 public function patientLogin(Request $request)
{
    $request->validate([
        'school_id' => [
            'required',
            'string',
            'regex:/^C\d{2}-\d{4}$/',
        ],
    ], [
        'school_id.regex' => 'The School ID must be in the format C00-0000.',
    ]);

    $schoolId = trim($request->school_id);

    $user = User::where('role', 'patient') // or 'patient' depending on your DB
        ->whereHas('personalInformation', function ($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })
        ->first();

    if ($user) {
        Auth::login($user);
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'login_error' => 'School ID not found or invalid.',
    ])->withInput();
}


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
