<?php

namespace App\Contracts;

abstract class DelegationModel
{
    public string $activeEpoch;

    public string $txHash;

    public int $amount;

    public string $poolId;
}
