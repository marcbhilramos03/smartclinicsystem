<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call your main UserSeeder
        $this->call(UserSeeder::class);

        // Add a test user
        User::factory()->create([
            'first_name' => 'Test',
            'middle_name' => null,
            'last_name' => 'User',
            'role' => 'admin', // choose 'admin', 'staff', or 'patient/student'
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
