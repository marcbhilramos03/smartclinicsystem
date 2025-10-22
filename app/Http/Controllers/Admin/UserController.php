<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PersonalInformation;
use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use \Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    /**
     * Display a listing of patients and staff.
     */
    public function index(Request $request)
    {
        $perPage = 10;

        $patients = User::with('personalInformation')
            ->where('role', 'patient')
            ->orderBy('last_name')
            ->paginate($perPage, ['*'], 'patients_page');

        $staff = User::with('credential')
            ->where('role', 'staff')
            ->orderBy('last_name')
            ->paginate($perPage, ['*'], 'staff_page');

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
        DB::transaction(function () use ($request) {

            if ($request->role === 'patient') {
                $validated = $request->validate([
                    'first_name'        => 'required|string|max:255',
                    'middle_name'       => 'nullable|string|max:255',
                    'last_name'         => 'required|string|max:255',
                    'gender'            => 'nullable|string|max:50',
                    'date_of_birth'     => 'nullable|date',
                    'phone_number'      => 'nullable|string|max:20',
                    'address'           => 'nullable|string|max:255',
                    'school_id'         => 'required|string|unique:personal_information,school_id',
                    'course'            => 'nullable|string|max:255',
                    'grade_level'       => 'required|string|max:255',
                    'emer_con_name'     => 'nullable|string|max:255',
                    'emer_con_rel'      => 'nullable|string|max:255',
                    'emer_con_phone'    => 'nullable|string|max:20',
                    'emer_con_address'  => 'nullable|string|max:255',
                ]);

                $user = User::create([
                    'first_name'     => ucwords(trim($validated['first_name'])),
                    'middle_name'    => $validated['middle_name'] ?? null,
                    'last_name'      => ucwords(trim($validated['last_name'])),
                    'role'           => 'patient',
                    'email'          => null,
                    'password'       => Hash::make('password123'),
                    'gender'         => $validated['gender'] ?? null,
                    'date_of_birth'  => $validated['date_of_birth'] ?? null,
                    'phone_number'   => $validated['phone_number'] ?? null,
                    'address'        => $validated['address'] ?? null,
                ]);

                PersonalInformation::create([
                    'user_id'          => $user->user_id,
                    'school_id'        => $validated['school_id'],
                    'course'           => $validated['course'] ?? null,
                    'grade_level'      => $validated['grade_level'],
                    'emer_con_name'    => $validated['emer_con_name'] ?? null,
                    'emer_con_rel'     => $validated['emer_con_rel'] ?? null,
                    'emer_con_phone'   => $validated['emer_con_phone'] ?? null,
                    'emer_con_address' => $validated['emer_con_address'] ?? null,
                ]);
            } else {
                $validated = $request->validate([
                    'first_name'     => 'required|string|max:255',
                    'middle_name'    => 'nullable|string|max:255',
                    'last_name'      => 'required|string|max:255',
                    'email'          => 'required|string|email|max:255|unique:users,email',
                    'password'       => 'required|string|min:8|confirmed',
                    'role'           => 'required|string|in:admin,staff',
                    'profession'     => 'nullable|string|max:255',
                    'license_type'   => 'nullable|string|max:255',
                    'specialization' => 'nullable|string|max:255',
                    'gender'         => 'nullable|string|max:50',
                    'date_of_birth'  => 'nullable|date',
                    'phone_number'   => 'nullable|string|max:20',
                    'address'        => 'nullable|string|max:255',
                ]);

                $user = User::create([
                    'first_name'  => ucwords(trim($validated['first_name'])),
                    'middle_name' => $validated['middle_name'] ?? null,
                    'last_name'   => ucwords(trim($validated['last_name'])),
                    'email'       => strtolower(trim($validated['email'])),
                    'password'    => Hash::make($validated['password']),
                    'role'        => $validated['role'],
                    'gender'      => $validated['gender'] ?? null,
                    'date_of_birth'  => $validated['date_of_birth'] ?? null,
                    'phone_number'   => $validated['phone_number'] ?? null,
                    'address'        => $validated['address'] ?? null,
                ]);

                Credential::create([
                    'staff_id'        => $user->user_id,
                    'profession'     => ucwords(trim($validated['profession'] ?? '')),
                    'license_type'   => $validated['license_type'] ?? null,
                    'specialization' => ucwords(trim($validated['specialization'] ?? '')),
                ]);
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['personalInformation', 'credential']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($user_id)
    {
        $user = User::with(['personalInformation', 'credential'])->findOrFail($user_id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email|unique:users,email,' . $user_id . ',user_id',
            'gender' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string',
        ]);

        $user->update($validated);

        if ($user->role === 'patient') {
            PersonalInformation::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'school_id' => $request->input('school_id'),
                    'course' => $request->input('course'),
                    'grade_level' => $request->input('grade_level'),
                    'emer_con_name' => $request->input('emer_con_name'),
                    'emer_con_rel' => $request->input('emer_con_rel'),
                    'emer_con_phone' => $request->input('emer_con_phone'),
                    'emer_con_address' => $request->input('emer_con_address'),
                ]
            );
        } else {
            Credential::updateOrCreate(
                ['staff_id' => $user->user_id],
                [
                    'profession' => $request->input('profession'),
                    'license_type' => $request->input('license_type'),
                    'specialization' => $request->input('specialization'),
                ]
            );
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
