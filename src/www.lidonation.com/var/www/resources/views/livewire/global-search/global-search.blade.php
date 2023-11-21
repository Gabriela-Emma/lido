<div x-on:keydown.escape="openGlobalSearch = false">
<div class="h-full pb-4">
    <div class="flex flex-row justify-between items-center px-6 py-4 border-b-2 border-gray-400">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </span>

        <input wire:model.live.debounce.400ms="inputTerm" type="search" name="search" id="search"
            class="block w-full h-10 p-3 text-gray-900 placeholder-gray-500 border-0 focus:ring-0 sm:text-sm"
            placeholder="News, Insights, Reviews">

        <div class="flex flex-row items-center gap-2">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                </svg>
            </span>
            <button @click="$dispatch('close-global-search')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>


    <div>
        <div class="mx-auto border-b-2 border-gray-400 flex justify-evenly items-center w-5/6 px-6 py-4">
            <button wire:click="setAll" class="{{ $selectedType === 'all' ? 'border-b-2 border-gray-900' : '' }}">All
                Results <span class="bg-gray-100 px-1 py-0.5 rounded-full">{{ count($allItems) }}</span></button>
            <button wire:click="setInsights"
                class="{{ $selectedType === 'insights' ? 'border-b-2 border-gray-900' : '' }}">Insights <span
                    class="bg-gray-100 px-1 py-0.5 rounded-full">{{ count($insightsItems) }}</span></button>
            <button wire:click="setReviews"
                class="{{ $selectedType === 'reviews' ? 'border-b-2 border-gray-900' : '' }}">Reviews <span
                    class="bg-gray-100 px-1 py-0.5 rounded-full">{{ count($reviewsItems) }}</span></button>
        </div>
    </div>


    @if ($displayData)
        <div class="mx-auto w-5/6 h-full overflow-y-auto">
            <ul class="divide-y divide-gray-200">
                @foreach ($displayData as $item)
                    <li wire:key="{{ $item['id'] }}">
                        <a href="{{ $item['link'] }}" class="flex flex-row items-center px-6 py-5 space-x-6">
{{--                            <div class="flex-shrink-0">--}}
{{--                                <img class="w-10 h-10 bg-teal-800 rounded-md" src="{{ $item['hero'] }}"--}}
{{--                                    alt="{{ $item['title'] }}">--}}
{{--                            </div>--}}
                            <div class="flex flex-col">
                                <h3 class="font-semibold text-black">{{ $item['title'] }}</h3>
                                <div class="flex items-center gap-4 text-xs rounded-sm post-meta">
                                    <span
                                        class="bg-gray-100 px-1 py-0.5 text-black font-normal">{{ $item['published_at'] }}</span>
                                    @if ($item['type'] !== 'reviews')
                                        <span
                                            class="rounded-sm bg-gray-100 px-1 py-0.5 text-black font-normal">{{ $item['read_time'] }}</span>
                                        <div
                                            class="inline-flex items-center rounded-sm gap-4 author bg-gray-100 px-1 py-0.5">
                                            <div class="inline-block bio-pic">
                                                <img class="w-4 h-4 rounded-md" src="{{ $item['author_gravatar'] }}"
                                                    alt="{{ $item['author_name'] }}">
                                            </div>
                                            <div class="author-name text-black font-normal">{{ $item['author_name'] }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!$displayData && !empty($inputTerm))
        <div class="mx-auto w-5/6 p-6">
            <div
                class="relative flex flex-col items-center justify-center w-full p-12 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <span class="block mt-2 text-sm font-medium text-gray-900">
                    Nothing came up for <span class="font-semibold">{{ $inputTerm }}</span>
                </span>
            </div>
        </div>
    @endif

</div>
</div>
