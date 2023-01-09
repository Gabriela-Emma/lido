<div
    class="flex flex-col w-full gap-4 px-6 py-4 text-white rounded-sm bg-gradient-to-tl to-primary-800 via-primary-600 from-accent-800">
    <h3 class="font-semibold">My Wallet <span class="text-xs text-teal-600">beta</span></h3>
    <div class="grid grid-cols-2 gap-2">
        <div>
            <h3 class="font-semibold text-gray-300">Phuffy Balance</h3>
            <div class="text-xl font-semibold">
                {{humanNumber($txs_aggregate?->sum?->quantity, 2)}} PHUFFY
            </div>
            <hr class="w-2/3 border-t border-b-0 border-gray-300 border-opacity-50"/>
            <h3 class="font-semibold text-gray-300">Donated</h3>
            <div class="text-xl font-semibold">
                0.00 PHUFFY
            </div>
        </div>
        <div>
            <h3 class="font-semibold text-gray-300">Staked with LIDO</h3>
            <div class="text-xl font-semibold">
                {{$stakedAmount}} ₳
            </div>
            <hr class="w-2/3 border-t border-b-0 border-gray-300 border-opacity-50"/>
            <h3 class="w-2 font-semibold text-gray-300">Rewards</h3>
            <div class="text-xl font-semibold">
                @if(!!$txs_aggregate?->sum?->quantity)
                    {{humanNumber($rewards_aggregate?->sum?->amount / 1000000, 2)}} ₳
                @else
                    -
                @endif
            </div>
        </div>
    </div>
    <div class="text-white bg-gray-900 bg-opacity-25 rounded-md">
        <div class="rounded-tl-sm rounded-tr-md bg-primary-900">
            <h3 class="px-4 py-2 font-semibold">
                <span>Transactions</span>
                @if($txs)
                <span class="text-xs text-gray-400">
                    ({{$txs?->count()}})
                </span>
                @endif
            </h3>
        </div>
        <div>
            <div class="flex flex-col">
                <div class="min-w-full -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        @if($txs)
                            <x-portal.txs-table :txs="$txs" />
                        @else
                            @if(!$user?->has_lido_nft)
                                <div class="p-4">Validate your wallet to see your txs.</div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
