<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PersonalInformation;
use App\Models\CourseInformation;
use App\Models\EmergencyContact;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PatientImportController extends Controller
{
    // Show import form
    public function showImportForm()
    {
        return view('admin.users.import');
    }

    // Handle file import
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        $filePath = $request->file('file')->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $added = 0;
        $updated = 0;
        $skipped = 0;

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                // Skip header
                if ($index === 0 && strtolower($row[0]) === 'school_id') continue;

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

                // Validate key fields
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

                    // Create personal info
                    $personalInfo = PersonalInformation::create([
                        'user_id' => $user->user_id,
                        'school_id' => $data['school_id'],
                        'gender' => $data['gender'],
                        'birthdate' => $data['birthdate'],
                        'contact_number' => $data['contact_number'],
                        'address' => $data['address'],
                    ]);

                    // ✅ Create course info (for academic details)
                    CourseInformation::create([
                        'personal_information_id' => $personalInfo->id,
                        'course' => $data['course'],
                        'grade_level' => $data['grade_level'],
                        'school_year' => $data['school_year'],
                    ]);

                    // ✅ Create emergency contact
                    EmergencyContact::create([
                        'personal_information_id' => $personalInfo->id,
                        'name' => $data['emergency_name'],
                        'relationship' => $data['emergency_relationship'],
                        'phone_number' => $data['emergency_phone'],
                        'address' => $data['emergency_address'],
                    ]);

                    $added++;
                } else {
                    // Update existing user data
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
                        ]);

                        // Update or create course info
                        CourseInformation::updateOrCreate(
                            ['personal_information_id' => $personalInfo->id],
                            [
                                'course' => $data['course'],//department
                                'grade_level' => $data['grade_level'],//e.g, BSIT-1
                            ]
                        );

                        // Update or create emergency contact
                        EmergencyContact::updateOrCreate(
                            ['personal_information_id' => $personalInfo->id],
                            [
                                'name' => $data['emergency_name'],
                                'relationship' => $data['emergency_relationship'],
                                'phone_number' => $data['emergency_phone'],
                                'address' => $data['emergency_address'],
                            ]
                        );

                        $updated++;
                    }
                }
            }

            DB::commit();
            return back()->with('success', "✅ Import complete! Added: $added | Updated: $updated | Skipped: $skipped");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
