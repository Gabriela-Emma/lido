@if($ownNft)
    <div>
        <div class="flex flex-col justify-center items-center" x-show="!stakeAccount"
             @lido-rewards-loaded.window="seeRewards(true)">
            <h2>
                Let's get you connected!
            </h2>
            <x-delegators.connect-wallet/>
        </div>
        <div>  
            <div class="border-b border-teal-900 w-full" x-show="stakeAccount">
                <div>
                    <h2 class="text-center">Claim your reward</h2>
                    <div class="flex gap-4 my-4 w-full">
                        <livewire:rewards.claim-lido-rewards-component :rewards-template="$rewardsTemplate"
                                                                       :every-epoch="$everyEpoch"/>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <p class="italic font-medium text-slate-100">
                                Congratulations you do own an nft!
                            </p>
                        </div>
                    </div>
                    <div class="-mx-4 mt-4 overflow-hidden ring-1 ring-teal-800 sm:-mx-6 md:mx-0 md:rounded-sm">
                        <img src="{{ $nftLinks['0'] }}" alt="nft image">
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div>
        <div class="flex flex-col justify-center items-center" x-show="!stakeAccount"
             @lido-rewards-loaded.window="seeRewards(true)">
            <h2>
                Let's get you connected!
            </h2>
            <x-delegators.connect-wallet/>
        </div>
        <div>
            <div class="border-b border-teal-900 w-full" x-show="stakeAccount">
                <div>
                    <h2 class="text-center">Claim your reward</h2>
                    <div class="flex gap-4 my-4 w-full">
                        <livewire:rewards.claim-lido-rewards-component :rewards-template="$rewardsTemplate"
                                                                       :every-epoch="$everyEpoch"/>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <p class="italic font-medium text-slate-100">
                                Sorry you do not own nfts
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
