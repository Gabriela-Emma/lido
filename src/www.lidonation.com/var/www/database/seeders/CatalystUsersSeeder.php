<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

class CatalystUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path().'/json/users-all.json';
        LazyCollection::make(
            json_decode(file_get_contents($path))
        )->map(fn ($user) => ([
            'roles' => collect(explode(',', $user->roles))
                ->filter(fn ($role) => ! Str::contains($role, 'Other'))
                ->map(fn ($role) => trim($role))
                ->filter()
                ->all(),
            'user' => trim(collect(explode('@', trim($user->user)))
                ->first()),
            'bio_pic' => $user->profile_url,
        ]))->each(function ($u, $index) {
            $user = User::where([
                'name' => $u['user'],
            ]);
            if ($user instanceof User) {
                return true;
            }
            try {
                // create role
                $roles = collect($u['roles'])
                    ->map(fn ($role) => Role::findOrCreate(Str::snake($role)));

                // create user
                $user = User::create([
                    'name' => $u['user'],
                    'email' => $index + 1000 .'.email@unclaiamed.com',
                    'password' => Hash::make(Str::random(10)),
                ]);
                $user->syncRoles($roles->pluck('name'));

                // assign bio pic by url
                $user->addMediaFromUrl($u['bio_pic'])
                    ->toMediaCollection('profile');
            } catch (RoleAlreadyExists $e) {
                Log::warning($e->getMessage());
            }
        });
    }
}
