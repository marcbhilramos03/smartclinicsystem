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

        $courses = PersonalInformation::select('course', DB::raw('COUNT(*) as total_students'))
            ->whereNotNull('course')          
            ->groupBy('course')
            ->orderBy('course')
            ->get();

        return view('admin.users.index', compact('patients', 'staff', 'courses'));
    }

    public function create()
    {
        
        return view('admin.users.create');
    }

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

          
                $first_name = ucwords(trim($validated['first_name']));
                $middle_name = $validated['middle_name'] ? ucwords(trim($validated['middle_name'])) : null;
                $last_name = ucwords(trim($validated['last_name']));
                $gender = !empty($validated['gender']) ? ucfirst(strtolower($validated['gender'])) : null;

                $user = User::create([
                    'first_name'    => $first_name,
                    'middle_name'   => $middle_name,
                    'last_name'     => $last_name,
                    'role'          => 'patient',
                    'email'         => null,
                    'password'      => Hash::make('password123'),
                    'gender'        => $gender,
                    'date_of_birth' => $validated['date_of_birth'] ?? null,
                    'phone_number'  => $validated['phone_number'] ?? null,
                    'address'       => $validated['address'] ?? null,
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

                $first_name = ucwords(trim($validated['first_name']));
                $middle_name = $validated['middle_name'] ? ucwords(trim($validated['middle_name'])) : null;
                $last_name = ucwords(trim($validated['last_name']));
                $gender = !empty($validated['gender']) ? ucfirst(strtolower($validated['gender'])) : null;

                $user = User::create([
                    'first_name'    => $first_name,
                    'middle_name'   => $middle_name,
                    'last_name'     => $last_name,
                    'email'         => strtolower(trim($validated['email'])),
                    'password'      => Hash::make($validated['password']),
                    'role'          => $validated['role'],
                    'gender'        => $gender,
                    'date_of_birth' => $validated['date_of_birth'] ?? null,
                    'phone_number'  => $validated['phone_number'] ?? null,
                    'address'       => $validated['address'] ?? null,
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

    public function show(User $user)
    {
        $user->load(['personalInformation', 'credential']);
        return view('admin.users.show', compact('user'));
    }

    public function edit($user_id)
    {
        $user = User::with(['personalInformation', 'credential'])->findOrFail($user_id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $validated = $request->validate([
            'first_name'     => 'required|string|max:255',
            'middle_name'    => 'nullable|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'nullable|email|unique:users,email,' . $user_id . ',user_id',
            'gender'         => 'nullable|string|max:50',
            'date_of_birth'  => 'nullable|date',
            'address'        => 'nullable|string|max:255',
            'phone_number'   => 'nullable|string|max:20',
        ]);

        $validated['first_name'] = ucwords(trim($validated['first_name']));
        $validated['middle_name'] = $validated['middle_name'] ? ucwords(trim($validated['middle_name'])) : null;
        $validated['last_name'] = ucwords(trim($validated['last_name']));
        if (!empty($validated['gender'])) {
            $validated['gender'] = ucfirst(strtolower($validated['gender']));
        }

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
                    'profession' => ucwords(trim($request->input('profession') ?? '')),
                    'license_type' => $request->input('license_type'),
                    'specialization' => ucwords(trim($request->input('specialization') ?? '')),
                ]
            );
        }

        return redirect()->route('admin.users.index')->with('success', 'Updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Deleted successfully.');
    }

    public function patientsByCourse($course)
    {
        $patients = User::where('role', 'patient')
            ->whereHas('personalInformation', function ($query) use ($course) {
                $query->where('course', $course);
            })
            ->with('personalInformation')
            ->orderBy('last_name')
            ->get();

        return view('admin.users.by_course', compact('patients', 'course'));
    }
}
