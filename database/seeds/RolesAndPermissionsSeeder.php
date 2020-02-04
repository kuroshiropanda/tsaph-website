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
        Permission::create(['name' => 'ads']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'invite applicants']);
        Permission::create(['name' => 'update applicants']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'super admin'])
            ->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'ads'])
        ->givePermissionTo(['ads']);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['invite applicants', 'update applicants']);

        $role = Role::create(['name' => 'moderator'])
            ->givePermissionTo(['update applicants']);
    }
}
