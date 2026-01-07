<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\User;

class LoginController extends Controller
{
 
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }


    public function showPatientLoginForm()
    {
        return view('auth.patient-login'); 
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])
                    ->whereIn('role', ['admin', 'staff'])
                    ->first();

        if ($user && Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login_error' => 'The provided credentials are incorrect or unauthorized.',
        ])->withInput();
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

        $user = User::where('role', 'patient')
            ->whereHas('personalInformation', function ($query) use ($schoolId) {
                $query->where('school_id', $schoolId);
            })
            ->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login_error' => 'School ID not found or invalid.',
        ])->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }
}
