<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ── Permissions ──────────────────────────────────────
        $permissions = [
            'view users', 'create users', 'edit users', 'delete users', 'assign roles', 'activate users', 'deactivate users',
            'view products', 'create products', 'edit products', 'delete products',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view orders', 'edit orders', 'delete orders',
            'view messages', 'reply messages', 'delete messages',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ── Roles ───────────────────────────────────────────
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

        // ── Assign Permissions to Roles ─────────────────────
        $superAdminRole->syncPermissions(Permission::all());
    }
}