<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PersonalInformation;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // -------- Admin --------
        $admin = User::create([
            'first_name' => 'Admin',
            'middle_name' => 'A',
            'last_name' => 'User',
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // default password
            'profession' => 'Doctor',
            'license_type' => 'MD',
        ]);

        // -------- Staff (Doctor) --------
        $staff1 = User::create([
            'first_name' => 'Dr.',
            'middle_name' => 'B',
            'last_name' => 'Smith',
            'role' => 'staff',
            'email' => 'staff1@example.com',
            'password' => Hash::make('password'),
            'profession' => 'Doctor',
            'license_type' => 'MD',
        ]);

        // -------- Staff (Nurse) --------
        $staff2 = User::create([
            'first_name' => 'Nurse',
            'middle_name' => 'C',
            'last_name' => 'Johnson',
            'role' => 'staff',
            'email' => 'staff2@example.com',
            'password' => Hash::make('password'),
            'profession' => 'Nurse',
            'license_type' => 'RN',
        ]);

        // -------- Patients --------
        $patients = [
            ['first_name'=>'John','last_name'=>'Doe','school_id'=>'C00-0001'],
            ['first_name'=>'Jane','last_name'=>'Smith','school_id'=>'C00-0002'],
            ['first_name'=>'Alice','last_name'=>'Brown','school_id'=>'C00-0003'],
        ];

        foreach ($patients as $p) {
            $user = User::create([
                'first_name' => $p['first_name'],
                'middle_name' => null,
                'last_name' => $p['last_name'],
                'role' => 'patient',
                'email' => null,
                'password' => null,
            ]);

            // Personal information
            PersonalInformation::create([
                'user_id' => $user->user_id,
                'school_id' => $p['school_id'],
                'gender' => 'Male',
                'birthdate' => '2010-01-01',
                'contact_number' => '09123456789',
                'address' => '123 Street, City',
            ]);
        }
    }
}
