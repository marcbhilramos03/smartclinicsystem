<?php

namespace App\Http\Controllers\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Constructor to add auth & role middleware (optional if already applied in routes)
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'role:admin']);
    // }

    // Admin profile page
  public function profile()
{
    $user = auth()->user();
    $personalInfo = $user->personalInformation;

    return view('patient.profile', compact('user', 'personalInfo'));
}
public function dashboard()
{
    $user = auth()->user();
    return view('patient.dashboard', compact('user'));
}

}
