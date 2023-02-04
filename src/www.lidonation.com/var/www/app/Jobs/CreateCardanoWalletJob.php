<?php

namespace App\Jobs;

use App\Models\wallet;
use App\Services\CreateCardanoWalletService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class CreateCardanoWalletJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $name, protected $passPhrase)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //generate mnemonicPhrase
        $request = Request::create('api/generate-mnemonic-phrase', 'GET');
        $response = Route::dispatch($request);
        $mnemonicPhrase = json_decode($response->getContent(), true);

        // generate wallet
        $genWallet = new CreateCardanoWalletService($this->name, $mnemonicPhrase, $this->passPhrase);

        //store wallet in db
        $newWallet = new Wallet;
        $newWallet->user_id = 1;
        $newWallet->context = $genWallet->name;
        $newWallet->wallet_id = $genWallet->walletId;
        $newWallet->address = $genWallet->walletAddr;
        $newWallet->passphrase = implode(' ', $genWallet->recoveryPhrase);
        $newWallet->spending_password = $genWallet->passPhrase;

        Log::info($newWallet->wallet_id);
        $newWallet->save();
    }
}
