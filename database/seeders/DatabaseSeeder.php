<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'user']);
        $permission1 = Permission::create(['name' => 'invite-users']);
        $permission2 = Permission::create(['name' => 'view-users']);
        $permission3 = Permission::create(['name' => 'view-all-holidays']);
        $permission4 = Permission::create(['name' => 'view-own-holidays']);
        $permission5 = Permission::create(['name' => 'take-holiday']);

        $role1->givePermissionTo([$permission1,$permission2,$permission3]);
        $role2->givePermissionTo([$permission4,$permission5]);

        $user->assignRole('admin');
    }
}
