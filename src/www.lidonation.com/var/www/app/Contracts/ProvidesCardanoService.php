<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Http\Client\Response;

interface ProvidesCardanoService
{
    public function account(string | User $account, string $detail = ''): Response;
    public function tx(string $hash = ''): Response;
}
