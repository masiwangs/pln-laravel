<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // create permission
        Permission::create(['name' => 'edit prk']);
        Permission::create(['name' => 'edit skki']);
        Permission::create(['name' => 'edit pengadaan']);
        Permission::create(['name' => 'edit kontrak']);
        Permission::create(['name' => 'edit pelaksanaan']);
        Permission::create(['name' => 'edit pembayaran']);

        // create super admin
        Role::create(['name' => 'super admin']);
    }
}
