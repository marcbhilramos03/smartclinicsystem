<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkup;

class StaffCheckupController extends Controller
{
    public function index()
    {
        $checkups = Checkup::where('staff_id', auth()->user()->user_id)
                            ->with(['patient', 'vitals', 'dental'])
                            ->paginate(10);
        return view('staff.checkups.index', compact('checkups'));
    }

    public function show(Checkup $checkup)
    {
        return view('staff.checkups.show', compact('checkup'));
    }

    public function update(Request $request, Checkup $checkup)
    {
        // Dynamically validate based on type
        $rules = [];
        if ($checkup->checkup_type === 'vitals') {
            $rules = [
                'vitals.height' => 'required|numeric',
                'vitals.weight' => 'required|numeric',
                'vitals.blood_pressure' => 'required|string',
                'vitals.pulse_rate' => 'required|string',
                'vitals.temperature' => 'required|numeric',
            ];
        } elseif ($checkup->checkup_type === 'dental') {
            $rules = [
                'dental.status' => 'required|string',
                'dental.notes' => 'nullable|string',
            ];
        }

        $validated = $request->validate($rules);

        // Save
        if ($checkup->checkup_type === 'vitals') {
            $checkup->vitals()->updateOrCreate([], $validated['vitals']);
        } elseif ($checkup->checkup_type === 'dental') {
            $checkup->dental()->updateOrCreate([], $validated['dental']);
        }

        return redirect()->route('staff.checkups.index')->with('success', 'Checkup updated successfully.');
    }
}
