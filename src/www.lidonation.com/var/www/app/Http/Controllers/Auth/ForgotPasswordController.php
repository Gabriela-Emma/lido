<?php

namespace App\Http\Controllers\Auth;

// use Illuminate\Http\Request;
// use DB;
// use Carbon\Carbon;
// use App\Models\User;
// use Mail;
// use Hash;
// use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    //   /**
    //    * Write code on Method
    //    *
    //    * @return response()
    //    */
    //   public function submitForgetPasswordForm(Request $request)
    //   {

    //       $request->validate(['email' => 'required|email']);

    //       $status = Password::sendResetLink(
    //           $request->only('email')
    //       );

    //       session()->flash('success', 'A link has been to ' . $request->get("email"));

    //       return $status === Password::RESET_LINK_SENT
    //                   ? back()->with(['status' => __($status)])
    //                   : back()->withErrors(['email' => __($status)]);
    //   }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        session()->flash('message', 'Password updated was successfully');

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
