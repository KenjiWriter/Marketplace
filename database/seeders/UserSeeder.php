<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin account
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'balance' => 1000.00,
            'profile_status' => 1,
            'accessible_rooms' => json_encode([]),
            'last_seen' => now()
        ]);

        // Create regular user accounts
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'balance' => rand(50, 500),
                'profile_status' => rand(0, 1),
                'accessible_rooms' => json_encode([]),
                'last_seen' => now()
            ]);
        }
    }
}