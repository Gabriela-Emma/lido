<?php
namespace App\Http\Controllers\Api\CatalystExplorer;

use Illuminate\Http\Request;
use App\Http\Controllers\Invokable;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\Invokable\CreateUserController;


class UserController extends Controller
{   

    public function login(Request $request)
    {
        $request->validate([
            'email'=> ['required', 'email'],
            'password'=>['required']
        ]);
        $credentials = $request->only(['email', 'password']);
        $remember = $request->input('remember', false);

        if (Auth::attempt($credentials, $remember)) {
            // $request-session()->regenerate();
            return redirect()->intended('/catalyst-explorer/dashboard');
            
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function create(Request $request)
    {
        $createUserController = new CreateUserController();
        $user = $createUserController($request);

        if ($user instanceof User) {
            return redirect()->route('login')->with(['success' => 'Your account has been created successfully. Please login.']);
        } else {
            return redirect()->back()->withInput()->with(['error' => 'An error occurred while creating your account. Please try again.']);
        };
    }
}
