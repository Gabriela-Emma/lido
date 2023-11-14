<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use App\Enums\RoleEnum;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Invokable\CreateUserController;

class AuthenticationForm extends Form
{
    #[Rule('nullable|bail|required_without:stake_address|min:5')]
    public string $password;

    #[Rule('nullable|bail|required_without:stake_address|email')]
    public string $email;

    #[Rule('nullable|min:3')]
    public string $name;

    #[Rule('nullable|bail|min:13')]
    public string $wallet_address;

    #[Rule('sometimes|min:13')]
    public string $stake_address;

    public  $remember = 1;

    public array $walletInfo;

    public function store()
    {
        $this->setWalletInfo();
        $user =  (new CreateUserController)(null,$this->all());
        if ($user instanceof User) {
            return $user;
        }else {
            return response()->json([
                'message' => 'We are having trouble logging you in with provided credentials.',
            ], 401);        }
    }

    public function login()
    {
        
        $this->setWalletInfo();
        $this->validate();
        if ((bool) $this->stake_address) {
            $user = User::where('email', $this->email)
                ->orWhere('wallet_stake_address', $this->stake_address)->first();
            $isPartner = $user?->hasRole(RoleEnum::partner()->value);

            if ((bool) $user && $isPartner) {
                Auth::login($user, $this->remember);
                return $user;
            } else {
                return response()->json([
                    'message' => 'We are having trouble logging you in with your stake address. Try your email and password or try registering again.',
                ], 401);
            }
        }

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            return auth()->user();
        }

        return response()->json([
            'message' => 'We are having trouble logging you in with provided credentials.',
        ], 401);
    }

    public function setWalletInfo() : void
    {
        $this->stake_address = $this->walletInfo['stake_address'];
        $this->wallet_address = $this->walletInfo['wallet_address'];
    }
}
