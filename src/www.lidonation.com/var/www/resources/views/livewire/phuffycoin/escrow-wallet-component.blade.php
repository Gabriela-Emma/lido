<div class="relative flex flex-col gap-6 p-6 rounded-sm shadow bg-clip-border text-teal-900 bg-phuffy-500">
    <div class="flex flex-col h-full gap-4">
        <h3 class="text-4xl font-extrabold">
            Escrow
        </h3>

        <p class="text-black">
            Where redeemed lovelaces go when cause wins in a campaign and related PHUFFY is burned.
            Last step before transferred to winning cause.
        </p>

        <!-- Wallet -->
        <div class="flex flex-col w-full gap-4 px-6 py-4 mt-auto text-white rounded-sm bg-gradient-to-tl to-primary-800 via-primary-600 from-accent-800">
            <h3 class="text-sm font-semibold">Escrow Wallet</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="text-xs font-semibold text-gray-300">Balance</h3>
                    <div class="text-xl font-semibold">
                    {{round($escrowWalletBalance)}} ADA                    </div>
                </div>
                <div class="col-span-2">
                    <h3 class="text-xs text-gray-300">Address:</h3>
                    <div class="text-base font-bold break-all">
                        {{config('cardano.mint.addresses.escrow')}}
                    </div>
                </div>
            </div>

            <div class="text-white bg-gray-900 bg-opacity-25 rounded-sm">
                <div class="rounded-tl-sm rounded-tr-sm bg-primary-900">
                    <h3 class="px-4 py-2 font-semibold">
                        <span>Transactions</span>
                        <span class="text-xs text-gray-400">
                        ({{$txs}})
                        </span>
                    </h3>
                </div>
                <div>
                    <div class="flex flex-col">
                        <div class="min-w-full -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 overflow-auto sm:px-6 lg:px-8">
                                ###
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>