<div wire:init="loadRewards" class="p-2 flex gap-2 justify-center w-full">
    @forelse($rewardPot ?? [] as $asset)
        @if($asset['amount'] >= $rewardsTemplate[$asset['asset'] . '.amount'])
            <button type="button"
                    :disabled="quizSubmitted"
                    :class="{'cursor-not-allowed':quizSubmitted}"
                    @click="submitQuiz('{{data_get($asset, 'asset')}}')"
                    class="inline-flex items-center rounded-sm border border-green-500 bg-transparent px-2.5 py-1.5 text-md font-semibold text-green-500 hover:bg-green-500/25 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                Claim {{isset($rewardsTemplate[$asset['asset'] . '.amount']) ? humanNumber($rewardsTemplate[$asset['asset'] . '.amount'] / $asset['divisibility'], 2) : '-'}}
                ${{$asset['name']}}
            </button>
        @endif
    @empty
        <div>
            <h2>
                Looks like available rewards in selected asset have all been issued. Come back next epoch
            </h2>
        </div>
    @endforelse
</div>
