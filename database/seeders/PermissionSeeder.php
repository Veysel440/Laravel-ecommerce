<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder {
    public function run(): void {
        $perms = [
            'catalog.view','catalog.manage',
            'orders.view','orders.manage',
            'coupons.view','coupons.manage',
            'users.view','users.manage',
            'reviews.moderate'
        ];
        foreach ($perms as $p) { Permission::findOrCreate($p,'web'); }
        $admin = Role::findOrCreate('admin','web');
        $customer = Role::findOrCreate('customer','web');
        $admin->syncPermissions($perms);

        $user = \App\Models\User::firstOrCreate(
            ['email'=>'admin@ecommerce.local'],
            ['name'=>'Admin','password'=>bcrypt('Admin!234'),'role'=>'admin']
        );
        $user->assignRole('admin');
    }
}
