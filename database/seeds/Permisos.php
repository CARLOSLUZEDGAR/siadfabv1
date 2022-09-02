<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class Permisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        // app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // Permission::create(['mod_cod' => 1,'name' => 'payament']);
        // Permission::create(['mod_cod' => 1,'name' => 'payament box']);
        // Permission::create(['mod_cod' => 1,'name' => 'brand']);
        // Permission::create(['mod_cod' => 1,'name' => 'edit brand']);
        // Permission::create(['name' => 'active brand']);
        // Permission::create(['name' => 'category']);
        // Permission::create(['name' => 'create category']);
        // Permission::create(['name' => 'edit category']);

        // $per1->assignRole($role);
    }
}
