<div class="relative z-10 catalyst-proposals-research-wrapper">
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
                <div class="px-4 py-12 mx-auto text-center max-w-7xl sm:px-6 lg:px-8 lg:py-16">
                    <div class="space-y-8 sm:space-y-12">
                        <div class="space-y-5 sm:mx-auto sm:max-w-xl sm:space-y-4 lg:max-w-5xl">
                            <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                                {{ $snippets->proposers }}
                            </h2>
                            <p class="text-xl text-gray-500">
                                Diverse, independent, and together inspiring the highest level of human collaboration.
                            </p>
                        </div>

                        <div class="flex items-center w-4/5 h-16 mx-auto 2x:w-3/5">
                            <div class="flex w-full h-full rounded-sm shadow-sm">
                                <div class="relative flex-grow w-full h-full focus-within:z-10" x-data="{}">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor"
                                             fill="none">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input wire:model.debounce.600ms="search"
                                           x-bind:search="search"
                                           name="searchProposals"
                                           id="searchProposals"
                                           class="block w-full h-full pl-10 transition duration-150 ease-in-out bg-white border rounded-sm form-input outline-teal-600 focus:bg-white sm:text-sm sm:leading-5"
                                           placeholder="{{__('Search name, proposal, topic')}}"/>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <button @click="@this.set('search', null)"
                                                class="text-gray-300 hover:text-red-600 focus:outline-none">
                                            <x-icons.x-circle class="w-5 h-5 stroke-current"/>
                                        </button>
                                    </div>
                                </div>
                            </div>
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

                        <div class="mt-6 paginator ">
                            {{ $this->getPaginator()?->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
