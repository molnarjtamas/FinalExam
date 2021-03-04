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
        $role2 = Role::create(['name' => 'moderator']);
        $role3 = Role::create(['name' => 'user']);
        $permission1 = Permission::create(['name' => 'invite-users']);
        $permission2 = Permission::create(['name' => 'view-users']);
        $role1->givePermissionTo([$permission1,$permission2]);
        $user->assignRole('admin');
    }
}
