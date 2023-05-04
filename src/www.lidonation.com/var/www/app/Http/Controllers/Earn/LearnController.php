<?php

namespace App\Http\Controllers\Earn;

use App\DataTransferObjects\LearnerData;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Fluent;
use Inertia\Inertia;
use Inertia\Response;
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
            ],
        ]);
    }

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

                return $user;
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

            return back()->withInput();
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $user = auth()?->user() ?? User::where('email', $request->input('email'))->first();

        if ($user instanceof User) {
            $user->locale = app()->getLocale();
            $this->updateUser($request, $user);

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
            'wallet_address' => 'nullable',
            'wallet_stake_address' => 'nullable',
            'twitter' => 'nullable|handle',
            'telegram' => 'nullable|handle',

        ]));

        $user = new User;
        $user->name = $validated->name;
        $user->email = $validated->email;
        $user->password = Hash::make($validated->password);
        $user->wallet_address = $validated->wallet_address;
        $user->wallet_stake_address = $validated->wallet_stake_address;
        $user->twitter = $validated->twitter;
        $user->telegram = $validated->telegram;
        $user->save();

        $this->assignLearnerRole($user);
    }

    protected function updateUser($request, $user): void
    {
        $validated = new Fluent($request->validate([
            'name' => 'nullable|bail|min:3',
            'email' => 'required|email',
            'wallet_address' => 'nullable',
            'wallet_stake_address' => 'nullable',
            'twitter' => 'nullable|bail|handle',
            'telegram' => 'nullable|bail|handle',

        ]));

        $user->name = $user->name ?? $validated->name;
        $user->email = $user->email ?? $validated->email;
        $user->wallet_address = $validated->wallet_address ?? $user->wallet_address;
        $user->wallet_stake_address = $validated->wallet_stake_address ?? $user->wallet_stake_address;
        $user->twitter = $validated->twitter ?? $user->twitter;
        $user->telegram = $validated->telegram ?? $user->telegram;
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
                'model_id' => $user->id,
            ]);
    }

    public function learnerData(Request $request)
    {
        return LearnerData::from($request->user()
            ->setAppends([
                'next_lesson',
                'next_lesson_at',
                'total_reward_sum',
                'available_rewards'
            ])->toArray());
    }
}
