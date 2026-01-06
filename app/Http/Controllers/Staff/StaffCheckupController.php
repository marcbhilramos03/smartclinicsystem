<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkup;
use Illuminate\Support\Facades\Auth;

class StaffCheckupController extends Controller
{
    
    public function index()
    {
        $checkups = Checkup::where('staff_id', Auth::user()->user_id)
            ->with('patients.personalInformation')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('staff.checkups.index', compact('checkups'));
    }

  
public function students($checkupId)
{
    
    $checkup = \App\Models\Checkup::with('patients.personalInformation')
                ->findOrFail($checkupId);

  
    return view('staff.checkups.students', compact('checkup'));
}
public function show($checkupId)
{
    
    $checkup = Checkup::with(['patients.personalInformation', 'staff'])
                      ->findOrFail($checkupId);

    return view('staff.checkups.show', compact('checkup'));
}



}
