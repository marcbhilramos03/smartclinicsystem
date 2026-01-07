<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalInformation;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $search = $request->input('search');

   
    $personalInfo = PersonalInformation::where('school_id', $search)->first();

    if ($personalInfo) {
        
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.patients.show', $personalInfo->user_id);
        } else {
            return redirect()->route('staff.patients.show', $personalInfo->user_id);
        }
    } else {
       
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('showPatientNotFoundModal', true)
                ->with('searchTerm', $search);
        } else {
            return redirect()->route('staff.dashboard')
                ->with('showPatientNotFoundModal', true)
                ->with('searchTerm', $search);
        }
    }
}

}
