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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PatientImportController extends Controller
{
    public function showPatientImportForm()
    {
        return view('imports.import_patient'); 
    }

    public function showMedicalHistoryImportForm()
    {
        return view('imports.import_medical_history'); 
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
            
                if ($index === 0 && strtolower(trim($row[0])) === 'school_id') continue;

                $data = [
                    'school_id' => $row[0] ?? null,
                    'first_name' => $row[1] ?? null,
                    'middle_name' => $row[2] ?? null,
                    'last_name' => $row[3] ?? null,
                    'gender' => $row[4] ?? null,
                    'date_of_birth' => $row[5] ?? null,
                    'phone_number' => $row[6] ?? null,
                    'address' => $row[7] ?? null,
                    'course' => $row[8] ?? null,
                    'grade_level' => $row[9] ?? null,
                    'school_year' => $row[10] ?? null,
                    'emergency_name' => $row[11] ?? null,
                    'emergency_relationship' => $row[12] ?? null,
                    'emergency_phone' => $row[13] ?? null,
                    'emergency_address' => $row[14] ?? null,
                ];

          
                $validator = Validator::make($data, [
                    'school_id' => 'required',
                    'first_name' => 'required',
                    'last_name' => 'required',
                ]);

                if ($validator->fails()) {
                    $skipped++;
                    continue;
                }

         
                $user = User::whereHas('personalInformation', function ($q) use ($data) {
                    $q->where('school_id', $data['school_id']);
                })->first();

                if (!$user) {
                 
                    $user = User::create([
                        'first_name' => $data['first_name'],
                        'middle_name' => $data['middle_name'],
                        'last_name' => $data['last_name'],
                        'role' => 'patient',
                        'gender' => $data['gender'],
                        'date_of_birth' => $data['date_of_birth'],
                        'phone_number' => $data['phone_number'],
                        'address' => $data['address'],
                    ]);

                
                    PersonalInformation::create([
                        'user_id' => $user->user_id,
                        'school_id' => $data['school_id'],
                        'course' => $data['course'],
                        'grade_level' => $data['grade_level'],
                        'emer_con_name' => $data['emergency_name'],
                        'emer_con_rel' => $data['emergency_relationship'],
                        'emer_con_phone' => $data['emergency_phone'],
                        'emer_con_address' => $data['emergency_address'],
                    ]);

                    $added++;
                } else {
             
                    $user->update([
                        'first_name' => $data['first_name'],
                        'middle_name' => $data['middle_name'],
                        'last_name' => $data['last_name'],
                        'gender' => $data['gender'],
                        'date_of birth' => $data['date_of_birth'],
                        'phone_number' => $data['phone_number'],
                        'address' => $data['address'],
                    ]);

                    $personalInfo = $user->personalInformation;
                    if ($personalInfo) {
                        $personalInfo->update([
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
            return back()->with('success', "✅ Students Import Complete! Added: $added | Updated: $updated | Skipped: $skipped");

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
        // Download patient import template
    public function downloadPatientTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([
            [
                'school_id', 'first_name', 'middle_name', 'last_name', 'gender', 
                'date_of_birth', 'phone_number', 'address', 'course', 'grade_level', 
                'school_year', 'emergency_name', 'emergency_relationship', 'emergency_phone', 'emergency_address'
            ]
        ], NULL, 'A1');

        $writer = new Xlsx($spreadsheet);

        $filename = 'students_import_template.xlsx';

     
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer->save('php://output');
        exit;
    }

    // Download medical history import template
public function downloadMedicalHistoryTemplate()
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();


    $sheet->setCellValue('A1', 'school_id');
    $sheet->setCellValue('B1', 'history_type');
    $sheet->setCellValue('C1', 'description');
    $sheet->setCellValue('D1', 'date_recorded');
    $sheet->setCellValue('E1', 'notes');


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="medical_history_template.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
}
