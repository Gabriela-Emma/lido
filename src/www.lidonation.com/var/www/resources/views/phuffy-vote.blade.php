<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $snippets->phuffyVote }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="flex flex-col gap-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xs sm:rounded-sm">
                <livewire:phuffycoin.phuffy-vote-component />
            </div>
        </div>
    </div>
</x-app-layout>
