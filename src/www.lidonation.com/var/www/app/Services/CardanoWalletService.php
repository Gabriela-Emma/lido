<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use App\Services\Traits\DbSyncHelpers;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\Process\Process;
use Whoops\Exception\ErrorException;

class CardanoWalletService
{
    use DbSyncHelpers;

    protected ?string $walletId;

    protected ?User $user;

    protected string $networkArgument;

    public function __construct(
        protected $version = 'v2',
    ) {
        $this->init();
    }

    public function init()
    {
        if (isset($this->user?->id)) {
            return;
        }
        $this->user = Auth::user();
        $this->networkArgument = config('cardano.network-argument');
    }

    public function getAddressUtxos($dir = null, $depositAddress = null): Collection
    {
        if (! $dir) {
            $userId = $this->user?->id;
            $dir = $dir ?? "/data/mint/wallets/users/$userId";
        }
        $depositAddress = $depositAddress ?? ($this->getDepositCliAddress(false, $dir))?->id;

        if (! $depositAddress) {
            return collect([]);
        }

        // get mint wallet utxo for paying fees
        $command = [
            '/opt/cardano-cli',
            'query',
            'utxo',
            '--address',
            $depositAddress,
            $this->networkArgument,
            '--out-file',
            "$dir/deposit.utxos",
        ];

        $process = $this->processCommand($command, true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        return collect(json_decode(file_get_contents("$dir/deposit.utxos")));
    }

    /**
     * @throws ErrorException
     */
    public function getCliDepositBalance($dir = null): ?int
    {
        $utxos = $this->getAddressUtxos($dir);
        $balance = $utxos->sum(fn ($utxo) => $utxo->value->lovelace);

        if ($utxos->isNotEmpty()) {
            $user = Auth::user();
            $user->wallet_validation_seed_tx = explode('#', $utxos->keys()->first())[0];
            $user->wallet_validation_seed_index = explode('#', $utxos->keys()->first())[1];
            $user->wallet_validation_seed_amount = $balance;
            $user->save();
        }

        return $balance ?? 0;
    }

    /**
     * @throws RequestException
     */
    public function isCliDelegator(): ?bool
    {
        // already a delegator
        if ((bool) Auth::user()->wallet_stake_address) {
            return true;
        }

        // get seedTx from received utxo(s)
        $userId = $this->user->id;
        $utoxs = collect(json_decode(file_get_contents("/data/mint/wallets/users/$userId/deposit.utxos")));
        $tx = explode('#', $utoxs->keys()->first())[0];

        $addresses = $this->getUserAddresses($tx);

        if (! $addresses) {
            return null;
        }

        // validate delegation
        $currentPool = $this->getCurrentPool($addresses?->stake_address);
        if (! $currentPool) {
            return null;
        }

        $isADelegator = $currentPool->pool === config('cardano.hash');
        if ($isADelegator) {
            $this->saveStakeAddresses($addresses);
        }

        return $isADelegator;
    }

    /**
     * @throws RequestException
     * @throws ErrorException
     */
    public function hasLidoNft(): ?bool
    {
        if (! $this->user->wallet_address) {
            return false;
        }

        // get all address
        $senderAddresses = $this->getStakeUtxoAddresses($this->user->wallet_stake_address);

        if ($senderAddresses->isEmpty()) {
            $senderAddresses = collect(Auth::user()?->wallet_address);
        }

        // get utxos
        $command = [
            '/opt/cardano-cli',
            'query',
            'utxo',
        ];
        $senderAddresses->each(function ($address) use (&$command) {
            $command[] = '--address';
            $command[] = $address;
        });
        $command[] = config('cardano.network-argument');
        $command[] = '| grep '.config('cardano.mint.policies.lido_delegate');

        $process = $this->processCommand($command, true);
        $process->run();

        if (! $process->isSuccessful()) {
            if (empty($process->getErrorOutput())) {
                return false;
            }
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        return true;
    }

    /**
     * @throws ErrorException
     */
    public function getDepositCliAddress($createWalletIfMissing = true, $baseDir = null): ?Fluent
    {
        $userId = $this->user->id;
        $baseDir = $baseDir ?? "/data/mint/wallets/users/$userId";

        // make sure working dir exists
        $process = $this->processCommand("mkdir -p $baseDir", true);
        $process->run();

        $addy = null;
        if (file_exists("$baseDir/deposit.addr")) {
            $addy = file_get_contents("$baseDir/deposit.addr");

            return $this->parseAddress($addy);
        }

        if (! $createWalletIfMissing) {
            return $addy;
        }

        // get generate keys
        $command = [
            '/opt/cardano-cli',
            'address',
            'key-gen',
            '--verification-key-file',
            "$baseDir/deposit.vkey",
            '--signing-key-file',
            "$baseDir/deposit.skey",
        ];
        $process = $this->processCommand($command, true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        // generate deposit address
        $command = [
            '/opt/cardano-cli',
            'address',
            'build',
            '--payment-verification-key-file',
            "$baseDir/deposit.vkey",
            '--out-file',
            "$baseDir/deposit.addr",
            $this->networkArgument,
        ];
        $process = $this->processCommand($command, true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        return $this->parseAddress(
            file_get_contents("$baseDir/deposit.addr")
        );
    }

    public function makeWalletObject(string|Wallet $addy): ?Fluent
    {
        if ($addy instanceof Wallet) {
            return $this->parseAddress($addy->address);
        }

        return $this->parseAddress($addy);
    }

    /**
     * @throws RequestException
     */
    public function isDelegator(): ?bool
    {
        // already a delegator
        if ((bool) Auth::user()->wallet_stake_address) {
            return true;
        }

        // get user validation wallet
        $this->walletId = $this->getDepositWallet(false)?->id;
        if (! isset($this->walletId)) {
            return null;
        }

        $addresses = $this->getUserAddresses();

        // validate delegation
        $currentPool = $this->getCurrentPool($addresses->stake_address);
        $isADelegator = $currentPool->first()->pool === config('cardano.hash');

        // persist stake address
        if ($isADelegator) {
            $this->saveStakeAddresses($addresses);
        }

        return $isADelegator;
    }

    public function getRefundAmount(): int
    {
        return intval(Auth::user()->wallet_validation_seed_amount) + $this->getSeedTxFee($this->user->wallet_validation_seed_tx);
    }

    /**
     * @throws RequestException
     */
    public function getDepositAddress($createWalletIfMissing = true): ?Fluent
    {
        $this->walletId = $this->getDepositWallet($createWalletIfMissing)?->id;
        if (! isset($this->walletId)) {
            return null;
        }

        $url = static::getWalletServiceUrl("wallets/{$this->walletId}/addresses");
        $response = Http::get($url);
        if ($response->successful()) {
            $addy = new Fluent($response->collect()->first());
            $addy->qr = 'data:image/png;base64, '.static::generateQrCode($addy->id);
            $addy->estimatedFee = $this->estimateFee($addy->id);

            return $addy;
        }

        return throw $response->toException();
    }

    /**
     * @throws RequestException
     */
    public function getDepositWallet($createWalletIfMissing = true): Fluent
    {
        $wallets = Http::get(static::getWalletServiceUrl('wallets'));
        if ($wallets->successful()) {
            $wallet = $wallets->collect()
                ->firstWhere('name', static::generateWalletName());

            return new Fluent($wallet ?? ($createWalletIfMissing ? $this->createDepositWallet() : new \stdClass()));
        }

        return throw $wallets->toException();
    }

    public function generateRecoveryPhrase(): array
    {
        $process = static::processCommand(['/opt/cardano-wallet', 'recovery-phrase', 'generate']);
        $process->run();

        return explode(' ', str_replace(["\r", "\n"], '', $process->getOutput()));
    }

    /**
     * @throws RequestException
     */
    public function createDepositWallet(): object
    {
        $url = static::getWalletServiceUrl('wallets');

        $response = Http::post($url, [
            'name' => static::generateWalletName(),
            'mnemonic_sentence' => $this->generateRecoveryPhrase(),
            'passphrase' => static::generateWalletPassPhrase(),
        ]);

        if ($response->successful()) {
            $this->walletId = $response['id'] ?? null;

            return $response->object();
        }

        return throw $response->toException();
    }

    /**
     * @throws RequestException
     */
    public function getValidationWalletBalance(): ?int
    {
        $wallet = $this->getDepositWallet(false);
        if (! isset($wallet->balance)) {
            return null;
        }
        $this->walletId = $wallet?->id;
        $user = Auth::user();
        if ((bool) $user->wallet_validation_tx) {
            return config('services.cardano-wallet.validation_seed');
        }
        $seedTrans = $this->getSeedTransaction();
        $user->wallet_validation_seed_tx = $seedTrans->id;
        $user->wallet_validation_seed_amount = $wallet->balance['total']['quantity'];
        collect($seedTrans->outputs)->each(function ($utxo, $index) use (&$user) {
            if ($utxo->amount->quantity === config('services.cardano-wallet.validation_seed')) {
                $user->wallet_validation_seed_index = $index;
            }
        });
        $user->save();

        return intval($wallet->balance['total']['quantity']);
    }

    public function signTx($tx)
    {
        $url = static::getWalletServiceUrl("wallets/{$this->walletId}/transactions-sign");
        $response = Http::Post($url, [
            'transaction' => $tx,
            'passphrase' => $this->generateWalletPassPhrase(),
        ]);
        if (! $response->successful()) {
            return throw $response->toException();
        }

        return $response->body();
    }

    protected function parseAddress($address): Fluent
    {
        return new Fluent([
            'id' => $address,
            'qr' => 'data:image/png;base64, '.static::generateQrCode($address),
        ]);
    }

    protected function getSeedTransaction()
    {
        // find seed transaction
        $url = static::getWalletServiceUrl("wallets/{$this->walletId}/transactions");
        $response = Http::get($url);
        if (! $response->successful()) {
            return throw $response->toException();
        }

        return $response->collect()
            ->map(fn ($trans) => new Fluent(json_decode(json_encode($trans))))
            ->filter(
                fn ($trans) => $trans->amount->quantity === config('services.cardano-wallet.validation_seed')
            )->first();
    }

    protected function getCliSeedTransaction()
    {
        $userId = $this->user->id;
        $txs = collect(json_decode(file_get_contents("/data/mint/wallets/users/$userId/deposit.utxos")));

        return $txs->keys()->first();
    }

    protected function getWalletServiceUrl($append = ''): string
    {
        $base = config('services.cardano-wallet.host').':'.config('services.cardano-wallet.port').'/'.$this->version;
        $append = trim($append, '/');

        return "{$base}/{$append}";
    }

    /**
     * @throws ErrorException
     */
    protected function estimateFee($address, $source = 'api')
    {
        return match ($source) {
            'cli' => $this->estimateFeeViaCli($address),
            default => $this->estimateFeeViaApi($address),
        };
    }

    protected function estimateFeeViaApi($addr)
    {
        $url = static::getWalletServiceUrl("wallets/{$this->walletId}/payment-fees");
        $response = Http::post($url, [
            'payments' => [
                [
                    'address' => $addr,
                    'amount' => [
                        'quantity' => 1681000,
                        'unit' => 'lovelace',
                    ],
                ],
            ],
        ]);

        return $response->json();
    }

    protected function estimateFeeViaCli($addr): int
    {
        $seedTxHashAndTxIndex = $this->getCliSeedTransaction();
        $userId = $this->user->id;
        // build tx draft
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'build-raw',
            '--fee',
            0,
            '--tx-in',
            $seedTxHashAndTxIndex,
            '--tx-out',
            "$addr+0",
            '--invalid-hereafter',
            0,
            '--out-file',
            "/data/mint/wallets/users/$userId/deposit.draft",
        ];
        $process = $this->processCommand($command);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        // calculate min fee
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'calculate-min-fee',
            '--tx-body-file',
            "/data/mint/wallets/users/$userId/deposit.draft",
            '--tx-in-count',
            1,
            '--tx-out-count',
            2,
            '--witness-count',
            1,
            '--protocol-params-file',
            '/data/mint/protocol.json',
            $this->networkArgument,
        ];
        $process = $this->processCommand($command, true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        return intval($process->getOutput());
    }

    protected static function processCommand(array|string $command, $fromShell = false): Process
    {
        if ($fromShell) {
            if (is_array($command)) {
                $command = implode(' ', $command);
            }

            return Process::fromShellCommandline($command);
        }

        return new Process($command);
    }

    protected static function generateWalletPassPhrase(): string
    {
        return config('app.key').Auth::user()->getAuthIdentifier();
    }

    protected static function generateWalletName(): string
    {
        return Str::snake(Auth::user()->name).'_'.Auth::user()->getAuthIdentifier();
    }

    protected function saveStakeAddresses($addresses)
    {
        $user = Auth::user();
        $user->wallet_stake_address = $addresses?->stake_address;
        $user->wallet_address = $addresses?->address;
        $user->save();
    }

    public static function generateQrCode($string): string
    {
        $qrCode = QrCode::size(500)
            ->eye('circle')
            ->format('png')
            ->errorCorrection('H')
//            ->backgroundColor(87,138,228)
            ->merge(public_path('/img/llogo-transparent.png'), .3, true)
            ->generate($string);

        return base64_encode($qrCode);
    }
}
