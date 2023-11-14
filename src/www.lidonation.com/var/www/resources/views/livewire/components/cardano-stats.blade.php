<div class="overflow-hidden">
    <dl class="flex flex-wrap">
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
        <div class="flex flex-col p-2 pl-0 pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{ $snippets->currentEpoch }}
            </dt>
            <dd class="order-1 text-2xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                {{$currEpochNo ?? '-'}}
            </dd>
        </div>
        <livewire:components.ada-quote :tableView='true' />
    </dl>
</div>
