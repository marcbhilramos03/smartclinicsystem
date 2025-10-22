<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PersonalInformation;
use App\Models\Credential;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ADMIN =====
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Admin',
                'middle_name' => 'A',
                'last_name' => 'User',
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'gender' => 'Male',
                'date_of_birth' => '2010-01-01',
                'phone_number' => '09123456789',
                'address' => '123 Street, City',                
            ]
        );

        Credential::updateOrCreate(
            ['staff_id' => $admin->user_id],
            [
                'profession' => 'Doctor',
                'license_type' => 'MD',
                'specialization' => 'General',
            ]
        );

        // ===== STAFF (Doctor) =====
        $staff1 = User::updateOrCreate(
            ['email' => 'staff1@example.com'],
            [
                'first_name' => 'Dr.',
                'middle_name' => 'B',
                'last_name' => 'Smith',
                'role' => 'staff',
                'password' => Hash::make('password123'),
                 'gender' => 'Male',
                'date_of_birth' => '2010-01-01',
                'phone_number' => '09123456789',
                'address' => '123 Street, City',
            ]
        );

        Credential::updateOrCreate(
            ['staff_id' => $staff1->user_id],
            [
                'profession' => 'Doctor',
                'license_type' => 'MD',
                'specialization' => 'Pediatrics',
            ]
        );

        // ===== STAFF (Nurse) =====
        $staff2 = User::updateOrCreate(
            ['email' => 'staff2@example.com'],
            [
                'first_name' => 'Nurse',
                'middle_name' => 'C',
                'last_name' => 'Johnson',
                'role' => 'staff',
                'password' => Hash::make('password123'),
            ]
        );

        Credential::updateOrCreate(
            ['staff_id' => $staff2->user_id],
            [
                'profession' => 'Nurse',
                'license_type' => 'RN',
                'specialization' => 'General',
            ]
        );

        // ===== PATIENTS =====
        $patients = [
            [
                'first_name' => 'John',
                'middle_name' => null,
                'last_name' => 'Doe',
                'gender' => 'Male',
                'date_of_birth' => '2010-01-01',
                'phone_number' => '09123456789',
                'address' => '123 Street, City',
                'school_id' => 'C00-0001',
                'course' => 'BS Information Technology',
                'grade_level' => '1st Year',
                'emer_con_name' => 'Parent Doe',
                'emer_con_rel' => 'Father',
                'emer_con_phone' => '09987654321',
                'emer_con_address' => '123 Street, City',
            ],
            [
                'first_name' => 'Jane',
                'middle_name' => null,
                'last_name' => 'Smith',
                'gender' => 'Female',
                'date_of_birth' => '2010-06-15',
                'phone_number' => '09981234567',
                'address' => '456 Street, City',
                'school_id' => 'C00-0002',
                'course' => 'BS Computer Science',
                'grade_level' => '2nd Year',
                'emer_con_name' => 'Parent Smith',
                'emer_con_rel' => 'Mother',
                'emer_con_phone' => '09988776655',
                'emer_con_address' => '456 Street, City',
            ],
            [
                'first_name' => 'Alice',
                'middle_name' => null,
                'last_name' => 'Brown',
                'gender' => 'Female',
                'date_of_birth' => '2009-11-10',
                'phone_number' => '09199887766',
                'address' => '789 Street, City',
                'school_id' => 'C00-0003',
                'course' => 'BS Nursing',
                'grade_level' => '3rd Year',
                'emer_con_name' => 'Parent Brown',
                'emer_con_rel' => 'Father',
                'emer_con_phone' => '09111222333',
                'emer_con_address' => '789 Street, City',
            ],
        ];

        foreach ($patients as $p) {
            $user = User::updateOrCreate(
                [
                    'first_name' => $p['first_name'],
                    'last_name' => $p['last_name'],
                    'role' => 'patient',
                ],
                [
                    'middle_name' => $p['middle_name'],
                    'email' => null,
                    'password' => Hash::make('password123'),
                    'gender' => $p['gender'],
                    'date_of_birth' => $p['date_of_birth'],
                    'phone_number' => $p['phone_number'],
                    'address' => $p['address'],
                ]
            );

            PersonalInformation::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'school_id' => $p['school_id'],
                    'course' => $p['course'],
                    'grade_level' => $p['grade_level'],
                    'emer_con_name' => $p['emer_con_name'],
                    'emer_con_rel' => $p['emer_con_rel'],
                    'emer_con_phone' => $p['emer_con_phone'],
                    'emer_con_address' => $p['emer_con_address'],
                ]
            );
        }
    }
}
