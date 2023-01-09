<?php

namespace App\Services;

use App\Contracts\ProvidesCardanoService;
use App\Models\Mint;
use App\Models\User;
use App\Models\Vote;
use App\Services\Traits\DbSyncHelpers;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Fluent;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Process\Process;
use Whoops\Exception\ErrorException;

class PhuffycoinService
{
    use DbSyncHelpers;

    public function __construct(
        protected CardanoMintService $cardanoMintService,
        protected ProvidesCardanoService $cardanoService
    ) {
    }

    public function getDelegations(User $user): Collection
    {
        $response = $this->cardanoService->account($user, 'history');

        return $response->collect()->mapInto(Fluent::class);
    }

    public function getEpochDelegation(User $user, int $epoch)
    {
        return $this->getDelegations($user)
            ->firstWhere(
                fn ($delegation) => $delegation->activeEpoch === $epoch
                    && $delegation->poolId === config('cardano.pool.hash')
            );
    }

    public function delegatedInEpoch(User $user, int $epoch): bool
    {
        return (bool) $this->getEpochDelegation($user, $epoch);
    }

    public function getCohortDelegations(int $epoch): Collection
    {
        $users = User::whereNotNull('wallet_stake_address')->cursor();
        $delegations = collect([]);
        // @todo turn this into an async call (or batches) that fetches multiple users at a time
        foreach ($users as $user) {
            $epochDelegation = $this->getEpochDelegation($user, $epoch);
            if (! $epochDelegation) {
                continue;
            }
            $delegations->push($epochDelegation);
        }

        return $delegations;
    }

    public function getCohortHighestDelegatedAmount(int $epoch): int|null
    {
        return $this->getCohortDelegations($epoch)->sortByDesc('amount')->first()?->amount ?? null;
    }

    public function getUserEpochCohortScore(User $user, $epoch): float|int|null
    {
        // get all their epochs
        $epochDelegation = $this->getEpochDelegation($user, $epoch);

        // validate stake for epoch
        if (! $epochDelegation) {
            return null;
        }

        if ($epochDelegation->amount < 10000000) {
            return null;
        }

        // find pool the highest delegator
        $highestAmountDelegated = $this->getCohortHighestDelegatedAmount($epoch);
        $delegationAmount = $epochDelegation->amount;
        $response = $this->cardanoService->account($user, 'delegations');
        $delegations = $response->collect()->mapInto(Fluent::class);

        // find first non-lido delegation
        if ($delegations->count() === 1) {
            $latestLidoDelegation = $delegations->first();
        } else {
            $marker = $delegations->search(fn ($delegation) => $delegation->poolId !== config('cardano.pool.hash'));
            if (! $marker) {
                $latestLidoDelegation = $delegations->last();
            } else {
                $latestLidoDelegation = $delegations->get($marker - 1);
            }
        }

        $epochsInPool = $epoch - $latestLidoDelegation->activeEpoch + 1;

        return (
            (log($delegationAmount) + 1) / (log($highestAmountDelegated) + 1) * 100
        ) +
            ($epochsInPool * .1);
    }

    /**
     * @throws ErrorException
     */
    public function submitMintTransaction(Mint &$mint)
    {
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'submit',
            '--tx-file',
            "/data/mint/wallets/mints/{$mint->id}/mint.signed",
            config('cardano.network-argument'),
        ];
        $process = $this->processCommand($command, true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }
    }

    /**
     * @throws ErrorException
     * @throws GuzzleException
     */
    #[NoReturn]
 public function submitPhuffyVote(Vote $vote)
 {
     $this->generateVoteDraft($vote);
     $this->generatePhuffyVoteTx($vote);
     $this->signVoteTransaction($vote);
     $this->submitVoteTransaction($vote);
 }

    /**
     * @throws ErrorException
     */
    public function signMintTransaction(Mint &$mint)
    {
        // Sign transactions
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'sign',
            '--tx-body-file',
            "/data/mint/wallets/mints/{$mint->id}/mint.final",
            // temp wallet sig
            '--signing-key-file',
            "/data/mint/wallets/mints/{$mint->id}/deposit.skey",
            // mint payment wallet sig
            '--signing-key-file',
            '/data/mint/payment.skey',
            // policy sig
            '--signing-key-file',
            '/data/mint/policies/phuffycoin/policy.skey',
            // other args
            config('cardano.network-argument'),
            '--out-file',
            "/data/mint/wallets/mints/{$mint->id}/mint.signed",
        ];
        $process = $this->processCommand($command, true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }
    }

    /**
     * @throws ErrorException
     */
    public function generateMintTransaction(Mint &$mint)
    {
        // draft
        $this->generateMintTransactionDraft($mint);

        // args
        $tokenName = config('cardano.mint.tokens.phuffy_coin.name');
        $policyId = config('cardano.mint.policies.phuffycoin');
        $mintAddress = config('cardano.mint.payment-address');
        $metadataFile = $this->generateMetaData($mint);

        // deposit amounts
        $depositUtxos = collect(json_decode(file_get_contents("/data/mint/wallets/mints/{$mint->id}/deposit.utxos")));
        $depositTxHashAndTxIndex = $depositUtxos->keys()->first();
        $depositWalletBalance = $depositUtxos->sum(fn ($utxo) => $utxo->value->lovelace);

        // mint treasury amount
        $mintUtxo = $this->getMintInput();
        $mintAmount = $mint->txs->sum('amount');

        // dusts, fees and minimums
        $fee = $this->calculateMintTransactionFee($mint);

        $dust = $depositWalletBalance - $mintAmount;
        $minTokenLovelaces = (int) ceil(((mb_strlen($tokenName) - 1) / 8) * 37037 + 1444443);

        // mint deposit
        $treasurerDepositAddr = config('cardano.mint.addresses.treasurer');

        // tx change to mint treasury
        $change = ($mintUtxo->amount + $dust) - (($minTokenLovelaces * $mint->txs->count()) + $fee);

        // get current slot
        $tip = static::getCurrentTip();

        // build final tx
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'build-raw',
            '--fee',
            $fee,
            '--tx-in',
            $depositTxHashAndTxIndex,
            '--tx-in',
            $mintUtxo->txIn,
            '--tx-out',
            "$mintAddress+$change",
            '--tx-out',
            "$treasurerDepositAddr+$mintAmount",
            '--mint="'."$mintAmount $policyId.$tokenName".'"',
            '--minting-script-file /data/mint/policies/phuffycoin/policy.script',
            "--metadata-json-file $metadataFile",
            '--invalid-hereafter',
            intval($tip->slot) + 1000,
            '--out-file',
            "/data/mint/wallets/mints/{$mint->id}/mint.final",
        ];
        $mint->txs->each(function ($tx) use (&$command, $policyId, $tokenName, $minTokenLovelaces) {
            $command[] = '--tx-out';
            $command[] = "{$tx->user->wallet_address}+$minTokenLovelaces+".'"'."{$tx->amount} $policyId.$tokenName".'"';
        });

        $process = $this->processCommand($command, true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }
    }

    public function getMintTransactionRecord(Mint &$mint)
    {
        $baseDir = "/data/mint/wallets/mints/{$mint->id}";
        if (file_exists("$baseDir/deposit.addr")) {
            $addy = file_get_contents("$baseDir/deposit.addr");
            $txs = $this->getTxOuts($addy);

            return $txs->firstWhere('value', $mint->mint_seed_amount);
        }

        return null;
    }

    /**
     * @throws ErrorException
     */
    protected function generateMintTransactionDraft(Mint &$mint)
    {
        $txs = collect(json_decode(file_get_contents("/data/mint/wallets/mints/{$mint->id}/deposit.utxos")));
        $depositTxHashAndTxIndex = $txs->keys()->first();

        $mintUtxo = $this->getMintInput();
        $metadataFile = $this->generateMetaData($mint);
        $tokenName = config('cardano.mint.tokens.phuffy_coin.name');
        $tokenAmount = $mint->txs->sum('amount');
        $policyId = config('cardano.mint.policies.phuffycoin');

        // build tx draft
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'build-raw',
            '--fee',
            0,
            '--tx-in',
            $depositTxHashAndTxIndex,
            '--tx-in',
            $mintUtxo->txIn,
            '--mint="'."$tokenAmount $policyId.$tokenName".'"',
            '--minting-script-file /data/mint/policies/phuffycoin/policy.script',
            "--metadata-json-file $metadataFile",
            '--invalid-hereafter',
            0,
            '--out-file',
            "/data/mint/wallets/mints/{$mint->id}/mint.draft",
        ];
        $mint->txs->each(function ($tx) use (&$command, $policyId, $tokenName) {
            $minTokenLovelaces = ceil(((mb_strlen($tokenName) - 1) / 8) * 37037 + 1444443);
            $command[] = '--tx-out';
            $command[] = "{$tx->user->wallet_address}+$minTokenLovelaces+".'"'."{$tx->amount} $policyId.$tokenName".'"';
        });

        $process = $this->processCommand($command, true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }
    }

    /**
     * @throws ErrorException
     */
    protected function calculateMintTransactionFee(Mint &$mint): int
    {
        // calculate fees
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'calculate-min-fee',
            '--tx-body-file',
            "/data/mint/wallets/mints/{$mint->id}/mint.draft",
            '--tx-in-count',
            2,
            '--tx-out-count',
            $mint->txs->count() + 2,
            '--witness-count',
            '1',
            config('cardano.network-argument'),
            '--protocol-params-file',
            '/data/mint/protocol.json',
        ];
        $process = Process::fromShellCommandline(implode(' ', $command));
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        return intval($process->getOutput());
    }

    protected function generateMetaData(Mint &$mint): string
    {
        $metadata = [
            '0' => [
                'map' => [
                    [
                        'k' => [
                            'string' => 'pool',
                        ],
                        'v' => [
                            'string' => $mint->type,
                        ],
                    ],
                    [
                        'k' => [
                            'string' => 'cohort',
                        ],
                        'v' => [
                            'string' => $mint->group,
                        ],
                    ],
                    [
                        'k' => [
                            'string' => 'memo',
                        ],
                        'v' => [
                            'string' => $mint->memo,
                        ],
                    ],
                ],
            ],
            '674' => [
                'msg' => [
                    'LIDO Delegation PHUFFY Iss.',
                    "memo: $mint->memo",
                ],
            ],
        ];

        file_put_contents("/data/mint/wallets/mints/{$mint->id}/metadata.json", json_encode($metadata, JSON_FORCE_OBJECT));

        return "/data/mint/wallets/mints/{$mint->id}/metadata.json";
    }

    /**
     * @throws ErrorException
     */
    protected function calculateVoteTransactionFee(Vote &$vote): int
    {
        // calculate fees
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'calculate-min-fee',
            '--tx-body-file',
            "/data/mint/wallets/votes/{$vote->id}/vote.draft",
            '--tx-in-count',
            2,
            '--tx-out-count',
            3,
            '--witness-count',
            '1',
            config('cardano.network-argument'),
            '--protocol-params-file',
            '/data/mint/protocol.json',
        ];
        $process = Process::fromShellCommandline(implode(' ', $command));
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        return intval($process->getOutput());
    }

    /**
     * @throws ErrorException
     */
    protected function submitVoteTransaction(Vote &$vote)
    {
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'submit',
            '--tx-file',
            "/data/mint/wallets/votes/{$vote->id}/vote.signed",
            config('cardano.network-argument'),
        ];
        $process = $this->processCommand($command, true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }
    }

    /**
     * @throws ErrorException
     */
    protected function signVoteTransaction(Vote &$vote)
    {
        // Sign transactions
        $command = [
            '/opt/cardano-cli',
            'transaction',
            'sign',
            '--tx-body-file',
            "/data/mint/wallets/votes/{$vote->id}/vote.final",
            // temp wallet sig
            '--signing-key-file',
            "/data/mint/wallets/votes/{$vote->id}/deposit.skey",
            // mint payment wallet sig
            '--signing-key-file',
            '/data/mint/payment.skey',
            // policy sig
            '--signing-key-file',
            '/data/mint/policies/maji/policy.skey',
            // other args
            config('cardano.network-argument'),
            '--out-file',
            "/data/mint/wallets/votes/{$vote->id}/vote.signed",
        ];
        $process = $this->processCommand($command, true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }
    }

    /**
     * @throws ErrorException
     * @throws GuzzleException
     */
    #[NoReturn]
 protected function generatePhuffyVoteTx(Vote &$vote)
 {
     // args
     $tokenPhuffyName = config('cardano.mint.tokens.phuffy_coin.name');
     $phuffyPolicyId = config('cardano.mint.policies.phuffycoin');

     $tokenMajiName = config('cardano.mint.tokens.maji_coin.name');
     $majiPolicyId = config('cardano.mint.policies.maji');

     $metadataFile = "/data/mint/wallets/votes/{$vote->id}/metadata.json";

     // mint treasury amount
     $mintAddress = config('cardano.mint.payment-address');
     $mintUtxo = $this->getMintInput();

     // get utxos
     [$depositPhuffyUtxos, $depositUtxos] = $this->getVoteUtxos($vote);

     // balances
     $depositTxHashAndTxIndex = $depositUtxos->keys()->first();
     $depositWalletAdaBalance = $depositUtxos->sum(fn ($utxo) => $utxo->value->lovelace);
     $depositWalletPhuffyBalance = $depositPhuffyUtxos->sum('quantity');

     // get current slot
     $tip = static::getCurrentTip();

     // dusts, fees and minimums
     $fee = $this->calculateVoteTransactionFee($vote);

     $minUtxoLovelaces = (int) ceil(((mb_strlen($tokenMajiName) - 1) / 8) * 37037 + 1444443);

     // mint deposit
     $governorDepositAddr = config('cardano.mint.addresses.governor');

     // tx change to mint treasury
     $change = ($mintUtxo->amount) - ($minUtxoLovelaces + $fee);

     $majiMintAmount = 5000000;
     $user = Auth::user();

     // build final tx
     $command = [
         '/opt/cardano-cli',
         'transaction',
         'build-raw',
         '--fee',
         $fee,
         '--tx-in',
         $depositTxHashAndTxIndex,
         '--tx-in',
         $mintUtxo->txIn,
         '--tx-out',
         "$mintAddress+$change",
         '--tx-out',
         "{$user->wallet_address}+$depositWalletAdaBalance+".'"'."{$majiMintAmount} $majiPolicyId.$tokenMajiName".'"',
         '--tx-out',
         "$governorDepositAddr+$minUtxoLovelaces+".'"'."$depositWalletPhuffyBalance $phuffyPolicyId.$tokenPhuffyName".'"',
         '--mint="'."$majiMintAmount $majiPolicyId.$tokenMajiName".'"',
         '--minting-script-file /data/mint/policies/maji/policy.script',
         "--metadata-json-file $metadataFile",
         '--invalid-hereafter',
         intval($tip->slot) + 1000,
         '--out-file',
         "/data/mint/wallets/votes/{$vote->id}/vote.final",
     ];
     $process = $this->processCommand($command, true);
     $process->run();
     if (! $process->isSuccessful()) {
         throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
     }
 }

    /**
     * @throws ErrorException
     * @throws GuzzleException
     */
    #[NoReturn]
 protected function generateVoteDraft(Vote &$vote)
 {
     $mintAddress = config('cardano.mint.payment-address');
     $mintUtxo = $this->getMintInput();

     $governorDepositAddr = config('cardano.mint.addresses.governor');

     $tokenPhuffyName = config('cardano.mint.tokens.phuffy_coin.name');
     $phuffyPolicyId = config('cardano.mint.policies.phuffycoin');

     $tokenMajiName = config('cardano.mint.tokens.maji_coin.name');
     $majiPolicyId = config('cardano.mint.policies.maji');
     $majiAmount = 5000000;

     // get utxos
     [$depositPhuffyUtxos, $depositUtxos] = $this->getVoteUtxos($vote);

     // balances
     $depositTxHashAndTxIndex = $depositUtxos->keys()->first();
     $depositWalletAdaBalance = $depositUtxos->sum(fn ($utxo) => $utxo->value->lovelace);
     $depositWalletPhuffyBalance = $depositPhuffyUtxos->sum('quantity');

     $minUtxoLovelaces = (int) ceil(((mb_strlen($tokenMajiName) - 1) / 8) * 37037 + 1444443);
     $change = ($mintUtxo->amount) - (($minUtxoLovelaces * 2));

     // generate metadata
     $metadata = [
         '674' => [
             'msg' => [
                 'LIDO PHUFFY Vote',
                 "for {$vote->cause?->title}",
             ],
         ],
     ];
     file_put_contents("/data/mint/wallets/votes/{$vote->id}/metadata.json", json_encode($metadata, JSON_FORCE_OBJECT));
     $metadataFile = "/data/mint/wallets/votes/{$vote->id}/metadata.json";

     $user = Auth::user();

     // build tx draft
     $command = [
         '/opt/cardano-cli',
         'transaction',
         'build-raw',
         '--fee',
         0,
         '--tx-in',
         $depositTxHashAndTxIndex,
         '--tx-in',
         $mintUtxo->txIn,
         '--tx-out',
         "$mintAddress+$change",
         '--tx-out',
         "{$user->wallet_address}+1500000+".'"'."{$majiAmount} $majiPolicyId.$tokenMajiName".'"',
         '--tx-out',
         "$governorDepositAddr+$depositWalletAdaBalance+".'"'."$depositWalletPhuffyBalance $phuffyPolicyId.$tokenPhuffyName".'"',
         '--mint="'."$majiAmount $majiPolicyId.$tokenMajiName".'"',
         '--minting-script-file /data/mint/policies/maji/policy.script',
         "--metadata-json-file $metadataFile",
         '--invalid-hereafter',
         0,
         '--out-file',
         "/data/mint/wallets/votes/{$vote?->id}/vote.draft",
     ];

     $process = $this->processCommand($command, true);
     $process->run();
     if (! $process->isSuccessful()) {
         throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
     }
 }

    /**
     * @throws ErrorException
     * @throws GuzzleException
     */
    protected function getVoteUtxos(Vote &$vote): array
    {
        // phuffy deposit amounts
        $depositPhuffyUtxos = app(CardanoGraphQLService::class)
            ->getAddressesTokenUtxos(
                config('cardano.mint.policies.phuffycoin'),
                [$vote->wallets?->first()?->address]
            );

        // ada deposit amounts
        $depositUtxos = app(CardanoWalletService::class)
            ->getAddressUtxos(
                "/data/mint/wallets/votes/$vote?->id",
                $vote->wallets?->first()?->address
            );

        return [$depositPhuffyUtxos, $depositUtxos];
    }

    /**
     * @throws ErrorException
     */
    protected function getMintInput()
    {
        return $this->cardanoMintService
            ->getMintUtxos()
            ?->filter(fn ($utxo) => $utxo->value->lovelace >= 10000000)
            ->first();
    }

    protected static function getCurrentTip()
    {
        $networkArgument = config('cardano.network-argument');
        $process = static::processCommand("/opt/cardano-cli query tip $networkArgument", true);
        $process->run();
        if (! $process->isSuccessful()) {
            throw new ErrorException($process->getErrorOutput(), $process->getExitCode());
        }

        return json_decode($process->getOutput());
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
}
