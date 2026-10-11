<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = ['Administrator', 'Staff', 'Customer'];

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'Administrator',
            ]
        );

        foreach (range(1, 10) as $index) {
            User::updateOrCreate(
                ['email' => 'sample' . $index . '@example.com'],
                [
                    'name' => 'Sample User ' . $index,
                    'password' => bcrypt('password'),
                    'role' => $roles[$index % count($roles)],
                ]
            );
        }
    }
}
