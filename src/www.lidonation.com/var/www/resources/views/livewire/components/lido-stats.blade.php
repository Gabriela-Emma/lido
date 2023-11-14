<div class="overflow-hidden" >
    <dl class="flex flex-wrap gap-6">
        <div class="flex flex-col pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{$snippets->paidToDelegates}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                {{$paidToDelegates ?? '-'}} ₳
            </dd>
        </div>
        <div class="flex flex-col pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{$snippets->delegates}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                {{$epochDelegations ?? '-'}}
            </dd>
        </div>
        <div class="flex flex-col pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{$snippets->causesFund}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                3,600 ₳
            </dd>
        </div>
        <div class="flex flex-col pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{$snippets->stakedWithLIDO}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                {{$epochDelegationAmount ?? '-'}} ₳
            </dd>
        </div>
        <div class="flex flex-col pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{$snippets->foundersPledge}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                92,000 ₳
            </dd>
        </div>
        <div class="flex flex-col pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{$snippets->community}} <br />
                {{$snippets->contributors}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                14
            </dd>
        </div>
        <div class="flex flex-col pr-8">
            <dt class="order-2 text-sm font-medium text-teal-50">
                {{$snippets->lifetime}} <br />
                {{$snippets->blocks}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-2xl 2xl:text-3xl">
                {{$totalBlocks ?? '-'}}
            </dd>
        </div>
    </dl>
</div>
