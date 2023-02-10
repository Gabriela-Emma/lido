<?php
namespace App\Http\Controllers\Api\CatalystExplorer;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\ProjectCatalyst\CatalystProjectsController;


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
}
