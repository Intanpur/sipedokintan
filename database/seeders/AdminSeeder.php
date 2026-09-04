<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@sipedok.test'],
            [
                'name'      => 'Administrator',
                'password'  => bcrypt('admin123'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        $admin->assignRole('admin');
    }
}