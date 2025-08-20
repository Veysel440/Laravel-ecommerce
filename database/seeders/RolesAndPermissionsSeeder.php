<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission,Role};

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $guard = config('permissions.guard','web');

        foreach (config('permissions.permissions',[]) as $perm) {
            Permission::firstOrCreate(['name'=>$perm,'guard_name'=>$guard]);
        }

        foreach (config('permissions.roles',[]) as $roleName => $perms) {
            $role = Role::firstOrCreate(['name'=>$roleName,'guard_name'=>$guard]);

            if ($perms === ['*']) {
                $role->syncPermissions(Permission::pluck('name')->all());
            } else {
                $role->syncPermissions($perms);
            }
        }
    }
}
