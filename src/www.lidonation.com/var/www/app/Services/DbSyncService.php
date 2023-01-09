<?php

namespace App\Services;

use App\Repositories\EpochRepository;
use App\Services\Traits\DbSyncHelpers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class DbSyncService
{
    use DbSyncHelpers;

    public function __construct(protected EpochRepository $epochRepository)
    {
    }

    public function poolDelegations($useCache = true): Collection
    {
        if (! $useCache) {
            return $this->getPoolDelegators();
        }

        return Cache::remember(
            'poolDelegations',
            now()->addHour(),
            fn () => $this->getPoolDelegators()
        );
    }

    public function poolDelegationCount($useCache = true): int
    {
        if (! $useCache) {
            return $this->getPoolDelegators()->count();
        }

        return (int) Cache::remember(
            'poolDelegationCount',
            now()->addHour(),
            fn () => $this->getPoolDelegators()->count()
        );
    }

    public function poolDelegationAmount($humanReadable = true, $useCache = true): float|string
    {
        $delegations = $this->getEpochDelegations($this->epochRepository->current()?->no)
                ->sum('amount') / 1000000;

        if ($humanReadable) {
            $delegations = humanNumber($delegations, 2);
        }

        if (! $useCache) {
            return $delegations;
        }

        return (string) Cache::remember(
            'poolDelegationAmount',
            now()->addHour(),
            fn () => $delegations
        );
    }

    public function totalPoolRewards($includeSpo = false, $humanReadable = true, $useCache = true): ?string
    {
        $rewards = $this->poolRewardsSum($includeSpo) / 1000000;
        if ($rewards === 0) {
            return null;
        }

        if ($humanReadable) {
            $rewards = humanNumber($rewards, 2);
        }

        if (! $useCache) {
            return $rewards;
        }

        return (string) Cache::remember(
            'totalPoolRewards',
            now()->addHour(),
            fn () => $rewards
        );
    }

    public function totalStakedAddresses($useCache = true): string
    {
        if (! $useCache) {
            return $this->cardanoStakedAddresses();
        }

        return (string) Cache::remember(
            'totalStakedAddresses',
            now()->addHour(),
            fn () => $this->cardanoStakedAddresses()
        );
    }
}
