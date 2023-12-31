<?php

namespace App\Http\Controllers\Earn;

use App\DataTransferObjects\LearnerData;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
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
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

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
                if ($user->primary_account === null) {
                    Auth::login($user, $remember = true);

                    return $user;
                } else {
                    return redirect()->back()->withErrors([
                        'duplicate' => 'Duplicate account found. Please contact support.',
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'Could not find an account with those credentials',
                ], 401);
            }
        }

        $remember = $request->input('remember', false);
        $user = User::where('email', $request->email)->first();

        if ($user && $user->primary_account === null && Auth::attempt($credentials, $remember)) {
            if (isset($request->baseURL)) {
                return redirect($request->baseURL);
            }

            return back()->withInput();
        } elseif ($user && $user->primary_account !== null) {
            return redirect()->back()->withErrors([
                'duplicate' => 'Duplicate account found. Please contact support.',
            ]);
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {

        if (config('app.slte.registration_open') === false) {
            return redirect()->back()->withErrors([
                'message' => 'Registration closed, please contact support.',
            ]);
        }

        $user = auth()?->user() ?? User::where('email', $request->input('email'))->first();

        if ($user instanceof User) {
            $user->lang = app()->getLocale();
            $this->updateUser($request, $user);

            return back()->withInput();
        }

        $this->saveNewUser($request);

        return to_route('verification.notice');
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
        $this->guard->login($user);
        event(new Registered($user));
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
                'available_rewards',
                'completed_topics',
            ])->toArray());
    }

    public function waitList(Request $request)
    {
        $user = auth()?->user() ?? User::where('email', $request->email)->first();

        if ($user instanceof User) {
            return $this->waitListUser($request, $user);
        }

        return $this->waitListNewUser($request);
    }

    protected function waitListUser(Request $request, $user)
    {
        $user->email_verified_at = now();
        $user->save();
        $user->saveMeta('slte_waitlist', 1, $user, true);

        return 'Added to wait list';
    }

    protected function waitListNewUser(Request $request)
    {
        $validated = new Fluent($request->validate([
            'name' => 'required|nullable|bail|min:3',
            'email' => 'required|email',
        ]));
        $user = new User;
        $user->name = $validated->name;
        $user->email = $validated->email;
        $user->password = Hash::make(Str::random(10));
        $user->email_verified_at = now();
        $user->save();
        $user->saveMeta('slte_waitlist', 1, $user, true);
        $this->sendResetLinkEmail($request);

        return 'Added to wait list';
    }

    protected function sendResetLinkEmail($request)
    {
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response;
    }

    protected function broker()
    {
        return Password::broker();
    }
}
