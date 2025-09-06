<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Agents
        for ($i = 1; $i <= 3; $i++) {
            $agent = User::create([
                'name' => "Agent $i",
                'email' => "agent$i@example.com",
                'password' => Hash::make('password'),
            ]);
            $agent->assignRole('agent');
        }

        // Normal Users
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('user');
        }
    }
}
