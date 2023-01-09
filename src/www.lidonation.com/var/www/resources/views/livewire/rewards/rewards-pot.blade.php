<div wire:init="loadRewards"
     class="flex flex-row items-center justify-center xl:justify-start w-full gap-3">
    @forelse($rewardPot ?? [] as $asset)
        @if($asset['amount'] >= $this->rewardsTemplate[$asset['asset'] . '.amount'])
        <div class="border border-green-500 p-4">
            <div class="font-semibold text-xl xl:text-3xl 2xl:text-5xl">
                {{humanNumber($asset['amount']/$asset['divisibility'])}}
            </div>
            <div class="text-green-600 text-sm">
                ${{$asset['name']}}
            </div>
        </div>
        @endif
    @empty
    @endforelse
</div>
