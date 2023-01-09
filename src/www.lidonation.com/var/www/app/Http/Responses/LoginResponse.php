<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param    $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $home = auth()->user()->is_admin ? '/portal' : '/phuffycoin';

        return redirect()->intended($home);
    }
}
