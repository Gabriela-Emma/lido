<?php

namespace App\Services;

use App\Models\User;
use App\Services\Traits\DbSyncHelpers;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Symfony\Component\Process\Process;
use Whoops\Exception\ErrorException;

class CardanoMintService
{
    use DbSyncHelpers;

    public function __construct(
        protected CardanoWalletService $cardanoWalletService,
        protected User $user,
        protected ?string $policyScript = '/data/mint/policies/lido-auth/policy.script',
        protected ?string $metaData = null,
        protected $graphic = null,
        protected $tokenName = null,
        protected ?string $networkArgument = null,
        protected ?string $paymentAddress = null,
        protected ?string $policyId = null
    ) {
        $this->user = $this->user ?? Auth::user();
        $this->graphic = $this->graphic ?? config('cardano.mint.tokens.lido_delegate_nft.image');
        $this->tokenName = $this->tokenName ?? config('cardano.mint.tokens.lido_delegate_nft.name');
        $this->paymentAddress = $this->paymentAddress ?? config('cardano.mint.payment-address');
        $this->policyId = $this->policyId ?? config('cardano.mint.policies.lido_delegate');
        $this->networkArgument = $this->networkArgument ?? config('cardano.network-argument');
    }

    /**
     * @throws ErrorException
     * @throws RequestException
     */
    public function mint()
    {
        // housekeeping
        $this->user = Auth::user();
        $userId = $this->user->getAuthIdentifier();

        // verify user hasn't already been issued a nft
        if ($this->cardanoWalletService->hasLidoNft()) {
            throw new ErrorException('Auth NFT has already been issued to this address. Please Contact support a manual refund.');
        }

        // make sure working dir exists
        $process = $this->processCommand("mkdir -p /data/mint/wallets/users/$userId");
        $process->run();

        // get mint wallet utxo for paying fees
        $mintUtxo = $this->getMintUtxos()?->first();

        // get user original utxo and address to issue refund
        $seedTxHash = $this->user->wallet_validation_seed_tx;
        $seedAmount = $this->cardanoWalletService->getRefundAmount();
        $seedTxIndex = $this->user->wallet_validation_seed_index;
        $toAddress = $this->user?->wallet_address;
        $seedFee = $seedAmount - intval(Auth::user()->wallet_validation_seed_amount);

        // draft tx to calculate fee
        if (! $this->metaData) {
            $this->generateMetaData();
        }
        $tokenAmount = 1;
        $mint = "--mint='$tokenAmount $this->policyId.$this->tokenName'";
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'build-raw',
            '--fee',
            0,
            '--tx-in',
            "$seedTxHash#$seedTxIndex",
            '--tx-in',
            $mintUtxo->txIn,
            '--tx-out',
            "$toAddress+$seedAmount+".'"'."$tokenAmount $this->policyId.$this->tokenName".'"',
            $mint,
            '--tx-out',
            "$this->paymentAddress+0",
            "--minting-script-file $this->policyScript",
            "--metadata-json-file $this->metaData",
            '--invalid-hereafter',
            0,
            '--out-file',
            "/data/mint/wallets/users/$userId/tx.draft",
        ];
        $process = $this->processCommand($command);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        // calculate fees
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'calculate-min-fee',
            '--tx-body-file',
            "/data/mint/wallets/users/$userId/tx.draft",
            '--tx-in-count',
            2,
            '--tx-out-count',
            2,
            '--witness-count',
            '1',
            $this->networkArgument,
            '--protocol-params-file',
            '/data/mint/protocol.json',
        ];
        $process = Process::fromShellCommandline(implode(' ', $command));
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }
        $this->fee = intval($process->getOutput());
        $mintUtxo->outPutAfterTx = $mintUtxo->amount - $this->fee - $seedFee;

        // get current slot
        $process = $this->processCommand("/opt/cardano-cli query tip $this->networkArgument");
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }
        $tip = json_decode($process->getOutput());

        // build final tx
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'build-raw',
            '--fee',
            $this->fee,
            '--tx-in',
            "$seedTxHash#$seedTxIndex",
            '--tx-in',
            $mintUtxo->txIn,
            '--tx-out',
            "$this->paymentAddress+$mintUtxo->outPutAfterTx",
            '--tx-out',
            "$toAddress+$seedAmount+".'"'."$tokenAmount $this->policyId.$this->tokenName".'"',
            $mint,
            "--minting-script-file $this->policyScript",
            "--metadata-json-file $this->metaData",
            '--invalid-hereafter',
            intval($tip->slot) + 1000,
            '--out-file',
            "/data/mint/wallets/users/$userId/tx.final",
        ];
        $process = $this->processCommand($command);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        // Sign transactions
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'sign',
            '--tx-body-file',
            "/data/mint/wallets/users/$userId/tx.final",
            // temp wallet sig
            '--signing-key-file',
            "/data/mint/wallets/users/$userId/deposit.skey",
            // mint payment wallet sig
            '--signing-key-file',
            '/data/mint/payment.skey',
            // policy sig
            '--signing-key-file',
            '/data/mint/policies/lido-auth/policy.skey',
            // other args
            $this->networkArgument,
            '--out-file',
            "/data/mint/wallets/users/$userId/tx.signed",
        ];
        $process = $this->processCommand($command);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        // Issue refund and nft
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'submit',
            '--tx-file',
            "/data/mint/wallets/users/$userId/tx.signed",
            $this->networkArgument,
        ];
        $process = $this->processCommand($command);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }
        try {
            $this->user->assignRole('delegator');
        } catch (RoleDoesNotExist $e) {
            // do nothing
        }

        return true;
    }

    public function getSeedKeys()
    {
        $command = [
            'cardano-wallet recovery-phrase generate --size 15 \
            | cardano-wallet key from-recovery-phrase Shelley > root.prv',
        ];
        $process = $this->processCommand($command);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }
    }

    public function getMintUtxos(): Collection
    {
        // get mint wallet utxo for paying fees
        $command = [
            '/opt/cardano-cli',
            'query',
            'utxo',
            '--address',
            config('cardano.mint.payment-address'),
            $this->networkArgument,
            '--out-file',
            '/data/mint/utxos',
        ];
        $process = $this->processCommand($command);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        return collect(json_decode(file_get_contents('/data/mint/utxos')))
            ->map(function ($utxo, $key) {
                $utxo->txIn = $key;
                $utxo->amount = $utxo->value->lovelace;

                return $utxo;
            })
            ->filter(fn ($utxo) => $utxo->value->lovelace >= 5000000);
    }

    /**
     * take all utxos < 3 ADA and output into a new single utxo for the mint's paymentAddress
     */
    public function collectDust()
    {
    }

    protected function generateMetaData()
    {
        $metadata = [
            '721' => [
                $this->policyId => [
                    config('cardano.mint.tokens.lido_delegate_nft.name') => [
                        'name' => config('cardano.mint.tokens.lido_delegate_nft.name'),
                        'image' => config('cardano.mint.tokens.lido_delegate_nft.image'),
                        'description' => config('cardano.mint.tokens.lido_delegate_nft.description'),
                    ],
                ],
            ],
        ];

        file_put_contents("/data/mint/wallets/users/{$this->user->id}/metadata.json", json_encode($metadata));
        $this->metaData = "/data/mint/wallets/users/{$this->user->id}/metadata.json";
    }

    protected static function processCommand(array|string $command, $fromShell = true): Process
    {
        if ($fromShell) {
            if (is_array($command)) {
                $command = implode(' ', $command);
            }

            return Process::fromShellCommandline($command);
        }

        return new Process($command);
    }
}
