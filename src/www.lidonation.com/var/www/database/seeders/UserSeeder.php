<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Database\Factories\Traits\UnsplashProvider;

class UserSeeder extends Seeder
{
    use UnsplashProvider;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory([
            'name' => 'Jarvis',
            'email' => 'hello@lidonation.com',
            'password' => Hash::make('TeLO8T2xjM48Rox'),
        ])->hasAttached(Role::where('name', RoleEnum::super_admin())->first())
            ->create();
        User::factory(15)->create()->each(
            function ($po) {
                $po->addMediaFromUrl($this->getRandomImageLink(2048, 2048))->toMediaCollection('hero');
            }
        );
    }
}
