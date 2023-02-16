<x-public-layout class="catalyst-group" :metaTitle="$catalystGroup->name">
    @livewire('catalyst.catalyst-sub-menu-component')
    <header class="text-white bg-teal-600">
        <div class="container">
            <section class="relative z-0 py-10 overflow-visible"
                     x-data="{showPane: false,
                claimingUser: false,
                claimProfile: function() {
                    axios.get('/api/user')
                    .then(function(response) {
                        this.$dispatch('claim-user');
                    }.bind(this))
                    .catch(function(error) {
                        window.location.href = '/login';
                    });
                }
            }"
                     @claim-user.window="claimingUser = !claimingUser">
                <div class="z-6 absolute top-0 left-0 w-full h-full bg-teal-600/75 py-10" x-show="claimingUser"
                     x-transition>
                    <x-catalyst.claim-user :catalystProfile="$catalystGroup->members->first()"
                                           :owner="$catalystGroup->user_id"/>
                </div>

                <div class="absolute left-0 top-0" :class="{
                    'bg-teal-600 w-full h-full z-5': claimingUser,
                    'hidden': !claimingUser}"></div>

                <div class="bg-teal-600/[0.95] w-full h-full absolute z-30 space-y-4" x-show="showPane" x-transition>
                    <div class="flex flex-row justify-between gap-3 items-center">
                        <h2 class="xl:text-5xl">
                            How is this data calculated?
                        </h2>

                        <button
                            @click="showPane = !showPane"
                            type="button"
                            class="inline-flex items-center border px-4 py-1.5 border gap-1 text-md font-medium rounded-xs bg-transparent hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                        >
                            Close
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>

                    <div class="text-xl xl:text-2xl 2xl:text-3xl">
                        <b class="text-3xl mb-2">Two Simple Steps:</b>

                        <ol class="list-decimal flex flex-col gap-4 list-inside">
                            <li class="list-item">
                                A human at Lido Nation manually comb through proposals 2 identify <b>core</b> members of
                                a group. People
                                denoted as such are listed on the group page.
                            </li>
                            <li class="list-item">
                                For these <b>core</b> member, a script finds all the proposals for which they are the
                                primary author & attribute that proposal to the group.
                            </li>
                        </ol>
                    </div>

                    <div class="text-center pt-10">
                        <p>
                            Despite our best efforts to maintain the accuracy of the information presented here,
                            inconsistencies may exist.
                        </p>
                        <p>Questions or feedback about this data?</p>
                        <a class="text-teal-500" href="{{localizeRoute('community')}}#send-a-message">Send us a
                            message </a>
                    </div>
                </div>


                <h1 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate light'>
                    <img class="w-16 h-16 rounded-full lg:w-20 lg:h-20 object-cover object-center"
                         src="{{$catalystGroup->thumbnail_url ?? $catalystGroup->gravatar}}"
                         alt="{{$catalystGroup->name}} gravatar"/>

                    <span class="font-semibold">
                        {{$catalystGroup->name}}
                    </span>

                    @if(!$catalystGroup->claimed_by)
                        <a href="#" x-data @click.prevent="claimProfile"
                           class="inline-flex flex-row gap-1 text-sm cursor-pointer items-center group font-semibold hover:text-teal-800 hover:text-slate-800 whitespace-nowrap px-1 py-0.5 bg-yellow-500 border border-yellow-800 rounded-sm">
                        <span class="group-hover:text-slate-800 inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/>
                            </svg>
                        </span>
                            <span class="group-hover:text-slate-800">
                            Claim Account
                        </span>
                        </a>
                    @else
                        <span type="button"
                              class="inline-flex items-center gap-1 py-[0.280rem] rounded-sm bg-indigo-100 px-1.5 text-xs font-semibold text-indigo-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-4 h-4 mr-0.5">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>
                            </svg>
                            Claimed
                      </span>
                    @endif

                    <span @click="showPane = !showPane"
                          class="ml-auto relative top-10 text-base hover:cursor-pointer text-blue-dark-500 hover:text-yellow-500 font-semibold">
                        How is this data calculated?
                    </span>
                </h1>

                <div class="summary">
                    <h2 class="relative">
                        Bio
                    </h2>
                    <div class="max-w-4xl mt-2">
                        @if($catalystGroup->bio)
                            <x-markdown>{{$catalystGroup->bio}}</x-markdown>
                        @else
                            <p>Missing Bio</p>
                        @endif
                    </div>
                </div>

                <div class="p-6 mt-6 bg-opacity-95 rounded-sm bg-teal-light-500 text-blue-dark-500">
                    <x-catalyst.users.profile-metrics
                        :catalystUser="$catalystGroup"
                        :allTimeCaAverage="$allTimeCaAverage"
                        :allTimeCaRatingCount="$allTimeCaRatingCount"
                        :allTimeCaAverageGroups="$allTimeCaAverageGroups"

                        :allTimeFundedPerRound="$allTimeFundedPerRound"
                        :allTimeFundingPerRound="$allTimeFundingPerRound"
                        :allTimeAwardedPerRound="$allTimeAwardedPerRound"
                        :allTimeReceivedPerRound="$allTimeReceivedPerRound"
                        :allTimeProposedPerRound="$allTimeProposedPerRound"
                        :allTimeCompletedPerRound="$allTimeCompletedPerRound"></x-catalyst.users.profile-metrics>
                </div>
            </section>
        </div>
    </header>

    <section class="bg-primary-10 py-16">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-3 grid-rows-1 xl:grid-cols-5 xl:grid-rows-4 gap-4 h-full">
                <div class="col-span-1 md:col-span-3 w-full relative bg-white p-3 row-span-4 round-sm z-10">
                    <div class="text-gray-600">
                        <h3 class="text-2xl xl:text-3xl mb-0">
                            Top of mind of {{$catalystGroup->name}} in Catalyst
                        </h3>
                        <p>most frequent words in proposal details</p>
                    </div>
                    <div class="relative w-full">
                        @if($wordCloudSet)
                            <x-catalyst.reports.chart-wordcloud
                                :labels="$wordCloudSet?->pluck('word')->toArray()"
                                :data="$wordCloudSet?->pluck('occurrences')->first() < 100 ? $wordCloudSet?->pluck('occurrences')->toArray() : $wordCloudSet?->pluck('occurrences')->map(fn($v)=>intval(intval($v)/12))->toArray()"
                                dataType="currency"></x-catalyst.reports.chart-wordcloud>
                        @endif
                    </div>
                </div>
                <div
                    class="col-span-1 md:col-span-3 xl:col-span-2 xl:row-span-4 p-4 w-full round-sm bg-white relativez-0pointer-events-none">
                    <h3 class="text-2xl xl:text-3xl mb-0">Challenges</h3>

                    <nav class="h-96 overflow-y-auto " aria-label="Directory">
                        <div class="relative">
                            <ul role="list" class="relative z-0 divide-y divide-gray-200">
                                @foreach($proposalChallenges as $challenge => $group)
                                    <li class="bg-white">
                                        <div
                                            class="relative py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-primary-500">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full"
                                                     src="{{$group->challenge->thumbnail_url}}"
                                                     alt="{{$challenge}} thumbnail">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="focus:outline-none">
                                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                                    <div class="text-lg font-medium text-gray-900">{{$challenge}}</div>
                                                    <div
                                                        class="text-sm text-gray-500 truncate">{{$group->proposals_count}}
                                                        Proposals
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </nav>

                </div>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container">
            <div class="mx-auto py-12 lg:py-24">
                <div class="space-y-12 lg:grid lg:grid-cols-4 lg:gap-8 lg:space-y-0">
                    <div class="space-y-5 sm:space-y-4">
                        <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                            The Team ({{$catalystGroup->members?->count()}})
                        </h2>
                        <p class="text-xl text-gray-500">
                            Members in Catalyst that have co-proposed with {{$catalystGroup->name}}.
                            Individuals may not be employed at {{$catalystGroup->name}}.
                            This is is is not representative of {{$catalystGroup->name}}'s full team.
                        </p>

                        @if($catalystGroup->members?->count() && $groupProposals->isNotEmpty())
                            <div
                                class="mt-6 flex flex-col justify-center items-center gap-4 follow-reports w-full bg-slate-200 p-4">
                                <p>
                                    Follow {{$catalystGroup->name}} monthly project reports to have them delivered to
                                    your inbox,
                                    <strong>for all {{$groupProposals->count()}} projects.</strong>
                                </p>
                                <p>
                                    Individual Projects can also be followed on project page.
                                </p>
                                <div class="rounded-md">
                                    <x-catalyst.follow-monthly-reports :model="$catalystGroup" filter="group"/>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="lg:col-span-3">
                        @if($catalystGroup->members?->isNotEmpty())
                            @if($catalystGroup->members->count() > 3)
                                <ul role="list"
                                    class="space-y-12 sm:grid sm:grid-cols-3 xl:grid-cols-5 2xl:grid-cols-6 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:gap-x-8">
                                    @foreach($catalystGroup->members->shuffle()->take(20) as $catalystUser)
                                        @if(! Str::of($catalystUser->name)->lower()->contains(Str::of($catalystGroup->name)->trim()->lower()) )
                                            <li>
                                                <div class="space-y-4">
                                                    <div class="aspect-w-4 aspect-h-3">
                                                        <img class="object-cover shadow-sm rounded-sm"
                                                             src="{{$catalystUser->thumbnail_url ?? $catalystUser->gravatar}}"
                                                             alt="">
                                                    </div>
                                                    <div class="text-lg leading-6 font-medium space-y-1">
                                                        <h4>
                                                            {{$catalystUser->name}}
                                                        </h4>
                                                        <p class="text-indigo-600">
                                                            {{--                                                Senior Front-end Developer--}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <ul role="list"
                                    class="space-y-12 sm:grid sm:grid-cols-2 xl:grid-cols-3 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:gap-x-8">
                                    @foreach($catalystGroup->members as $catalystUser)
                                        @if(! Str::of($catalystUser->name)->lower()->contains(Str::of($catalystGroup->name)->trim()->lower()) )
                                            <li>
                                                <div class="space-y-4">
                                                    <div class="aspect-w-4 aspect-h-3">
                                                        <img class="object-cover shadow-sm rounded-sm"
                                                             src="{{$catalystUser->thumbnail_url ?? $catalystUser->gravatar}}"
                                                             alt="">
                                                    </div>
                                                    <div class="text-lg leading-6 font-medium space-y-1">
                                                        <h3>
                                                            {{$catalystUser->name}}
                                                        </h3>
                                                        <p class="text-indigo-600">
                                                            {{--                                                Senior Front-end Developer--}}
                                                        </p>
                                                    </div>
                                                    <div class="text-lg text-gray-500">
                                                        @if($catalystUser->bio)
                                                            <x-markdown>{{$catalystUser->bio}}</x-markdown>
                                                        @else
                                                            <p>Missing Bio</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        @else
                            @if( $groupProposals->isNotEmpty())
                                <div
                                    class="mt-6 flex flex-col justify-center items-center gap-4 follow-reports w-full bg-slate-200 p-4">
                                    <p>
                                        Follow {{$catalystGroup->name}} monthly project reports to have them delivered
                                        to your inbox,
                                        <strong>for all {{$groupProposals->count()}} projects.</strong>
                                    </p>
                                    <p>
                                        Individual Projects can also be followed on project page.
                                    </p>
                                    <div class="rounded-md">
                                        <x-catalyst.follow-monthly-reports :model="$catalystGroup" filter="group"/>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($catalystGroup->challenges->isNotEmpty())
        <section
            class="relative py-10 overflow-visible bg-white bg-left-bottom bg-repeat-y bg-contain bg-opacity-90 bg-blend-color-burn lg:py-20 bg-pool-bw-light">
            <div class="container">
                <h2 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate dark'>
                    {{$catalystGroup->name}} <span class="text-teal-600">Challenges</span>
                    <span class="text-gray-500 2xl:text-4xl">({{$catalystGroup->challenges->count()}})</span>
                </h2>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3">
                    @foreach($catalystGroup->challenges as $challenge)
                        @if($challenge->type=='challenge')
                            <x-catalyst.challenges.drip wire:key="{{$challenge->id}}" :challenge="$challenge"/>
                        @else
                            <x-catalyst.proposals.drip wire:key="{{$challenge->id}}" :proposal="$challenge"/>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($groupProposals->isNotEmpty())
        <section
            class="relative py-10 overflow-visible bg-white bg-left-bottom bg-repeat-y bg-contain bg-opacity-90 bg-blend-color-burn lg:py-20 bg-pool-bw-light">
            <div class="container">
                <h2 class='flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate dark'>
                    {{$catalystGroup->name}} <span class="text-teal-600">Proposals</span>
                    <span class="text-gray-500 2xl:text-4xl">({{$groupProposals->total()}})</span>
                </h2>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3">
                    @foreach($groupProposals as $proposal)
                        @if($proposal->type=='challenge')
                            <x-catalyst.challenges.drip wire:key="{{$proposal->id}}" :challenge="$proposal"/>
                        @else
                            <x-catalyst.proposals.drip wire:key="{{$proposal->id}}" :proposal="$proposal"/>
                        @endif
                    @endforeach
                </div>
                <div class="flex justify-center mt-8">
                    {{ $groupProposals->links() }}
                </div>
            </div>

        </section>
    @endif


</x-public-layout>
