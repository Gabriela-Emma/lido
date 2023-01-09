<div wire:init="loadStats" class="overflow-hidden">
    <dl class="flex flex-wrap gap-6">

        <div class="flex flex-col p-2">
            <dt class="order-2 text-sm font-medium text-teal-50 w-24">
                {{__('Amount Given (USD)')}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                {{ $totalAmount ? '$' . number_format($totalAmount, 0, '.', ',') : '-' }}
            </dd>
        </div>
        <div class="flex flex-col p-2">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{__('Funding Challenges')}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                {{$totalRounds ?? '-'}}
            </dd>
        </div>
        <div class="flex flex-col p-2 max-w-sm">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{__('Total Applications')}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                {{$totalProposals ?? '-'}}
            </dd>
        </div>
        <div class="flex flex-col p-2">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{__('Funded Applications')}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                {{$fundedProposalsCount ?? '-'}}
            </dd>
        </div>
    </dl>
</div>
