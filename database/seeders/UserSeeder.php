<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PersonalInformation;
use App\Models\EmergencyContact;
use App\Models\CourseInformation;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ADMIN =====
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Admin',
                'middle_name' => 'A',
                'last_name' => 'User',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'profession' => 'Doctor',
                'license_type' => 'MD',
            ]
        );

        // ===== STAFF (Doctor) =====
        $staff1 = User::firstOrCreate(
            ['email' => 'staff1@example.com'],
            [
                'first_name' => 'Dr.',
                'middle_name' => 'B',
                'last_name' => 'Smith',
                'role' => 'staff',
                'password' => Hash::make('password'),
                'profession' => 'Doctor',
                'license_type' => 'MD',
            ]
        );

        // ===== STAFF (Nurse) =====
        $staff2 = User::firstOrCreate(
            ['email' => 'staff2@example.com'],
            [
                'first_name' => 'Nurse',
                'middle_name' => 'C',
                'last_name' => 'Johnson',
                'role' => 'staff',
                'password' => Hash::make('password'),
                'profession' => 'Nurse',
                'license_type' => 'RN',
            ]
        );

        // ===== PATIENTS =====
        $patients = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'school_id' => 'C00-0001',
                'course' => 'BS Information Technology',
                'grade_level' => '1st Year',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'school_id' => 'C00-0002',
                'course' => 'BS Computer Science',
                'grade_level' => '2nd Year',
            ],
            [
                'first_name' => 'Alice',
                'last_name' => 'Brown',
                'school_id' => 'C00-0003',
                'course' => 'BS Nursing',
                'grade_level' => '3rd Year',
            ],
        ];

        foreach ($patients as $p) {
            // Create the user record
            $user = User::create([
                'first_name' => $p['first_name'],
                'middle_name' => null,
                'last_name' => $p['last_name'],
                'role' => 'patient',
                'email' => null,
                'password' => Hash::make('password123'),
            ]);

            // Create personal information
            $personalInfo = PersonalInformation::create([
                'user_id' => $user->user_id,
                'school_id' => $p['school_id'],
                'gender' => 'Male',
                'birthdate' => '2010-01-01',
                'contact_number' => '09123456789',
                'address' => '123 Street, City',
            ]);

            // Create course information (new table)
            CourseInformation::create([
                'personal_information_id' => $personalInfo->id,
                'course' => $p['course'],
                'grade_level' => $p['grade_level'],
            ]);

            // Create emergency contact
            EmergencyContact::create([
                'personal_information_id' => $personalInfo->id,
                'name' => 'Parent of ' . $p['first_name'],
                'relationship' => 'Parent',
                'phone_number' => '09987654321',
                'address' => '123 Street, City',
            ]);
        }
    }
}
