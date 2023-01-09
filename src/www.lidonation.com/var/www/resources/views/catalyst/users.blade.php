<x-public-layout class="catalyst-proposals-research-wrapper" title="Catalyst Builders">
    @livewire('catalyst.catalyst-sub-menu-component')
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class="z-20 flex flex-col block gap-3 sm:flex-row">
                <span class='z-20 font-light'>{{__('Cardano') }}</span>
                <span class='z-20 font-black text-teal-600'>{{__('Proposers') }}</span>
            </span>
        </x-slot>
        <h2 class="font-medium">
            {{ $snippets->prePayingForFutureInnovations}}
        </h2>

        @if($snippets)
            <x-markdown>{{$snippets[0]?->content}}</x-markdown>
        @endif
    </x-public.page-header>

    <section class="relative py-8 text-white bg-teal-600 text-md">
        <div class="container">
            <div class="flex flex-row items-center gap-4">
                <x-catalyst.users.stats
                    :usersCount="$catalystUsersCount"></x-catalyst.users.stats>
            </div>
        </div>
    </section>

    <section class="relative py-8 bg-scroll bg-gray-100 bg-center bg-cover bg-pool-bw-light bg-blend-hard-light"
             aria-labelledby="quick-links-title">
        <div class="container">
            <div class="bg-white shadow-sm">
                <div class="px-4 py-12 mx-auto text-center max-w-7xl sm:px-6 lg:px-8 lg:py-24">
                    <div class="space-y-8 sm:space-y-12">
                        <div class="space-y-5 sm:mx-auto sm:max-w-xl sm:space-y-4 lg:max-w-5xl">
                            <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                                {{ $snippets->proposers }}
                            </h2>
                            <p class="text-xl text-gray-500">
                                Diverse, independent, and together inspiring the highest level of human collaboration.
                            </p>
                        </div>
                        <ul role="list"
                            class="grid grid-cols-2 mx-auto gap-x-4 gap-y-8 sm:grid-cols-4 md:gap-x-6 lg:max-w-5xl lg:gap-x-8 lg:gap-y-12 xl:grid-cols-6">
                            @foreach($catalystUsers as $catalystUser)
                                <li wire:key="{{$catalystUser->id}}">
                                    <div class="space-y-4">
                                        <a class="block" href="{{$catalystUser->link}}">
                                            <img class="w-20 h-20 mx-auto rounded-full lg:w-24 lg:h-24"
                                                 src="{{$catalystUser->thumbnail_url ?? $catalystUser->gravatar}}"
                                                 alt="{{$catalystUser->name}} gravatar" />
                                        </a>

                                        <div class="space-y-2">
                                            <div class="text-xs font-medium lg:text-sm">
                                                <h3>
                                                    <a class="block" href="{{$catalystUser->link}}">
                                                        {{$catalystUser->name}}
                                                    </a>
                                                </h3>
                                                <p class="" x-data="{ tooltip: 'Member of {{$catalystUser->proposals_count}} proposal team(s).' }">
                                                    <span x-tooltip.theme.primary="tooltip">
                                                        {{$catalystUser->proposals_count}} {{$catalystUser->proposals_count > 1 ? 'Proposals': 'Proposal'}}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $collection = 'catalystUsers'; ?>
    @include('pagination')

    <x-public.join-lido-pool></x-public.join-lido-pool>
</x-public-layout>
