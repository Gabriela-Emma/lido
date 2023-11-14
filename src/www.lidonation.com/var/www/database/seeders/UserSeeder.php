<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory([
            'name' => 'Jarvis',
            'email' => 'hello@lidonation.com',
            'password' => Hash::make('TeLO8T2xjM48Rox'),
        ])->hasAttached(Role::where('name', RoleEnum::super_admin())->first())
            ->create();
        User::factory(15)->create();
    }
}
