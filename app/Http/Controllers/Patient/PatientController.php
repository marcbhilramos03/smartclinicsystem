<?php

namespace App\Http\Controllers\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
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
