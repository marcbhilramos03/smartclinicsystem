<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\ArchivedInventory;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    // Inventory Report



    public function inventoryReport(Request $request)
    {
        // Parse month/year from input or default to current
        $monthYear = $request->input('month', Carbon::now()->format('Y-m'));
        [$year, $month] = explode('-', $monthYear);

        // Active inventory filtered by creation month/year
        $inventory = Inventory::whereMonth('created_at', $month)
                              ->whereYear('created_at', $year)
                              ->get();

        // Archived inventory filtered by archived_date month/year
        $archived = ArchivedInventory::whereMonth('archived_date', $month)
                                     ->whereYear('archived_date', $year)
                                     ->get();

        return view('admin.reports.inventory', compact('inventory', 'archived', 'month', 'year'));
    }

    // Checkups Report
    public function checkupsReport()
    {
        $checkups = MedicalRecord::with('patient')->get();
        return view('admin.reports.checkups', compact('checkups'));
    }

    // Patients Report
   public function patientReport()
{
    // Get only users with role 'patient'
    $patients = \App\Models\User::where('role', 'patient')->get();
    $totalPatients = $patients->count();

    return view('admin.reports.patients', compact('patients', 'totalPatients'));
}
}
