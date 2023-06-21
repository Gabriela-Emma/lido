<div class="relative z-10">
    @livewire('catalyst.catalyst-sub-menu-component')

    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class="z-10 flex flex-col block gap-3 sm:flex-row">
                <span class='z-10 font-light'>{{ $snippets->catalyst }}</span>
                <span class='z-10 font-black text-teal-600'>
                    {{ $snippets->funds }}
                </span>
            </span>
        </x-slot>
        <h2 class="font-medium">
            {{ $snippets->prePayingForFutureInnovations }}
        </h2>
    </x-public.page-header>

    <section class="relative py-8 text-white bg-teal-600 text-md">
        <div class="container">
            <div class="flex flex-row items-center gap-4">
                <div class="flex flex-col max-w-sm p-2">
                    <dt class="order-2 text-xs font-medium md:text-sm text-teal-50">
                        {{__('Total Funds')}}
                    </dt>
                    <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                        {{$catalystFundsCount}}
                    </dd>
                </div>
                <div class="flex flex-col max-w-sm p-2">
                    <dt class="order-2 text-xs font-medium md:text-sm text-teal-50">
                        {{__('Total Proposals')}}
                    </dt>
                    <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                        {{$totalProposalsCount}}
                    </dd>
                </div>
                <div class="flex flex-col max-w-sm p-2">
                    <dt class="order-2 text-xs font-medium md:text-sm text-teal-50">
                        {{__('Funded Proposals')}}
                    </dt>
                    <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                        {{$fundedProposalsCount}}
                    </dd>
                </div>
                {{-- completed proposals --}}
                <div class="flex flex-col max-w-sm p-2">
                    <dt class="order-2 text-xs font-medium md:text-sm text-teal-50">
                        {{__('Completed Proposals')}}
                    </dt>
                    <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                        {{$completedProposalsCount}}
                    </dd>
                </div>
                {{--  --}}
                <div class="flex flex-col max-w-sm p-2">
                    <dt class="order-2 text-xs font-medium md:text-sm text-teal-50">
                        {{__('Total $$ Requested')}}
                    </dt>
                    <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                        ${{humanNumber($totalAmountRequested)}}
                    </dd>
                </div>
                <div class="flex flex-col max-w-sm p-2">
                    <dt class="order-2 text-xs font-medium md:text-sm text-teal-50">
                        {{__('Total $$ Awarded')}}
                    </dt>
                    <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                        ${{humanNumber($totalAmountAwarded)}}
                    </dd>
                </div>
                <div class="flex flex-col max-w-sm p-2">
                    <dt class="order-2 text-xs font-medium md:text-sm text-teal-50">
                        {{__('Total $$ Distributed')}}
                    </dt>
                    <dd class="order-1 text-xl font-extrabold text-white lg:text-xl 2xl:text-3xl">
                        ${{humanNumber($totalAmountDistributed)}}
                    </dd>
                </div>
            </div>
        </div>
    </section>

    <section class="relative py-16 bg-white">
        <div class="container">
            <div class="space-y-12">
                <ul role="list"
                    class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 2xl:grid-cols-4 lg:gap-6">
                    @foreach($catalystFunds as $fund)
                        <li class="flex flex-row justify-center px-6 py-8 text-center rounded-sm bg-primary-10 xl:px-8 xl:text-left">
                            <div class="flex flex-col justify-between w-full space-y-6 xl:space-y-10">
                                <a href="{{$fund->link}}"
                                   class="w-32 h-32 mx-auto rounded-full shadow-md shadow-inner lg:w-32 lg:h-32 xl:w-44 xl:h-44">
                                    <img class="w-full h-full rounded-full"
                                         src="{{$fund->thumbnail_url ?? $fund->gravatar}}"
                                         alt="{{$fund->name}} logo"/>
                                </a>
                                <div class="items-end w-full space-y-2 xl:flex xl:items-center xl:justify-between">
                                    <div class="w-full space-y-1 text-lg font-medium leading-6">
                                        <h2 class="mb-2">
                                            <a href="{{$fund->link}}"
                                               class="text-gray-800 hover:text-teal-700">
                                                {{$fund->label}}
                                            </a>
                                        </h2>
                                        <div class="flex flex-row items-start justify-between w-full gap-2">
                                            <div class="flex flex-col justify-center gap2 itemscenter">
                                                <span class="text-lg font-semibold text-gray-600">
                                                    {{$fund->currency_symbol}} {{humanNumber($fund->proposals_amount_requested)}}
                                                </span>
                                                <span class="text-xs text-gray-500">Total <br />Awarded</span>
                                            </div>
                                            <div class="flex flex-col justify-center gap2 itemscenter">
                                                <span class="text-lg font-semibold text-gray-600">
                                                    {{humanNumber($fund->funded_proposals_count)}}
                                                </span>
                                                <span class="text-xs text-gray-500">Projects <br />Funded</span>
                                            </div>
                                            <div class="flex flex-col justify-center gap2 itemscenter">
                                                <span class="text-lg font-semibold text-gray-600">
                                                    <x-carbon :date="$fund->launched_at" format="y/m/d" />
                                                </span>
                                                <span class="text-xs text-gray-500">Launched</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-6 paginator ">
                {{ $this->getPaginator()?->links() }}
            </div>
        </div>
    </section>

    {{-- @if($quickPitches)
        <section id="catalystVoting" class="text-white bg-gradient-to-br from-teal-800 via-teal-600 to-accent-900">
            <div class="container">
                <x-catalyst.ballot-quick-pitches :proposals="$quickPitches" />
            </div>
        </section>
        <section class="relative border rounded-sm bg-slate-50">
            <div class="px-3 py-3 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="pr-16 sm:px-16 sm:text-center">
                    <p class="font-medium text-slate-400">
                        <span>
                            Are you a proposer? Link your
                        </span>
                        <span class="block sm:ml-2 sm:inline-block">
                          <a href="{{$settings->quick_pitch_link}}"
                             target="_blank"
                             class="flex flex-row items-center gap-2 font-semibold underline">
                            <span>quickpitch</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                          </a>
                        </span>
                    </p>
                </div>
            </div>
        </section>
    @endif --}}
</div>
