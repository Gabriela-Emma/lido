<?php

namespace App\Http\Controllers\Invokable;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CreateUserController extends Controller
{
    public function __invoke(Request $request): ?Authenticatable
    {
        $$validated = $request->validate([
            'name' => 'nullable|min:3',
            'email' => 'nullable|email|unique:users',
            'password' => 'nullable|min:5',
            'stake_address' => 'bail|required|min:13',
            'wallet_address' => 'nullable|min:13',
            'assets' => 'nullable',
        ]);

        $user = User::where('email', $request->email)
            ->orWhere('wallet_stake_address', $request->stake_address)->first();

        if (! $user instanceof User) {
            $user = new User;

            $user->name = $request->name ?? null;
            $user->email = $request->email ?? substr($request->stake_address, -4).'@anonymous.com';
            $user->password = Hash::make($request->password) ?? null;
            $user->wallet_stake_address = $request->stake_address;
            $user->wallet_address = $request->wallet_address ?? null;
            $user->assets = $request->assets ?? null;

            if (isset($user->wallet_stake_address)) {
                $user->assignRole((string) RoleEnum::partner());
                $user->save();
                Auth::login($user);
            } else {
                $user->assignRole((string) RoleEnum::delegator());
                $user->save();
                Auth::login($user, $remember = true);
            }
        }

        return auth()->user;
    }
}
