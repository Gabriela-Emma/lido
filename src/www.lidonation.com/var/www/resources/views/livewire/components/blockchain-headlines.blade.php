<div class="flex flex-col gap-6 w-full">
    <div class="mb-6">
        <h2 class="text-4xl text-gray-700 lg:text-5xl decorate dark">
            <span class="flex flex-row flex-wrap items-end gap-2">
                <span class="inline-flex flex-row gap-2">
                    <span class="">
                        {{$snippets->blockchain}}
                    </span>
                    <span class="inline-block text-teal-600 opacity-90">
                        {{$snippets->headlines}}
                    </span>
                </span>
                <span
                    class="flex flex-row items-center gap-4 text-xs text-gray-700 xl:justify-end xl:text-sm xl:leading-8">
                    <span>
                        <span>
                            {{now()->format('F d, Y')}}
                        </span>
                    </span>
                    <span title="current price of ada according to Coin Market Cap"
                        class="flex flex-row gap-1">
                        <span class="font-bold text-gray-400 2xl:inline-block">
                            1₳ =
                        </span>
                        <livewire:components.ada-quote />
                    </span>
                </span>
            </span>
        </h2>
    </div>
    <div class="flex flex-col gap-6">
        @foreach($quickNews as $post)
            <x-post.headline-drip :post="$post" />
            <hr class="border-b border-b-black" />
        @endforeach

        <livewire:components.more-headlines-component offset="{{$limit}}" :per-page="3" more-label="More Recent Headlines"/>
    </div>
</div>