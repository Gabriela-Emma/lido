<?php

namespace App\Http\Controllers\Earn;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Fluent;
use Spatie\Permission\Models\Role;

class LearnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Learn')->with([
            'crumbs' => [
                ['name' => 'Learn & Earn', 'link' => route('earn.learn')],
            ]
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $credentials = $request->only(['email', 'password']);
        $remember = $request->input('remember', false);

        if (Auth::attempt($credentials, $remember)) {

            return to_route('earn.learn');
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $user = auth()?->user() ?? User::where('email', $request->input('email'))->first();

        if ($user instanceof User) {
            $this->updateUser($request);
            return back()->withInput();
        }

        $this->saveNewUser($request);
        return to_route('earn.learn.login');
    }

    protected function saveNewUser($request): void
    {
        $validated = new Fluent($request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
            'wallet_address' => 'required|wallet_address',
            'twitter' => 'nullable|handle',
            'telegram' => 'nullable|handle'

        ]));

        $user = new User;
        $user->name = $validated->name;
        $user->email = $validated->email;
        $user->password = Hash::make($validated->password);
        $user->wallet_address = $validated->wallet_address;
        $user->twitter = $validated->twitter;
        $user->telegram = $validated->telegram;
        $user->save();

        $this->assignLearnerRole($user);
    }

    protected function updateUser($request): void
    {
        $validated = new Fluent($request->validate([
            'name' => 'nullable|bail|min:3',
            'email' => 'required|email',
            'wallet_address' => 'nullable',
            'wallet_stake_address' => 'nullable',
            'twitter' => 'nullable|bail|handle',
            'telegram' => 'nullable|bail|handle'

        ]));

        $user = auth()->user();

        $user->name = $user->name ?? $validated->name;
        $user->email = $user->email ?? $validated->email;
        $user->wallet_address = $validated->wallet_address ?? $user->wallet_address;
        $user->wallet_stake_address = $validated->wallet_stake_address ?? $user->wallet_stake_address;
        $user->twitter = $validated->twitter ?? $user->twitter;
        $user->telegram = $validated->telegram  ?? $user->telegram;
        $user->save();

        $this->assignLearnerRole($user);
    }

    protected function assignLearnerRole($user): void
    {
        $role = Role::where('name', 'learner')->first();
        DB::table('model_has_roles')
            ->insert([
                'role_id' => $role->id,
                'model_type' => 'App\Models\User',
                'model_id' => $user->id
            ]);
    }
}
