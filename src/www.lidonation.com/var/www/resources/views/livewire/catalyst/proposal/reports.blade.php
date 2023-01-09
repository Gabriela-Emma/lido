<div class="relative z-10">
    @livewire('catalyst.catalyst-sub-menu-component')

    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class="z-10 flex flex-col block gap-3 sm:flex-row">
                <span class='z-10 font-light'>{{ $snippets->catalyst }}</span>
                <span class='z-10 font-black text-teal-600'>
                    {{ $snippets->reports }}
                </span>
            </span>
        </x-slot>

        <h2 class="font-medium">
            {{ $snippets->prePayingForFutureInnovations }}
        </h2>
    </x-public.page-header>

    <section class="px-4 bg-slate-100 round-sm py-8 border-t border-teal-600 border-opacity-50 overflow-x-hidden relative" id="monthly-reports-wrapper">
        <div
            wire:loading.class.remove="hidden"
            class="left-0 top-0 z-20 flex items-center justify-center hidden w-full h-full bg-white opacity-50 p-0 absolute">
            <div class="flex items-center justify-center w-24 h-24 p-3 bg-white rounded-full lg:h-32 lg:w-32 bg-opacity-90">
                <svg viewBox="0 0 24 24"
                    class="relative w-8 h-8 border-t-2 border-b-2 rounded-full lg:w-16 lg:h-16 animate-spin border-teal-600"></svg>
            </div>
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
                           class="block w-full h-full pl-10 transition duration-150 ease-in-out bg-white border rounded-sm form-input focus:bg-white outline-teal-600 sm:text-sm sm:leading-5"
                           placeholder="{{__('Search report content, author or proposal title')}}"/>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <button @click="@this.set('search', null); @this.set('perPage', 100)"
                                class="text-gray-300 hover:text-red-600 focus:outline-none">
                            <x-icons.x-circle class="w-5 h-5 stroke-current" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 columns-1 sm:columns-2 xl:columns-3 gap-4 monthly-reports">
            @foreach($catalystReports as $report)
                <x-catalyst.reports.drip wire:key="{{$report->id}}" :report="$report" />
            @endforeach
        </div>

        <div class="mt-6 paginator ">
            {{ $this->getPaginator()?->links() }}
        </div>
    </section>
</div>
