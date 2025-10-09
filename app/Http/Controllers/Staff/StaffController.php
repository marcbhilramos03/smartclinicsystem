<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:staff']);
    }

    // Staff profile page
    public function profile()
    {
        $user = auth()->user();
        return view('staff.profile', compact('user'));
    }
}
