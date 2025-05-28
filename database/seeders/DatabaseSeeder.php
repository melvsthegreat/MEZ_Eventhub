<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create some test clients
        \App\Models\User::factory(5)->create([
            'role' => 'client',
        ]);

        // Create some test transactions
        \App\Models\User::where('role', 'client')->each(function ($user) {
            \App\Models\Transaction::factory(3)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
