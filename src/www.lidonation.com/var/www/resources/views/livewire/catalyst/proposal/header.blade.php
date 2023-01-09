<x-public.page-header :size="'md'">
    <x-slot name="title">
            <span class="block flex z-20 flex-col gap-3 sm:flex-row">
                <span class='z-20 font-light'>{{__('Cardano') }}</span>
                <span class='z-20 font-black text-teal-600'>{{__('Projects') }}</span>
            </span>
    </x-slot>
    <h2 class="font-medium">
        {{ $snippets->prePayingForFutureInnovations }}
    </h2>

    @if($snippets)
        <x-markdown>{{$snippets[0]?->content}}</x-markdown>
    @endif
</x-public.page-header>
