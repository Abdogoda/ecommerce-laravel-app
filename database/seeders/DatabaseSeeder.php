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

        // Create a Super Admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Super Admin', 'password' => bcrypt('123456789')]
        );
        $superAdmin->assignRole('Super Admin');
        $this->command->info('  Super Admin user created with email: admin@gmail.com');
    }
}