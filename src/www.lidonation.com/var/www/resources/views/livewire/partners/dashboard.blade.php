<div >
    <section class="relative h-full py-16 lido-minute-nft" >
        <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full py-24" x-show="working"
            x-transition>
            <x-theme.spinner theme="teal" square="16" />
        </div>

        <div x-show="!working">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">
                    LIDO Minute NFT Graphic
                </h1>
                <p>
                    Please upload a square graphic for your ad spot.
                </p>
            </div>

            <div class="px-4 mx-auto mt-8 max-w-7xl sm:px-6 md:px-8">
                @if ($promos && count($promos) > 0)
                    @foreach ($promos as $promo)
                        <div class="" action="#" method="POST">
                            <div class="relative py-6 bg-white shadow sm:rounded-lg">
                                <h4 class="px-6 mb-3 -mt-2 text-right uppercase text-slate-500 xl:text-2xl lg:pr-12">
                                    Ep: {{ $promo->token->model?->episode }}: {{ $promo->token->model?->title }}
                                </h4>

                                <div class="mt-10 md:grid md:grid-cols-3 md:gap-8">
                                    <div class="md:col-span-1">
                                        <div
                                            class="sticky flex flex-col gap-16 px-4 py-10 sm:px-6 bg-slate-100 rounded-r-md top-16">
                                            <div>
                                                <h3 class="text-sm font-medium leading-6 text-gray-900">Preview</h3>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    This is what your promo will look like.
                                                </p>
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-medium leading-6 text-gray-900">Your Nft</h3>
                                                <img src="{{ $promo->token?->preview_link }}"
                                                    title="{{ $promo->token?->title }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-4 -mt-8 space-y-6 md:col-span-2 sm:px-6 lg:pr-12">
                                        <livewire:partners.lido-minute.promo-component :promo="$promo" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="flex gap-8 py-4">
                        <template x-for="asset in assets">
                            <div
                                class="flex flex-col items-center justify-center flex-shrink-0 gap-2 text-2xl border-4 border-gray-200 border-dashed rounded-sm w-128 text-slate-700 aspect-square">
                                <div class="flex-1 w-full p-4 text-center border-b-4 border-gray-200 border-dashed">
                                    <button type="button" @click="createPromo(asset)"
                                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                                        </svg>
                                        <span>
                                            Create Promo
                                        </span>
                                    </button>
                                </div>
                                <div>
                                    <div class="relative inline-flex justify-end rounded-sm">
                                        <img alt="Your nft" class="inline-block rounded-sm" :src="asset.image">
                                        <div
                                            class="absolute p-3 text-green-500 bg-opacity-75 border-2 border-green-500 border-double right-4 bottom-4 drop-shadow-lg 2xl:border-8 bg-slate-800">
                                            <h3 class="mb-4 text-lg text-yellow-500 xl:text-xl 2xl:text-2xl">
                                                Your NFT!
                                            </h3>
                                            <ul
                                                class="pb-2 space-y-3 text-sm border-t border-green-500 divide-y divide-green-500">
                                                <li class="flex flex-row gap-2 pt-2">
                                                    <span class="text-green-800">Name:</span>
                                                    <span x-text="asset.name"></span>
                                                </li>
                                                <li class="flex flex-row gap-2 pt-2">
                                                    <span class="text-green-800">Rarity:</span>
                                                    <span x-text="asset.rarity"></span>
                                                </li>
                                                <li class="flex flex-row gap-2 pt-2">
                                                    <span class="text-green-700">Artist:</span>
                                                    <span x-text="asset.artist"></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    {{-- <img :src="asset.image" :title="asset.name"> --}}
                                </div>
                            </div>
                        </template>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

