<x-public-layout
    metaTitle="Missing Proposal"
    class="bg-primary700 md:bg-no-repeat proposals relative">
    @livewire('catalyst.catalyst-sub-menu-component')
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class="z-10 flex flex-col block gap-3 sm:flex-row">
                <span class='z-10 font-light'>{{ $snippets->missing }}</span>
                <span class='z-10 font-black text-teal-600'>
                    {{ $snippets->proposal }}
                </span>
            </span>
        </x-slot>
        <h2 class="font-medium xl:pr-16">
            <span>{{ $snippets->missingProposal }}:</span> <span class="font-semibold">{{$term}}</span>
        </h2>
    </x-public.page-header>
    <section class="relative py-8 text-md bg-white">
        <div class="container">
            <h2 class="decorate dark mb-8 xl:text-4xl">
                Perhaps you meant one these?
            </h2>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3">
                @foreach($proposals as $proposal)
                    <div wire:key="{{$proposal->id}}">
                        @if($proposal->type=='challenge')
                            <x-catalyst.challenges.drip  :challenge="$proposal" />
                        @else
                            <x-catalyst.proposals.drip :proposal="$proposal" />
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-public-layout>
