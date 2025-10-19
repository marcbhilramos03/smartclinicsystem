<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmergencyContact;
use Illuminate\Support\Facades\DB;
use App\Models\PersonalInformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    /**
     * Display a listing of users.
     */
    public function index()
    {
        $patients = User::where('role', 'patient')->paginate(10, ['*'], 'patients_page');
        $staff = User::where('role', '!=', 'patient')->paginate(10, ['*'], 'staff_page');

        return view('admin.users.index', compact('patients', 'staff'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        DB::transaction(function() use ($request) {

            if ($request->role === 'patient') {
                $validated = $request->validate([
                    'first_name'         => 'required|string|max:255',
                    'middle_name'        => 'nullable|string|max:255',
                    'last_name'          => 'required|string|max:255',
                    'school_id'          => 'required|string|unique:personal_information,school_id',
                    'gender'             => 'nullable|string|max:50',
                    'birthdate'          => 'nullable|date',
                    'contact_number'     => 'nullable|string|max:20',
                    'address'            => 'nullable|string|max:255',
                    'course'             => 'nullable|string|max:255',
                    'grade_level'        => 'nullable|string|max:255',
                    'emergency_name'     => 'nullable|string|max:255',
                    'emergency_relation' => 'nullable|string|max:255',
                    'emergency_phone'    => 'nullable|string|max:20',
                    'emergency_address'  => 'nullable|string|max:255',
                ]);

                $user = User::create([
                    'first_name'  => ucwords(trim($validated['first_name'])),
                    'middle_name' => isset($validated['middle_name']) ? ucwords(trim($validated['middle_name'])) : null,
                    'last_name'   => ucwords(trim($validated['last_name'])),
                    'role'        => 'patient',
                    'email'       => null,
                    'password'    => Hash::make('password123'),
                ]);

                $personalInfo = $user->personalInformation()->create([
                    'school_id'      => $validated['school_id'],
                    'gender'         => $validated['gender'] ?? null,
                    'birthdate'      => $validated['birthdate'] ?? null,
                    'contact_number' => $validated['contact_number'] ?? null,
                    'address'        => $validated['address'] ?? null,
                ]);

                // Save course information
                $personalInfo->courseInformation()->create([
                    'course'      => $validated['course'] ?? null,
                    'grade_level' => $validated['grade_level'] ?? null,
                ]);

                // Save emergency contact
                if ($request->filled('emergency_name') || $request->filled('emergency_phone') || $request->filled('emergency_relation')) {
                    $personalInfo->emergencyContacts()->create([
                        'name'         => ucwords(trim($request->emergency_name)),
                        'relationship' => ucwords(trim($request->emergency_relation ?? '')),
                        'phone_number' => $request->emergency_phone ?? null,
                        'address'      => $request->emergency_address ?? null,
                    ]);
                }

            } else {
                $validated = $request->validate([
                    'first_name'     => 'required|string|max:255',
                    'last_name'      => 'required|string|max:255',
                    'middle_name'    => 'nullable|string|max:255',
                    'email'          => 'required|string|email|max:255|unique:users',
                    'password'       => 'required|string|min:8|confirmed',
                    'role'           => 'required|string|in:admin,staff',
                    'profession'     => 'nullable|string|max:255',
                    'license_type'   => 'nullable|string|max:255',
                    'specialization' => 'nullable|string|max:255',
                ]);

                User::create([
                    'first_name'     => ucwords(trim($validated['first_name'])),
                    'last_name'      => ucwords(trim($validated['last_name'])),
                    'email'          => strtolower(trim($validated['email'])),
                    'password'       => Hash::make($validated['password']),
                    'role'           => $validated['role'],
                    'profession'     => ucwords(trim($validated['profession'] ?? '')),
                    'license_type'   => $validated['license_type'] ?? null,
                    'specialization' => ucwords(trim($validated['specialization'] ?? '')),
                ]);
            }

        });

        return redirect()->route('admin.users.index')
                         ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        DB::transaction(function() use ($request, $user) {

            if ($user->role === 'patient') {
                $validated = $request->validate([
                    'first_name'         => 'required|string|max:255',
                    'middle_name'        => 'nullable|string|max:255',
                    'last_name'          => 'required|string|max:255',
                    'school_id'          => 'required|string',
                    'contact_number'     => 'nullable|string|max:20',
                    'address'            => 'nullable|string|max:255',
                    'course'             => 'nullable|string|max:255',
                    'grade_level'        => 'nullable|string|max:255',
                    'emergency_name'     => 'nullable|string|max:255',
                    'emergency_relation' => 'nullable|string|max:255',
                    'emergency_phone'    => 'nullable|string|max:20',
                    'emergency_address'  => 'nullable|string|max:255',
                ]);

                // Update user basic info
                $user->update([
                    'first_name'  => ucwords(trim($validated['first_name'])),
                    'middle_name' => isset($validated['middle_name']) ? ucwords(trim($validated['middle_name'])) : null,
                    'last_name'   => ucwords(trim($validated['last_name'])),
                ]);

                $personalInfo = $user->personalInformation;
                if ($personalInfo) {
                    $personalInfo->update([
                        'school_id'      => $validated['school_id'],
                        'contact_number' => $validated['contact_number'] ?? null,
                        'address'        => $validated['address'] ?? null,
                    ]);

                    // Update or create course info
                    $personalInfo->courseInformation()->updateOrCreate(
                        ['personal_information_id' => $personalInfo->id],
                        [
                            'course'      => $validated['course'] ?? null,
                            'grade_level' => $validated['grade_level'] ?? null,
                        ]
                    );

                    // Update or create emergency contact
                    $personalInfo->emergencyContacts()->updateOrCreate(
                        ['personal_information_id' => $personalInfo->id],
                        [
                            'name'         => ucwords(trim($request->emergency_name ?? '')),
                            'relationship' => ucwords(trim($request->emergency_relation ?? '')),
                            'phone_number' => $request->emergency_phone ?? null,
                            'address'      => $request->emergency_address ?? null,
                        ]
                    );
                }

            } else {
                $validated = $request->validate([
                    'first_name'     => 'required|string|max:255',
                    'last_name'      => 'required|string|max:255',
                    'email'          => 'required|string|email|max:255|unique:users,email,' . $user->id,
                    'profession'     => 'nullable|string|max:255',
                    'license_type'   => 'nullable|string|max:255',
                    'specialization' => 'nullable|string|max:255',
                ]);

                $user->update([
                    'first_name'     => ucwords(trim($validated['first_name'])),
                    'middle_name'    => null,   
                    'last_name'      => ucwords(trim($validated['last_name'])),
                    'email'          => strtolower(trim($validated['email'])),
                    'profession'     => ucwords(trim($validated['profession'] ?? '')),
                    'license_type'   => $validated['license_type'] ?? null,
                    'specialization' => ucwords(trim($validated['specialization'] ?? '')),
                ]);
            }

        });

        return redirect()->route('admin.users.index')
                         ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('personalInformation'); 
        return view('admin.users.show', compact('user'));
    }
}
