<div class="relative z-10">
    @livewire('catalyst.catalyst-sub-menu-component')

    <header class="text-white bg-teal-600">
        <div class="container">
            <section class="relative z-0 py-10 overflow-visible">
                <h1 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate light'>
                    <img class="w-10 h-10 rounded-sm lg:w-16 lg:h-16"
                         src="{{$fund->hero_url}}"
                         alt="{{$fund->label}} gravatar"/>

                    <span class="font-semibold">
                        {{$fund->label}}
                    </span>
                </h1>

                {{--                <div class="my-4 summary">--}}
                {{--                    <div class="max-w-4xl font-semibold">--}}
                {{--                        Charts and Reports coming soon--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </section>
        </div>
    </header>

    <section class="relative py-8 text-white bg-teal-600 text-md">
        <div class="container">
            <div class="flex flex-row flex-wrap justify-start">
                <div
                    class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                    <div
                        class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                        <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                            <span class="font-semibold">
                                {{$totalProposalsCount}}
                            </span>
                        </div>
                        <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                {{__('Total Proposals')}}
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                    <div
                        class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                        <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                            <span class="font-semibold">
                                {{$fundedProposalsCount}}
                            </span>
                        </div>
                        <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                {{__('Funded Proposals')}}
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                    <div
                        class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                        <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                            <span class="font-semibold">
                                {{$completedProposalsCount}}
                            </span>
                        </div>
                        <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                {{__('Completed Proposals')}}
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                    <div
                        class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                        <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                            <span class="font-semibold">
                                {{$fund->currency_symbol}}{{humanNumber($totalAmountRequested)}}
                            </span>
                        </div>
                        <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                {{__('Total Requested')}}
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                    <div
                        class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                        <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                            <span class="font-semibold">
                                {{$fund->currency_symbol}}{{humanNumber($totalAmountAwarded)}}
                            </span>
                        </div>
                        <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                            <span>
                                {{__('Total Awarded')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section
        class="relative py-10 overflow-visible bg-white bg-left-bottom bg-repeat-y bg-contain bg-opacity-90 bg-blend-color-burn lg:py-20 bg-pool-bw-light">
        <div class="container">
            <h2 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate dark'>
                {{$fund->label}} <span class="text-teal-600">Challenges</span>
                <span class="text-gray-500 2xl:text-4xl">({{$this->getPaginator()->total()}})</span>
            </h2>

            <div class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 2xl:grid-cols-4 lg:gap-6">
                @foreach($challenges as $challenge)
                    <x-catalyst.funds.drip :fund="$challenge"/>
                @endforeach
            </div>

            <div class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 2xl:grid-cols-4 lg:gap-6">
                {{ $this->getPaginator()->onEachSide(5)->links() }}
            </div>
        </div>
    </section>

    {{-- Catalyst Voting --}}
    @if($quickPitches)
        <section id="catalystVoting" class="text-white bg-gradient-to-br from-primary-800 via-primary-600 to-accent-900">
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
    @endif
</div>
