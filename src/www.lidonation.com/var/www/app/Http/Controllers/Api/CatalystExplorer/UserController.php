<?php

namespace App\Http\Controllers\Api\CatalystExplorer;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use App\Models\User as modelUser;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $credentials = $request->only(['email', 'password']);
        $remember = $request->input('remember', false);

        if (Auth::attempt($credentials, $remember)) {
            return to_route('catalystExplorer.myDashboard');
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

            return to_route('catalystExplorer.login');
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
        if ($request->hasFile('profile')) {
            $appUser = modelUser::findOrFail($validated->id);
            $appUser->addMediaFromRequest('profile')->toMediaCollection('hero');
            $appUser->save();
        }

        $user->save();

        return to_route('catalystExplorer.myProfiles');
    }

    public function utilityLogin()
    {   
        $previousUrl = url()->previous(); 
        $previousRouteName = app('router')->getRoutes()->match(app('request')->create($previousUrl))->getName();
        return Inertia::modal('Auth/UtilityLogin')->baseRoute($previousRouteName);
    }

}
