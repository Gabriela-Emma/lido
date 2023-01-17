<?php

namespace App\Observers;

use App\Invokables\FillPostData;
use App\Models\Wallet;

class WalletObserver
{
    /**
     * Handle the Wallet "created" event.
     *
     * @param  Wallet  $wallet
     * @return void
     */
    public function creating(Wallet $wallet)
    {
        (new FillPostData)($wallet, [], fn () => [
            'ada_balance' => ['ada_balance', 0],
            //            'token_balance' => ['token_balance', 0],
        ]);
    }
}
