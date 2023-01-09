<x-public-layout class="catalyst-user" :metaTitle="$catalystUser->name">
    @livewire('catalyst.catalyst-sub-menu-component')
    <header class="text-white bg-teal-600">
        <div class="container">
            <section class="relative z-0 py-10 overflow-visible">
                <h1 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate light'>
                    <img class="w-10 h-10 rounded-full lg:w-16 lg:h-16"
                         src="{{$catalystUser->thumbnail_url ?? $catalystUser->gravatar}}"
                         alt="{{$catalystUser->name}} gravatar" />

                    <span class="font-semibold">
                        {{$catalystUser->name}}
                    </span>

                    @foreach($catalystUser->groups as $group)
                        <a type="button"
                           href="{{$group->url}}"
                           class="inline-flex items-center gap-1 py-1 px-2 border border-transparent text-xs font-semibold rounded-sm text-blue-dark-500 bg-teal-light-500 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{$group->name}}
                        </a>
                    @endforeach
                </h1>

                <div class="summary">
                    <h2 class="relative">
                        Bio
                    </h2>
                    <div class="max-w-5xl mt-2">
                        @if($catalystUser->bio)
                            <x-markdown>{{$catalystUser->bio}}</x-markdown>
                        @else
                            <p>Missing Bio</p>
                        @endif
                    </div>
                </div>

                <div class="p-6 mt-6 bg-opacity-95 rounded-sm bg-teal-light-500 text-blue-dark-500">
                    @livewire('catalyst.catalyst-proposer-metrics-component')
                </div>
            </section>
        </div>
    </header>

    <section
        class="relative py-10 overflow-visible bg-white bg-left-bottom bg-repeat-y bg-contain bg-opacity-90 bg-blend-color-burn lg:py-20 bg-pool-bw-light">
        <div class="container">
            <h2 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate dark'>
                {{$catalystUser->name}} <span class="text-teal-600">Proposals</span>
                <span class="text-gray-500 2xl:text-4xl">({{$userProposals->total()}})</span>
            </h2>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3">
                @foreach($userProposals as $proposal)
                    <div wire:key="{{$proposal->id}}">
                        @if($proposal->type=='challenge')
                            <x-catalyst.challenges.drip  :challenge="$proposal" />
                        @else
                            <x-catalyst.proposals.drip :proposal="$proposal" />
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center mt-8">
                {{ $userProposals?->links() }}
            </div>
        </div>
    </section>

    @if($catalystUser->monthly_reports->sortBy('proposal_id'))
        <section class="px-4 bg-slate-100 round-sm py-8" id="monthly-reports-wrapper">
            <h2 class="text-center my-2 text-teal-800 2xl:text-5xl">Monthly Reports</h2>
            <div class="mt-6 columns-1 sm:columns-2 xl:columns-3 gap-4 monthly-reports">
                @foreach($catalystUser->monthly_reports as $report)
                    <x-catalyst.reports.drip wire:key="{{$report->id}}" :report="$report" />
                @endforeach
            </div>
        </section>
    @endif
</x-public-layout>
