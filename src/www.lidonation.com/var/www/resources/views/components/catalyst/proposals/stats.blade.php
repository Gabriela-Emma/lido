@props([
    'challengesCount' =>  '-',
    'approvedChallengesCount' => '-',
    'totalProposals' =>  '-',
    'totalAwardedAmount' =>  '-',
    'fundedProposalsCount' => '-',
    'completedProposalsCount' => '-',
    'overBudgetProposalsCount'=> '-'
])
<dl class="flex flex-wrap gap-4">
    <div class="flex flex-wrap gap-6">
        <div class="flex flex-col max-w-sm p-2">
            <dt class="order-2 text-xs md:text-sm font-medium text-teal-50">
                {{__('Total Proposals')}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                {{$totalProposals}}
            </dd>
        </div>
        <div class="flex flex-col p-2">
            <dt class="order-2 text-xs md:text-sm font-medium text-teal-50">
                {{__('Funded Proposals')}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                {{$fundedProposalsCount}}
            </dd>
        </div>
        <div class="flex flex-col p-2">
            <dt class="order-2 text-xs md:text-sm font-medium text-teal-50">
                {{__('Completed Proposals')}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                {{$completedProposalsCount}}
            </dd>
        </div>
        <div class="flex flex-col p-2">
            <dt class="order-2 text-xs md:text-sm font-medium text-teal-50">
                {{__('Total Awarded')}}
            </dt>
            <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-2xl">
                ${{humanNumber($totalAwardedAmount, 2)}}
            </dd>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 text-gray-600">
        <div class="flex flex-wrap gap-6 h-full border-t-2 md:border-t-0 pt-2 md:pt-0 md:border-l-2 border-teal-500 md:px-4">
            <div class="flex flex-col max-w-xs p-2">
                <dt class="order-2 text-xs md:text-sm font-medium text-teal-100 break-words">
                    {{__('Community Challenges')}}
                </dt>
                <dd class="order-1 text-xl text-blue-dark-500 font-extrabold lg:text-xl 2xl:text-3xl">
                    {{$challengesCount}}
                </dd>
            </div>
            <div class="flex flex-col p-2  max-w-xs">
                <dt class="order-2 text-xs md:text-sm font-medium text-teal-100">
                    {{__('Approved Challenges')}}
                </dt>
                <dd class="order-1 text-xl text-blue-dark-500 font-extrabold lg:text-xl 2xl:text-3xl">
                    {{$approvedChallengesCount}}
                </dd>
            </div>
        </div>

    </div>
</dl>
