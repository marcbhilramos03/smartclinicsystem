<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PersonalInformation;
use App\Models\MedicalHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PatientImportController extends Controller
{
    // Show the import form
    // Show the patient import form
    public function showPatientImportForm()
    {
        return view('imports.import_patient'); // updated path
    }
   // Show medical history import form
    public function showMedicalHistoryImportForm()
    {
        return view('imports.import_medical_history'); // updated path
    }

    // Import patients/students
    public function importPatients(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        $filePath = $request->file('file')->getRealPath();

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $added = 0;
            $updated = 0;
            $skipped = 0;

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                // Skip header row if present
                if ($index === 0 && strtolower(trim($row[0])) === 'school_id') continue;

                $data = [
                    'school_id' => $row[0] ?? null,
                    'first_name' => $row[1] ?? null,
                    'middle_name' => $row[2] ?? null,
                    'last_name' => $row[3] ?? null,
                    'gender' => $row[4] ?? null,
                    'birthdate' => $row[5] ?? null,
                    'contact_number' => $row[6] ?? null,
                    'address' => $row[7] ?? null,
                    'course' => $row[8] ?? null,
                    'grade_level' => $row[9] ?? null,
                    'school_year' => $row[10] ?? null,
                    'emergency_name' => $row[11] ?? null,
                    'emergency_relationship' => $row[12] ?? null,
                    'emergency_phone' => $row[13] ?? null,
                    'emergency_address' => $row[14] ?? null,
                ];

                // Validate essential fields
                $validator = Validator::make($data, [
                    'school_id' => 'required',
                    'first_name' => 'required',
                    'last_name' => 'required',
                ]);

                if ($validator->fails()) {
                    $skipped++;
                    continue;
                }

                // Check if user already exists
                $user = User::whereHas('personalInformation', function ($q) use ($data) {
                    $q->where('school_id', $data['school_id']);
                })->first();

                if (!$user) {
                    // Create new user
                    $user = User::create([
                        'first_name' => $data['first_name'],
                        'middle_name' => $data['middle_name'],
                        'last_name' => $data['last_name'],
                        'role' => 'patient',
                    ]);

                    // Create personal information
                    PersonalInformation::create([
                        'user_id' => $user->user_id,
                        'school_id' => $data['school_id'],
                        'gender' => $data['gender'],
                        'birthdate' => $data['birthdate'],
                        'contact_number' => $data['contact_number'],
                        'address' => $data['address'],
                        'course' => $data['course'],
                        'grade_level' => $data['grade_level'],
                        'emer_con_name' => $data['emergency_name'],
                        'emer_con_rel' => $data['emergency_relationship'],
                        'emer_con_phone' => $data['emergency_phone'],
                        'emer_con_address' => $data['emergency_address'],
                    ]);

                    $added++;
                } else {
                    // Update existing user
                    $user->update([
                        'first_name' => $data['first_name'],
                        'middle_name' => $data['middle_name'],
                        'last_name' => $data['last_name'],
                    ]);

                    $personalInfo = $user->personalInformation;
                    if ($personalInfo) {
                        $personalInfo->update([
                            'gender' => $data['gender'],
                            'birthdate' => $data['birthdate'],
                            'contact_number' => $data['contact_number'],
                            'address' => $data['address'],
                            'course' => $data['course'],
                            'grade_level' => $data['grade_level'],
                            'emer_con_name' => $data['emergency_name'],
                            'emer_con_rel' => $data['emergency_relationship'],
                            'emer_con_phone' => $data['emergency_phone'],
                            'emer_con_address' => $data['emergency_address'],
                        ]);
                    }

                    $updated++;
                }
            }

            DB::commit();
            return back()->with('success', "✅ Patient Import Complete! Added: $added | Updated: $updated | Skipped: $skipped");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    // Import medical history
    public function importMedicalHistory(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        $filePath = $request->file('file')->getRealPath();

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $added = 0;
            $skipped = 0;
            $duplicates = 0;

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                if ($index === 0 && strtolower(trim($row[0])) === 'school_id') continue;

                $data = [
                    'school_id' => $row[0] ?? null,
                    'history_type' => $row[1] ?? null,
                    'description' => $row[2] ?? null,
                    'date_recorded' => $row[3] ?? null,
                    'notes' => $row[4] ?? null,
                ];

                $validator = Validator::make($data, [
                    'school_id' => 'required',
                    'history_type' => 'required',
                ]);

                if ($validator->fails()) {
                    $skipped++;
                    continue;
                }

                $user = User::whereHas('personalInformation', function ($q) use ($data) {
                    $q->where('school_id', $data['school_id']);
                })->first();

                if (!$user) {
                    $skipped++;
                    continue;
                }

                $dateRecorded = $data['date_recorded'] ?: now()->format('Y-m-d');

                $existing = MedicalHistory::where('user_id', $user->user_id)
                    ->where('history_type', $data['history_type'])
                    ->whereDate('date_recorded', $dateRecorded)
                    ->first();

                if ($existing) {
                    if ($existing->description !== $data['description'] || $existing->notes !== $data['notes']) {
                        $existing->update([
                            'description' => $data['description'],
                            'notes' => $data['notes'],
                        ]);
                    }
                    $duplicates++;
                    continue;
                }

                MedicalHistory::create([
                    'user_id' => $user->user_id,
                    'admin_id' => auth()->id() ?? null,
                    'history_type' => $data['history_type'],
                    'description' => $data['description'],
                    'date_recorded' => $dateRecorded,
                    'notes' => $data['notes'],
                ]);

                $added++;
            }

            DB::commit();
            return back()->with('success', "✅ Medical History Import Complete! Added: $added | Updated: $duplicates | Skipped: $skipped");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
