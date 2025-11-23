<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'Administrator with full access',
        ]);

        $clientRole = Role::create([
            'name' => 'client',
            'description' => 'Regular client/user',
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@audiovisualizer.com',
            'password' => Hash::make('admin'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $admin->roles()->attach($adminRole->id);

        $client2 = User::create([
            'name' => 'Javier',
            'email' => 'javierbarcelosantos@gmail.com',
            'password' => Hash::make('12345678'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $client2->roles()->attach($clientRole->id);

        $this->command->info('✅ Seeding completed successfully!');
        $this->command->info('📧 Admin: admin@audiovisualizer.com / admin');
        $this->command->info('📧 Client: javierbarcelosantos@gmail.com / 12345678');
    }
}
