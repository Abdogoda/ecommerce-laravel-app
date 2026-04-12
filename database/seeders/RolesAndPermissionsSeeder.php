<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Enums\PermissionEnum;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Define Permissions ─────────────────────────────
        $permissions = PermissionEnum::getAllPermissions();
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ── Roles ───────────────────────────────────────────
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // ── Assign Permissions to Roles ─────────────────────
        $adminRole->syncPermissions($permissions);
    }
}