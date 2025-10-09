<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkup;
use App\Models\User;

class CheckupController extends Controller
{
    public function index()
    {
        $checkups = Checkup::with(['patient', 'staff'])->paginate(10);
        return view('admin.checkups.index', compact('checkups'));
    }

    public function create()
    {
        $students = User::where('role', 'patient')->get();
        $staffs = User::where('role', 'staff')->get();
        return view('admin.checkups.create', compact('students', 'staffs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'staff_id' => 'required|exists:users,user_id',
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'checkup_type' => 'required|string',
        ]);

        Checkup::create($validated);

        return redirect()->route('admin.checkups.index')->with('success', 'Checkup scheduled successfully.');
    }
}
