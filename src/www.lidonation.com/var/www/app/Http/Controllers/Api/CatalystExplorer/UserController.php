<?php
namespace App\Http\Controllers\Api\CatalystExplorer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable;


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
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = User::where('email', $request->email);

        if (!$user instanceof User) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            ;
            return redirect('/catalyst-explorer/login');
        }
    }
}
