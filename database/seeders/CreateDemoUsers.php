<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateDemoUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Create Regular User
        User::updateOrCreate(
            ['username' => 'user'],
            [
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );

        $this->command->info('Demo users created successfully!');
        $this->command->info('Admin: username=admin, password=admin123');
        $this->command->info('User: username=user, password=user123');
    }
}
