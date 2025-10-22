<?php
namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Checkup;

class PatientCheckupController extends Controller
{
    public function index()
    {
        $checkups = Checkup::whereHas('patients', function ($q) {
            $q->where('user_id', Auth::id());
        })->orderBy('date', 'desc')->paginate(10);

        return view('patient.checkups.index', compact('checkups'));
    }

    public function show($checkupId)
    {
        $checkup = Checkup::with(['staff', 'patients.personalInformation'])
                          ->whereHas('patients', function ($q) {
                              $q->where('user_id', Auth::id());
                          })
                          ->findOrFail($checkupId);

        return view('patient.checkups.show', compact('checkup'));
    }
}
