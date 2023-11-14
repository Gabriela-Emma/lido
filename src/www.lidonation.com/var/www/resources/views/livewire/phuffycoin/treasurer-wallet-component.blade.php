<div class="relative flex flex-col gap-6 p-6 rounded-sm shadow bg-clip-border text-teal-900 bg-phuffy-500">
    <div class="flex flex-col h-full gap-4">
        <h3 class="text-4xl font-extrabold">Treasurer</h3>

        <p class="">
            The treasury holds locked lovelaces that has equivalent PHUFFY minted and distributed.
        </p>

        <!-- wallet -->
        <div class="flex flex-col w-full gap-4 px-6 py-4 mt-auto text-white rounded-sm bg-gradient-to-tl to-primary-800 via-primary-600 from-accent-800">
            <h3 class="text-sm font-semibold">Treasurer Wallet</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="text-xs font-semibold text-gray-300">Balance</h3>
                    <div class="text-xl font-semibold">
                    {{round($treasurerWalletBalance)}} ADA
                    </div>
                </div>
                <div>
                    <h3 class="text-xs font-semibold text-gray-300">In Circulation</h3>
                    <div class="text-xl font-semibold">
                    {{humanNumber($treasurerCirculation, 2)}} PHUFFY
                    </div>
                </div>
                <div class="col-span-2">
                    <h3 class="text-xs text-gray-300">Address:</h3>
                    <div class="text-base font-bold break-all">
                        {{config('cardano.mint.addresses.treasurer')}}
                    </div>
                </div>
            </div>

            <div class="text-white bg-gray-900 bg-opacity-25 rounded-sm">
                <div class="rounded-tl-sm rounded-tr-sm bg-primary-900">
                    <h3 class="px-4 py-2 font-semibold">
                        <span>Transactions</span>
                        <span class="text-xs text-gray-400">
                        ({{count($txs)}})
                        </span>
                    </h3>
                </div>
                <div class="w-full overflow-auto">
                    <div class="flex flex-col w-full">
                        <div class="w-full min-w-full -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="w-full py-2 overflow-auto sm:px-6 lg:px-8">
                            <!-- @todo adding tx-table -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div
                        style="top: calc(100% - 0.05rem); clip-path: polygon(0 0,5% 100%,95% 100%,100% 0);"
                        class="absolute left-0 right-0 h-12 bg-gradient-to-b to-transparent from-primary-500"></div> --}}
</div>