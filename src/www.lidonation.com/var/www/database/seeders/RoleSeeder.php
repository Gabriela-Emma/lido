<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(RoleEnum::toValues())->each(function ($role) {
            Role::create(['name' => $role])->each(fn (Role $role) => $role->givePermissionTo(Permission::inRandomOrder()->first())
            );
        });
    }
}
