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
        $this->call([
            RolesAndPermissionsSeeder::class
        ]);

        // Create a Admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin Account', 'password' => bcrypt('admin'), 'email_verified_at' => now()]
        );
        $superAdmin->assignRole('Admin');
        $this->command->info('  Admin user created with email: admin@gmail.com');
    }
}