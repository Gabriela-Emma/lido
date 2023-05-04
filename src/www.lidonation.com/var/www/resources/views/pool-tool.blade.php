<x-public-layout class="pool-tools" title="Cardano pool tools.">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class='font-thin block'>{{__('Cardano Pool') }}</span>
            <span class='font-black'>{{__('Tools') }}.</span>
        </x-slot>

        <p>
            Some tools to help you pick who to delegate to. See this article for how pick a stake pool.
        </p>

    </x-public.page-header>

    <x-public.pools :pools="$pools"></x-public.pools>

    <x-support-lido heading-leading='Support the' heading-span='Library'/>

</x-public-layout>
