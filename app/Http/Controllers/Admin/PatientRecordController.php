<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Checkup;
use App\Models\Inventory;
use App\Models\Medication;
use Illuminate\Http\Request;
use App\Models\ClinicSession;
use App\Models\MedicalRecord;
use App\Models\CheckupPatient;
use App\Models\MedicalHistory;
use App\Http\Controllers\Controller;

class PatientRecordController extends Controller
{
    /**
     * List patients with optional search
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $patients = User::where('role', 'patient')
            ->whereHas('personalInformation', function ($q) use ($query) {
                if ($query) {
                    $q->where('school_id', 'like', "%$query%");
                }
            })
            ->paginate(10);

        return view('admin.patients.index', compact('patients', 'query'));
    }

    /**
     * Show full medical record of a patient
     */
   public function show(User $user)
{
    // Load personal info & emergency contacts
    $user->load('personalInformation.emergencyContacts', 'personalInformation.course');

    // Fetch checkups assigned to this student via checkup_patients
    $checkups = CheckupPatient::with([
        'checkup.staff',
        'vitals',
        'dental'
    ])->where('patient_id', $user->user_id)->get();

    // Clinic sessions
    $clinicSessions = $user->clinicSessions()
        ->with('medications.inventory', 'admin')
        ->get();

    // Medical histories
    $medicalHistories = $user->medicalHistories()->get();

    return view('admin.patients.show', compact(
        'user',
        'checkups',
        'clinicSessions',
        'medicalHistories'
    ));
}



    /**
     * Show form to add a new record (clinic session or medical history)
     */
    public function createRecord(User $user)
    {
        return view('admin.patients.create_record', compact('user'));
    }

    /**
     * Store a clinic session or medical history
     */
    public function storeRecord(Request $request, User $user)
    {
        $type = $request->input('record_type');

        if ($type === 'clinic_session') {
            $validated = $request->validate([
                'session_date' => 'required|date',
                'reason'       => 'required|string',
                'remedy'       => 'nullable|string',
                'medications'  => 'nullable|array',
                'medications.*.inventory_id' => 'nullable|exists:inventory,id',
                'medications.*.dosage'       => 'nullable|string',
                'medications.*.duration'     => 'nullable|string',
                'medications.*.quantity'     => 'nullable|integer|min:1',
            ]);

            // Create clinic session
            $session = ClinicSession::create([
                'user_id'      => $user->user_id,
                'admin_id'     => auth()->id(),
                'session_date' => $validated['session_date'],
                'reason'       => $validated['reason'],
                'remedy'       => $validated['remedy'] ?? null,
            ]);

            // Loop through medications array
            if (!empty($validated['medications'])) {
                foreach ($validated['medications'] as $medData) {
                    $med = $session->medications()->create([
                        'session_id'   => $session->id,
                        'inventory_id' => $medData['inventory_id'] ?? null,
                        'dosage'       => $medData['dosage'] ?? null,
                        'duration'     => $medData['duration'] ?? null,
                        'stock_quantity'     => $medData['stock_quantity'] ?? 1,
                    ]);

                    // Deduct from inventory & archive as used
                    if ($med->inventory_id && $med->quantity > 0) {
                        $inventory = Inventory::find($med->inventory_id);
                        if ($inventory && $inventory->stock_quantity >= $med->stock_quantity) {
                            $inventory->stock_quantity -= $med->stock_quantity;
                            $inventory->save();

                            // Archive record
                            $inventory->archives()->create([
                                'quantity' => $med->quantity,
                                'status'   => 'used',
                                'remarks'  => 'Prescribed in clinic session ID: ' . $session->id,
                            ]);
                        }
                    }
                }
            }

            // Link to medical record
            MedicalRecord::create([
                'user_id'           => $user->user_id,
                'clinic_session_id' => $session->id,
            ]);

        } elseif ($type === 'medical_history') {
            $validated = $request->validate([
                'history_type'  => 'required|in:allergy,illness,vaccination',
                'description'   => 'required|string',
                'date_recorded' => 'nullable|date',
            ]);

            $history = MedicalHistory::create([
                'user_id'      => $user->user_id,
                'history_type' => $validated['history_type'],
                'description'  => $validated['description'],
                'date_recorded'=> $validated['date_recorded'] ?? now(),
                'admin_id'     => auth()->id(),
            ]);

            MedicalRecord::create([
                'user_id'             => $user->user_id,
                'medical_history_id'  => $history->id,
            ]);
        }

        return redirect()
            ->route('admin.patients.show', $user)
            ->with('success', 'Record added successfully.');
    }
}
