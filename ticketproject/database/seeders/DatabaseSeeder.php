<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Rolleri oluştur
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $agentRole = Role::firstOrCreate(['name' => 'agent']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        // Admin kullanıcı oluştur
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );
        $admin->assignRole($adminRole);

        // Agent kullanıcı
        $agent = User::firstOrCreate(
            ['email' => 'agent@example.com'],
            ['name' => 'Agent User', 'password' => bcrypt('password')]
        );
        $agent->assignRole($agentRole);

        // Normal user
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'Normal User', 'password' => bcrypt('password')]
        );
        $user->assignRole($userRole);
    }
}
