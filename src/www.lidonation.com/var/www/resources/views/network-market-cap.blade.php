<x-public-layout class="pool-tools" title="Cardano pool tools.">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class='font-thin block'>{{__('Blockchain Network') }}</span>
            <span class='font-black'>{{__('Market Cap') }}.</span>
        </x-slot>

        <p>
            Blockchain Networks by Market Cap.
        </p>

    </x-public.page-header>

    <x-public.join-lido-pool></x-public.join-lido-pool>

</x-public-layout>
