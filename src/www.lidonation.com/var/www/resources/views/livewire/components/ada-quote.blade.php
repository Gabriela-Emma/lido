<div>
    @if($adaQuote)
        @if($tableView == 'true')
            <div class="flex flex-col p-2 pl-0 pr-8">
                <dt class="order-2 text-sm font-medium text-teal-50">
                    {{ $snippets->priceUSD }}
                </dt>
                <dd class="order-1 text-2xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                    ${{ number_format($adaQuote?->price, 2, '.', '.') }}
                </dd>
            </div>
        @else
            ${{ number_format($adaQuote?->price, 2, '.', '.') }}
        @endif
    @endif
</div>
