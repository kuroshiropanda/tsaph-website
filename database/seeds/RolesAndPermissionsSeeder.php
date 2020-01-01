<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'invite applicants']);
        Permission::create(['name' => 'approve applicants']);
        Permission::create(['name' => 'deny applicants']);
        Permission::create(['name' => 'edit roles']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'super admin'])
            ->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'leader'])
            ->givePermissionTo(['invite applicants', 'approve applicants', 'deny applicants']);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['approve applicants', 'deny applicants']);
    }
}
