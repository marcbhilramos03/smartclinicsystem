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
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Admin',
                'middle_name' => 'A',
                'last_name' => 'User',
                'role' => 'admin',
                'password' => Hash::make('password'),
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
}
}
