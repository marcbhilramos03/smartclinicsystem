<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $this->call(UserSeeder::class);
        User::factory()->create([
            'first_name' => 'Test',
            'middle_name' => null,
            'last_name' => 'User',
            'role' => 'admin',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'gender' => 'male',
            'birthdate' => '1990-01-01',
            'phone_number' => '1234567890',
            'address' => '123 Test St, Test City',
        
        ]);
    }
}
