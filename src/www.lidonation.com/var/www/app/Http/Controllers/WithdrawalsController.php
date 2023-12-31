<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\WithdrawalData;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WithdrawalsController extends Controller
{
    public function view(Request $request, Withdrawal $withdrawal)
    {
        $withdrawal->load(['rewards', 'txs']);

        return Inertia::render('Withdrawal', [
            'withdrawal' => $withdrawal,
            'crumbs' => [
                ['label' => 'Rewards'],
                ['label' => 'Withdrawals'],
                ['label' => 'Withdraw'],
            ],
        ]);
    }

    public function index(Request $request)
    {
        return Inertia::render('Withdrawals', [
            'withdrawalsPaginated' => WithdrawalData::collection(
                $request->user()
                    ->withdrawals()
                    ->orderByDesc('created_at')
                    ->withCount('rewards')
                    ->with(['rewards', 'txs'])
                    ->fastPaginate(10)
            ),
            'crumbs' => [
                ['label' => 'Rewards'],
                ['label' => 'Withdrawals'],
            ],
        ]);
    }
}
