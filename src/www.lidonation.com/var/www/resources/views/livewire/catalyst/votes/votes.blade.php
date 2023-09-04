<div class="relative z-10">
    @livewire('catalyst.catalyst-sub-menu-component')

    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class="z-10 flex flex-col block gap-3 sm:flex-row">
                <span class='z-10 font-light'>{{ $snippets->cardano }}</span>
                <span class='z-10 font-black text-teal-600'>
                    CCV4 Results
                </span>
            </span>
        </x-slot>
        <h4 class="pr-16 font-medium">
            Vote took place at dripdropz.io/vote/3.
            Transactions from Ballot
            <a target="_blank" class="break-all" href="https://cexplorer.io/asset/asset15wtaq65f2zas26z8u65hwsejy4c2ax4c3gy5uw">
                asset15wtaq65f2zas26z8u65hwsejy4c2ax4c3gy5uw
            </a>
            was scanned and put into a relational database to generate these analysis and reports.
        </h4>
    </x-public.page-header>

    <section class="relative bg-gray-100">
        <div class="container py-8">
            <div class="grid h-full grid-cols-1 grid-rows-1 gap-4 lg:grid-cols-2 xl:grid-cols-4 xl:grid-rows-5">
                <div class="col-span-1 row-span-5 p-3 bg-white lg:col-span-2 round-sm">
                    <div class="relative mb-2 text-gray-600">
                        <h2 class="mb-0 xl:text-3xl">
                            Results by <strong class="font-semibold">₳Ada Power</strong>
                        </h2>
                        <p class="text-sm">
                            Wallet balance at the end of epoch 379. Took two hours to complete snapshot.
                        </p>
                        <span class="bg-teal-500 rounded-sm py-0.5 px-1.5 text-white text-xs absolute right-0 top-1">
                            {{$totalAdaParticipation}}
                        </span>
                    </div>
                    <div class="relative w-full mt-auto">
                        @if($this->totalResultsByAda)
                            <ul role="list" class="max-h-[28rem] xl:max-h-[40rem] overflow-y-auto flex flex-col gap-2">
                                @foreach($this->totalResultsByAda as $candidate)
                                    <li class="border border-slate-200 {{$loop->index < 5 ? 'nominated' : ''}}">
                                        <a href="/project-catalyst/votes/ccv4/candidate/{{$candidate->candidate}}"
                                           class="relative flex items-center gap-2 p-3 hover:bg-gray-50"
                                           target="_blank">
                                            <div
                                                class="absolute left-0 flex items-center justify-center w-10 h-full rounded-r-full bg-slate-100">
                                                <span>{{$loop->iteration}}</span>
                                            </div>
                                            <div class="flex items-center flex-1 min-w-0 pl-10">
                                                <div class="flex-1 w-full">
                                                    <div>
                                                        <label for="candidate-{{$candidate->candidate}}"
                                                               class="flex items-center gap-2 font-medium text-gray-600 truncate pointer-events-none text-md: md:text-lg">
                                                            <span>
                                                                {{$candidate?->name}}
                                                            </span>
                                                            <span
                                                                class="{{$loop->index < 5 ? 'bg-teal-500' : 'bg-slate-500'}} rounded-sm py-0.5 px-1.5 text-white text-xs">
                                                                {{$candidate?->ada}}
                                                            </span>
                                                        </label>
                                                        <input
                                                            style="background-size: {{$candidate->lovelaces/$totalLovelaceParticipation * 100}}% 100%;"
                                                            id="candidate-{{$candidate->candidate}}" type="range"
                                                            min="0" max="{{$totalLovelaceParticipation}}"
                                                            value="{{$candidate->lovelaces}}"
                                                            class="flex-1 w-full h-4 text-yellow-500 rounded-sm appearance-none cursor-pointer bg-slate-200 dark:bg-slate-600">
                                                    </div>
                                                </div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor"
                                                 class="absolute w-4 h-4 text-gray-300 right-2 top-2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                            </svg>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="col-span-1 row-span-5 p-3 bg-white lg:col-span-2 round-sm">
                    <div class="relative mb-2 text-gray-600">
                        <h2 class="mb-0 xl:text-3xl">
                            Results by <strong class="font-semibold">1 stake key 1 Vote</strong>
                        </h2>
                        <p class="text-sm">
                            Users could vote with as many staked addressed with 5 ada or more at the end of epoch 379. 5
                            votes per address, 1 for each of the 5 seats available.
                        </p>
                        <span class="bg-teal-500 rounded-sm py-0.5 px-1.5 text-white text-xs absolute right-0 top-1">
                            {{$totalVoters}}
                        </span>
                    </div>
                    <div class="relative w-full mt-auto">
                        @if($this->totalResultsByVotes)
                            <ul role="list" class="max-h-[28rem] xl:max-h-[40rem] overflow-y-auto flex flex-col gap-2">
                                @foreach($this->totalResultsByVotes as $candidate)
                                    <li class="border border-slate-200 {{$loop->index < 5 ? 'nominated' : ''}}">
                                        <a href="/project-catalyst/votes/ccv4/candidate/{{$candidate->candidate}}"
                                           class="relative flex items-center gap-2 p-3 hover:bg-gray-50"
                                           target="_blank">
                                            <div
                                                class="absolute left-0 flex items-center justify-center w-10 h-full rounded-r-full bg-slate-100">
                                                <span>{{$loop->iteration}}</span>
                                            </div>
                                            <div class="flex items-center flex-1 min-w-0 pl-10">
                                                <div class="flex-1 w-full">
                                                    <div>
                                                        <label for="candidate-{{$candidate->candidate}}"
                                                               class="flex items-center gap-2 font-medium text-gray-600 truncate pointer-events-none text-md: md:text-lg">
                                                            <span>
                                                                {{$candidate?->name}}
                                                            </span>
                                                            <span
                                                                class="{{$loop->index < 5 ? 'bg-teal-500' : 'bg-slate-500'}} rounded-sm py-0.5 px-1.5 text-white text-sm">
                                                                {{$candidate?->votes}}
                                                            </span>
                                                        </label>
                                                        <input
                                                            style="background-size: {{$candidate->votes/$totalVoters * 100}}% 100%;"
                                                            id="candidate-{{$candidate->candidate}}" type="range"
                                                            min="0" max="{{$totalVoters}}" value="{{$candidate->votes}}"
                                                            class="flex-1 w-full h-4 text-yellow-500 rounded-sm appearance-none cursor-pointer bg-slate-200 dark:bg-slate-600">
                                                    </div>
                                                </div>
                                            </div>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor"
                                                 class="absolute w-4 h-4 text-gray-300 right-2 top-2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                            </svg>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="col-span-1 row-span-5 p-4 bg-white lg:col-span-2 xl:col-span-4 round-sm">
                    <div class="col-span-4 flex flex-col gap-4 xl:pr-4 max-h-[40rem]  xl:max-h-[48rem] overflow-y-auto">
                        <div>
                            <h2 class="mb-2 text-xl xl:text-4xl 2xl:text-5xl">
                                <span class="z-10 flex flex-col block gap-3 sm:flex-row">
                                    <span class='z-10 font-light'>About the</span>
                                    <span class='z-10 font-black text-teal-600'>
                                        Data
                                    </span>
                                </span>
                                <span class="block text-lg font-medium text-slate-500">
                                    This is how the cookie crumbles
                                </span>
                            </h2>
                        </div>
                        <div class="flex flex-col gap-8">
                            <div>
                                <h4 class="font-semibold">
                                    About the vote
                                </h4>
                                <p class="text-slate-500 text-md">
                                    Voting for the project catalyst circle v4 was facilitated by the Dripdropz platform and team.
                                    Anyone with 5 or more ada in a staked walled at the end of Epoch 379 could register and vote during epochs 380 and 381.
                                </p>
                                <p class="text-slate-500 text-md">
                                    All registrations was recorded on chain by minting a NFT using policy
                                    <a target="_blank" href="https://cexplorer.io/policy/7aad3b2761c23870068b95ff3129d13d879542e8d2a9ff0b46284c86" class="break-all">
                                        7aad3b2761c23870068b95ff3129d13d879542e8d2a9ff0b46284c86
                                    </a>.
                                </p>
                                <p class="text-slate-500 text-md">
                                    Successful ballot submissions were recording by burning the registration token and minting a Ballot token under policy
                                    <a target="_blank" href="https://cexplorer.io/policy/c40fe3d8d97b3af86a3bbfa7dfa41ca2be2a82a5d91e4b8db7cc60c5" class="break-all">
                                        c40fe3d8d97b3af86a3bbfa7dfa41ca2be2a82a5d91e4b8db7cc60c5
                                    </a>.
                                </p>
                            </div>

                            <div>
                                <h4 class="font-semibold">
                                    Compiling our data
                                </h4>
                                <div class="text-slate-500 text-md">
                                    <p class="text-slate-500 text-md">
                                        Voting for the project catalyst circle v4 was facilitated by the Dripdropz platform and team.
                                        Anyone with 5 or more ada in a staked walled at the end of Epoch 379 could register and vote during epochs 380 and 381.
                                    </p>
                                    <p class="text-slate-500 text-md">
                                        To generate the reports and charts on this dashboard we start by querying blockfrost for all transactions associated with the Ballot
                                        <a target="_blank" href="https://cexplorer.io/policy/c40fe3d8d97b3af86a3bbfa7dfa41ca2be2a82a5d91e4b8db7cc60c5" class="break-all">
                                            Ballot
                                        </a>
                                        policy id.
                                    </p>
                                    <p class="text-slate-500 text-md">
                                        Then we save data about the transaction and data in the metadata to our database.
                                    </p>
                                </div>
                                <div class="w-full overflow-x-auto" style="background-color: #212121">
                                    <div>
                                        <img class="w-full h-auto min-w-full" alt="ccv4 data fetch snippet" src="{{asset('img/ccv4-data-fetch-snippet.png')}}" />
                                    </div>
                                    {{--<x-markdown class="w-full p-4 overflow-x-auto">--}}
                                    {{--```php--}}
                                    {{--$page = 1;--}}
                                    {{--do {--}}
                                    {{--    $ballots = $cardanoBlockfrostService->get(--}}
                                    {{--        "/assets/c40fe3d8d97b3af86a3bbfa7dfa41ca2be2a82a5d91e4b8db7cc60c542616c6c6f74/transactions",--}}
                                    {{--        ['count' => 30,--}}
                                    {{--        'page' => $page--}}
                                    {{--    ])->collect();--}}

                                    {{--    $ballots->each(fn($ballot) => RecordCcv4BallotsJob::dispatch(--}}
                                    {{--        $ballot['tx_hash'],--}}
                                    {{--        $ballot['block_height'],--}}
                                    {{--        $ballot['block_time']--}}
                                    {{--    ));--}}
                                    {{--    $page++;--}}
                                    {{--    sleep(10);--}}
                                    {{--} while ($ballots->isNotEmpty());--}}
                                    {{--```--}}
                                    {{--</x-markdown>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-8">
                        <x-public.divider />
                    </div>
                    <div class="w-full mt-4 rounded-sm">
                        <h4 class="mb-4 text-2xl font-medium text-center xl:text-4xl text-slate-400">
                            Data Sources
                        </h4>
                        <ul class="flex flex-wrap justify-center gap-4 p-0 m-0 mb-4">
                            <li>
                                <a href="//cexplorer.io/policy/7aad3b2761c23870068b95ff3129d13d879542e8d2a9ff0b46284c86"
                                   target="_blank" class="flex items-center justify-between block w-full gap-4 p-3 font-thin border rounded-sm text-slate-600 border-slate-400 hover:border-teal-600 text-md">
                                    <span>On Chain Registrations</span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                          <path fill-rule="evenodd" d="M15.75 2.25H21a.75.75 0 01.75.75v5.25a.75.75 0 01-1.5 0V4.81L8.03 17.03a.75.75 0 01-1.06-1.06L19.19 3.75h-3.44a.75.75 0 010-1.5zm-10.5 4.5a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V10.5a.75.75 0 011.5 0v8.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V8.25a3 3 0 013-3h8.25a.75.75 0 010 1.5H5.25z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" class="flex items-center justify-between block w-full gap-4 p-3 font-thin border rounded-sm text-slate-600 border-slate-400 hover:border-teal-600 text-md"
                                   href="//cexplorer.io/policy/c40fe3d8d97b3af86a3bbfa7dfa41ca2be2a82a5d91e4b8db7cc60c5/mint#data" >
                                    <span>On Chain Ballots</span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                          <path fill-rule="evenodd" d="M15.75 2.25H21a.75.75 0 01.75.75v5.25a.75.75 0 01-1.5 0V4.81L8.03 17.03a.75.75 0 01-1.06-1.06L19.19 3.75h-3.44a.75.75 0 010-1.5zm-10.5 4.5a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V10.5a.75.75 0 011.5 0v8.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V8.25a3 3 0 013-3h8.25a.75.75 0 010 1.5H5.25z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="https://ncdb.lidonation.com/dashboard/#/base/964a631e-5239-43cc-be8c-8f72c61d3d17/table/Ccv4BallotChoices"
                                   target="_blank" class="flex items-center justify-between block w-full gap-4 p-3 font-thin border rounded-sm text-slate-600 border-slate-400 hover:border-teal-600 text-md">
                                    <span>LIDO Raw DB Table</span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                          <path fill-rule="evenodd" d="M15.75 2.25H21a.75.75 0 01.75.75v5.25a.75.75 0 01-1.5 0V4.81L8.03 17.03a.75.75 0 01-1.06-1.06L19.19 3.75h-3.44a.75.75 0 010-1.5zm-10.5 4.5a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V10.5a.75.75 0 011.5 0v8.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V8.25a3 3 0 013-3h8.25a.75.75 0 010 1.5H5.25z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="relative col-span-1 row-span-2 p-3 bg-teal-700 lg:col-span-2 round-sm">
                    <div class="flex flex-row flex-wrap items-start justify-between h-full md:flex-nowrap">
                        <div>
                            <dl class="flex flex-col justify-between">
                                <dd>
                                    <div class="text-xl font-semibold text-white lg:text-3xl 2xl:text-4xl">
                                        {{$totalVoters}}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
                                    Total Staked Addresses
                                </dt>
                            </dl>
                        </div>

                        <div class="ml-auto md:mt-auto">
                            <dl class="flex flex-col justify-between text-right">
                                <dd>
                                    <div class="text-2xl font-semibold text-white lg:text-4xl 2xl:text-5xl">
                                        {{$totalAbstainedVoters}}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
                                    Addresses Abstained
                                </dt>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="relative col-span-1 row-span-2 p-3 bg-blue-dark-500 lg:col-span-2 round-sm">
                    <div class="flex flex-row flex-wrap items-start justify-between h-full md:flex-nowrap">
                        <div>
                            <dl class="flex flex-col justify-between">
                                <dd>
                                    <div class="text-xl font-semibold text-white lg:text-3xl 2xl:text-4xl">
                                        ₳{{$totalAdaBallotPower}}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
                                    Combined Total Ballot Power
                                </dt>
                            </dl>
                        </div>

                        <div class="ml-auto md:mt-auto">
                            <dl class="flex flex-col justify-between text-right">
                                <dd>
                                    <div class="text-2xl font-semibold text-white lg:text-4xl 2xl:text-5xl">
                                        ₳{{$totalAdaParticipation}}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
                                    Actual Total Ada
                                </dt>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="relative col-span-1 row-span-1 row-span-2 px-3 py-5 bg-white lg:col-span-2 round-sm">
                    <div class="relative mb-2 text-gray-600">
                        <h2 class="mb-0 xl:text-3xl">
                           <strong class="font-semibold text-teal-600">1 stake key 1 Vote</strong> Ranges
                        </h2>
                        <p class="text-sm">
                            Ranges of Wallet balance at the end of epoch 379. Took two hours to complete snapshot.  Excludes Abstained wallets.
                        </p>
                    </div>
                    <x-catalyst.reports.chart-pie
                        :labels="$adaPowerRanges?->keys()"
                        :data="$adaPowerRanges?->pluck(0)"
                        chartName="allTimeFundedPerRound"></x-catalyst.reports.chart-pie>
                </div>

                <div class="bg-white relative px-3 py-5 col-span-1 lg:col-span-2 row-span-1 row-span-2 round-sm max-h-[28rem] xl:max-h-[50rem] 2xl:max-h-[52rem] overflow-y-auto ">
                    <div class="relative mb-2 text-gray-600">
                        <h2 class="mb-0 xl:text-3xl">
                            <strong class="font-semibold">Wallet Voting Ada Power</strong> Breakdowns
                        </h2>
                        <p class="text-sm">
                            Ranges of Wallet balance at the end of epoch 379. Took two hours to complete snapshot. Excludes Abstained wallets.
                        </p>
                    </div>
                    <div>
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($this->adaPowerRanges as $range => $value)
                                <li class="flex items-center justify-start w-full gap-4 py-4">
                                    <div class="flex items-center justify-center w-20 h-20 p-2 text-center rounded-full bg-slate-300">
                                        <span class="text-base">{{$range}} ₳</span>
                                    </div>

                                    <div class="">
                                        <p class="text-lg lg:text-xl xl:text-2xl 2xl:text-3xl text-slate-500">
                                            {{$value['0']}} <span class="text-slate-300 text-md lg:text-lg xl:text-2xl 2xl:text-2xl">Wallets</span>
                                        </p>
                                    </div>

                                    <div class="pr-2 ml-auto">
                                        <p class="text-md lg:text-lg xl:text-2xl text-slate-500">
                                            <span class="mr-2 text-slate-400">₳</span>{{ humanNumber($value['1'], 2)}}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="relative col-span-1 row-span-1 px-3 py-5 bg-white lg:col-span-2 round-sm">
                    <h2 class="py-2 mb-4 text-lg text-center lg:text-xl xl:text-3xl 2xl:text-4xl text-slate-400">
                        Stake addresses that voted for
                    </h2>
                    <div class="grid grid-cols-2">
                        <div class="relative col-span-2 row-span-1 px-3 py-5 border border-white bg-blue-dark-500 round-sm">
                            <dl class="flex flex-col justify-between h-full text-center text-white">
                                <dd>
                                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                                        {{$this->totalCandidatesPerVoter['candidates5']}}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium truncate">
                                    All five candidates
                                </dt>
                            </dl>
                        </div>
                        <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-900 border border-white round-sm">
                            <dl class="flex flex-col justify-between h-full text-white">
                                <dd>
                                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                                        {{$this->totalCandidatesPerVoter['candidates4']}}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium truncate">
                                    Only four candidates
                                </dt>
                            </dl>
                        </div>
                        <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-700 border border-white round-sm">
                            <dl class="flex flex-col justify-between h-full">
                                <dd>
                                    <div class="text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                                        {{$this->totalCandidatesPerVoter['candidates3']}}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium truncate text-slate-200">
                                    Only three candidates
                                </dt>
                            </dl>
                        </div>
                        <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-500 border border-white round-sm">
                            <dl class="flex flex-col justify-between h-full">
                                <dd>
                                    <div class="text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                                        {{$this->totalCandidatesPerVoter['candidates2']}}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
                                    Only two candidates
                                </dt>
                            </dl>
                        </div>
                        <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-800 border border-white round-sm">
                            <dl class="flex flex-col justify-between h-full">
                                <dd>
                                    <div class="text-4xl font-semibold text-white lg:text-5xl 2xl:text-6xl">
                                        {{$this->totalCandidatesPerVoter['candidates1']}}
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium text-gray-200 truncate">
                                    Only one candidate
                                </dt>
                            </dl>
                        </div>
                        <div class="relative col-span-2 row-span-1 px-3 py-5 bg-teal-900 border border-white round-sm">
                            <dl class="flex flex-col justify-between h-full text-center text-white">
                                <dd>
                                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                                        Coming Soon
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium truncate">
                                    Registered but didn't vote
                                </dt>
                            </dl>
                        </div>
                        <div class="relative col-span-2 row-span-1 px-3 py-5 border border-white bg-teal-light-700 round-sm">
                            <dl class="flex flex-col justify-between h-full text-center text-white">
                                <dd>
                                    <div class="text-4xl font-semibold lg:text-5xl 2xl:text-6xl">
                                        Coming Soon
                                    </div>
                                </dd>
                                <dt class="mt-3 text-lg font-medium truncate">
                                    Delegated their vote
                                </dt>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="relative col-span-1 row-span-1 row-span-2 px-3 py-5 bg-white lg:col-span-2 round-sm">
                    <div class="relative mb-2 text-gray-600">
                        <h2 class="mb-0 xl:text-3xl">
                            <strong class="font-semibold text-teal-600">Ada Power</strong> Ranges
                        </h2>
                        <p class="text-sm">
                            Ranges of Ada Voting power, excludes abstained wallets.
                        </p>
                    </div>
                    <x-catalyst.reports.chart-pie
                        :labels="$adaPowerRanges?->keys()"
                        :data="$adaPowerRanges?->pluck(1)"
                        chartName="allTimeFundedPerRound"></x-catalyst.reports.chart-pie>
                </div>
            </div>
        </div>
    </section>

    <div></div>
</div>
