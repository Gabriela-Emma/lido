<div wire:init="loadStats" class="overflow-hidden">
    <dl class="flex flex-wrap">
        {{--        <div class="flex flex-col p-2 pl-0 pr-8">--}}
        {{--            <dt class="order-2 text-sm font-medium text-teal-50">--}}
        {{--                ---}}
        {{--            </dt>--}}
        {{--            <dd class="order-1 text-2xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">--}}
        {{--                ---}}
        {{--            </dd>--}}
        {{--        </div>--}}
        <div class="flex flex-col p-2 pl-0 pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{ $snippets->totalStakedAddresses }}
            </dt>
            <dd class="order-1 text-2xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">

                {{number_format($cardanoStakedAddresses) ?? '-'}}
            </dd>
        </div>
        <div class="flex flex-col p-2 pl-0 pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{ $snippets->totalPools }}
            </dt>
            <dd class="order-1 text-2xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                {{$totalPools ?? '-'}}
            </dd>
        </div>
        {{--                        <div class="flex flex-col p-2 pl-0 pr-8">--}}
        {{--                            <dt class="order-2 text-sm font-medium text-gray-500">--}}
        {{--                                USD per ADA--}}
        {{--                            </dt>--}}
        {{--                            <dd class="order-1 text-2xl font-extrabold text-indigo-600 lg:text-2xl 2xl:text-3xl">--}}
        {{--                                $0.18--}}
        {{--                            </dd>--}}
        {{--                        </div>--}}
        <div class="flex flex-col p-2 pl-0 pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{ $snippets->currentEpoch }}
            </dt>
            <dd class="order-1 text-2xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                {{$currEpochNo ?? '-'}}
            </dd>
        </div>
        @if($adaQuote)
        <div class="flex flex-col p-2 pl-0 pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{ $snippets->priceUSD }}
            </dt>
            <dd class="order-1 text-2xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                ${{ number_format($adaQuote?->price, 2, '.', '.') }}
            </dd>
        </div>
        @endif
        {{--        <div class="flex flex-col p-2 pl-0 pr-8">--}}
        {{--            <dt class="order-2 text-sm font-medium text-teal-50">--}}
        {{--                Total ADA Staked--}}
        {{--            </dt>--}}
        {{--            <dd class="order-1 text-2xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">--}}
        {{--                0.06M--}}
        {{--            </dd>--}}
        {{--        </div>--}}
        {{--                        <div class="flex flex-col p-2 pl-0 pr-8">--}}
        {{--                            <dt class="order-2 text-sm font-medium text-gray-500">--}}
        {{--                                Blocks in epoch--}}
        {{--                            </dt>--}}
        {{--                            <dd class="order-1 text-2xl font-extrabold text-indigo-600 lg:text-2xl 2xl:text-3xl">--}}
        {{--                                ---}}
        {{--                            </dd>--}}
        {{--                        </div>--}}
    </dl>
</div>
