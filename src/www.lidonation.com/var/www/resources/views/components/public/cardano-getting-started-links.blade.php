<li class="flow-root">
    <a href="{{route('what-is-cardano')}}"
       class="flex items-center p-3 -m-3 font-medium text-gray-800 rounded-md hover:bg-gray-50">
        <div class="w-8 icon">
            @include('svg.cardano')
        </div>
        <span class="ml-4">
              {{ $snippets->whatIsCardano }}
        </span>
    </a>
</li>

<li class="flow-root">
    <a href="{{route('what-is-staking')}}"
       class="flex items-center p-3 -m-3 font-medium text-gray-800 rounded-md hover:bg-gray-50">
        <div class="w-8 icon">
            @include('svg.pool-network')
        </div>
        <span class="ml-4">
            {{ $snippets->whatIsStaking }}
        </span>
    </a>
</li>

<li class="flow-root">
    <a href="{{route('how-to-buy-ada')}}"
       class="flex items-center p-3 -m-3 font-medium text-gray-800 rounded-md hover:bg-gray-50">
        <div class="w-8 icon">
            @include('svg.crypto-bank')
        </div>
        <span class="ml-4">
            {{ $snippets->howToBuyADA }}
        </span>
    </a>
</li>

<li class="flow-root">
    <a href="{{route('how-to-stake-ada')}}"
       class="flex items-center p-3 -m-3 font-medium text-gray-800 rounded-md hover:bg-gray-50">
        <div class="w-8 icon">
            @include('svg.funfair')
        </div>
        <span class="ml-4">
            {{ $snippets->howToStakeYourADA }}
        </span>
    </a>
</li>
