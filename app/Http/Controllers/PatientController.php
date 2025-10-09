<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;

class PatientController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'role:patient']);
    // }

    // Patient profile page
    public function profile()
    {
        $user = auth()->user();
        return view('patient.profile', compact('user'));
    }
}
