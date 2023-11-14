<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UserController extends Controller implements UpdatesUserProfileInformation
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'nullable|bail|required_unless:catalyst_explorer,null|email',
            'password' => 'nullable|bail|required_with:email|min:5',
            'catalyst_explorer' => 'sometimes|required_without_all:email,password|min:13',
            'key' => 'sometimes|required_without_all:email,password|min:13',
            'signature' => 'sometimes|required_without_all:email,password|min:13',
        ]);

        if (isset($request->stake_address)) {
            $user = User::where('wallet_stake_address', $request->stake_address)->first();

            if ((bool) $user) {
                Auth::login($user, $remember = true);

                return redirect()->route('catalyst-explorer.myDashboard');
            } else {
                return response()->json([
                    'message' => 'Could not find an account with those credentials',
                ], 401);
            }
        }

        $remember = $request->input('remember', false);

        if (Auth::attempt($credentials, $remember)) {
            if (isset($request->baseURL)) {
                return redirect($request->baseURL);
            }

            return to_route('catalyst-explorer.myDashboard');
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        $redirectUrl = url()->previous();
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect($redirectUrl);
    }

    public function create(Request $request)
    {
        $validated = new Fluent($request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]));

        $user = User::where('email', $validated->email);

        if (! $user instanceof User) {
            $user = new User;
            $user->name = $validated->name;
            $user->email = $validated->email;
            $user->password = Hash::make($validated->password);
            $user->save();

            return to_route('catalyst-explorer.login');
        }
    }

    public function update(Request $request)
    {
        $validated = new Fluent($request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|min:3',
            'email' => 'required|email',
            'twitter' => 'nullable|bail|min:2',
            'linkedin' => 'nullable|bail|min:2',
            'discord' => 'nullable|bail|min:2',
            'telegram' => 'nullable|bail|min:2',
            'bio' => 'nullable|min:10',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]));

        // prevent changing email to a different user's email
        $user = User::findOrFail($validated->id);
        $user->name = $validated->name;
        $user->bio = $validated->bio;
        $user->email = $validated->email;
        $user->twitter = $validated->twitter;
        $user->linkedin = $validated->linkedin;
        $user->discord = $validated->discord;
        $user->telegram = $validated->telegram;
        if ($request->profile) {
            if (isset($user->profile_photo_url)) {
                $user->updateProfilePhoto($request->profile);
            } else {
                $user->addMediaFromRequest('profile')->toMediaCollection('hero');
                $user->save();
            }
        }

        $user->save();

        return to_route('catalyst-explorer.myProfiles');
    }

    public function utilityLogin()
    {
        // ->with([
        //     'nft' => $topicNft,
        // ])
        return Inertia::modal('Auth/UtilityLogin')
            ->baseUrl(
                previous_route_url()
            );
    }
}
