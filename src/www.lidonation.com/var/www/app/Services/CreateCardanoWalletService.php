<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class CreateCardanoWalletService
{
    
    public $walletId;
    public $walletAddr;

    // protected $walletName, protected $mnemonicWords, protected $passPhrase
    public function __construct(public $name, public $recoveryPhrase, public $passPhrase) {
        $this->createWallet();
    }


    /**
     * @throws RequestException
     */
    public function createWallet()
    {
        $url = static::getWalletServiceUrl('wallets');

        $response = Http::post($url, [
            'name' => $this->name,
            'mnemonic_sentence' => $this->recoveryPhrase,
            'passphrase' => $this->passPhrase,
        ]);

        if ($response->successful()) {
            $this->walletId = $response['id'] ?? null;
            $this->walletAddr = $this->getWalletAddress($this->walletId);

            return $response->object();
        }

        return throw $response->toException();
    }

    protected function getWalletAddress($walletId)
    {
        $url = static::getWalletServiceUrl('wallets/'.$walletId.'/addresses?state=unused');

        $response = Http::get($url);

        if ($response->successful()) {
            return $response->object()[0]->id;
        }

        return throw $response->toException();
    }

    public function getWalletServiceUrl($append = ''): string
    {
        $base = config('services.cardano-wallet.host').':'.config('services.cardano-wallet.port').'/v2';
        $append = trim($append, '/');

        return "{$base}/{$append}";
    }

    protected static function processCommand(array|string $command, $fromShell = false): Process
    {
        if ($fromShell) {
            if (is_array($command)) {
                $command = implode(' ', $command);
            }

            return ['data'=>Process::fromShellCommandline($command)];
        }

        return new Process($command);
    }
}