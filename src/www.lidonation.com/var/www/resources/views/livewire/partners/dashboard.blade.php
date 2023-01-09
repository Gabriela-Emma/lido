<div>
    <section class="py-16 lido-minute-nft relative h-full">
        <div class="absolute left-0 top-0 py-24 w-full h-full flex justify-center items-center" x-show="working"
             x-transition>
            <x-theme.spinner theme="teal" square="16"/>
        </div>

        <div x-show="!working">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">
                    LIDO Minute NFT Graphic
                </h1>
                <p>
                    Please upload a square graphic for your ad spot.
                </p>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8 mt-8">
                @if($promos && count($promos) > 0)
                    @foreach($promos as $promo)
                        <div class="" action="#" method="POST">
                            <div class="bg-white shadow sm:rounded-lg py-6 relative">
                                <h4 class="-mt-2 mb-3 text-slate-500 uppercase text-right xl:text-2xl px-6 lg:pr-12">
                                    Ep: {{$promo->token->model->episode}}: {{$promo->token->model->title}}
                                </h4>

                                <div class="md:grid md:grid-cols-3 md:gap-8 mt-10">
                                    <div class="md:col-span-1">
                                        <div class="flex flex-col gap-16 px-4 py-10 sm:px-6 bg-slate-100 rounded-r-md sticky top-16">
                                            <div>
                                                <h3 class="text-sm font-medium leading-6 text-gray-900">Preview</h3>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    This is what your promo will look like.
                                                </p>
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-medium leading-6 text-gray-900">Your Nft</h3>
                                                <img src="{{$promo->token?->preview_link}}"
                                                     title="{{$promo->token?->title}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-6 md:col-span-2 px-4 -mt-8 sm:px-6 lg:pr-12">
                                        <livewire:partners.lido-minute.promo-component :promo="$promo"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="py-4 flex gap-8">
                        <template x-for="asset in assets">
                            <div
                                class="w-128 text-slate-700 rounded-sm border-4 border-dashed border-gray-200 aspect-square flex flex-col gap-2 justify-center items-center text-2xl">
                                <div class="border-b-4 border-dashed border-gray-200 p-4 flex-1 w-full text-center">
                                    <button type="button"
                                            @click="createPromo(asset)"
                                            class="inline-flex items-center rounded-sm border border-gray-300 gap-2 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                                        </svg>
                                        <span>
                                        Create Promo
                                    </span>
                                    </button>
                                </div>
                                <div>
                                    <img :src="asset.image" :title="asset.name">
                                </div>
                            </div>
                        </template>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
