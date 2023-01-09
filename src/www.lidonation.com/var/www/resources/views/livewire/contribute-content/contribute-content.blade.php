<div title="Contribute Content">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class='font-light'>{{__('Contribute') }}</span><br/>
            <div class='font-black text-teal-600 flex flex-row justify-start items-end gap-3 relative -bottom-6'>
                <div>
                    <svg class="text-teal-600 h-20 w-20 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 48 48"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    {{__('Contribute') }}
                </div>
            </div>
        </x-slot>
        <p class="mt-1">
            Your perspective is valuable.
        </p>
        <p class="mt-1">
            Contribute articles, ideas, voice recordings, translations, reviews, and more!
        </p>
    </x-public.page-header>

{{--    <div class="max-w-5xl mx-auto">--}}
{{--        <livewire:contribute-content.contribute-translation />--}}
{{--    </div>--}}

    <section class="relative bg-white relative py-16">
        <div class="container">
            <div class="text-center">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 3xl:grid-cols-4">
                    <div class="pt-6">
                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">
                            <div class="-mt-6">
                                <div>
                                    <button
                                        onclick='Livewire.emit("openModal", "contribute-content.contribute-idea")'
                                        type="button"
                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-secondary-500 rounded-sm shadow-xs">
                                        Submit Idea
                                    </button>
                                </div>
                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">
                                    Got an Idea ?
                                </h3>
                                <div class="mt-2 font-normal">
                                    <div>Submit a new topic</div>
                                    <div>
                                        and vote for other ideas here.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">
                            <div class="-mt-6">
                                <div>
                                    <button
                                        onclick='Livewire.emit("openModal", "contribute-content.contribute-article")'
                                        type="button"
                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-teal-600 rounded-sm shadow-xs">
                                        Submit Article
                                    </button>
                                </div>
                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">
                                    News & Insights
                                </h3>
                                <div class="mt-2 font-normal">
                                    <p>
                                        Give us your perspective on the headlines.
                                        <br/>What should everyone understand
                                        <br/>about cryptos and Cardano?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">
                            <div class="-mt-6">
                                <div>
                                    <button
                                        onclick='Livewire.emit("openModal", "contribute-content.contribute-review")'
                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-teal-600 rounded-sm shadow-xs">
                                        Submit Review
                                    </button>
                                </div>
                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">
                                    Write a Review
                                </h3>
                                <div class="mt-2 font-normal">
                                    <p>
                                        As you explore crypto tools, projects, website, apps and DApps - what do you
                                        think
                                        about what you see?
                                    </p>
                                    <p>
                                        We provide the template; your provide the opinions.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

{{--                    <div class="pt-6">--}}
{{--                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">--}}
{{--                            <div class="-mt-6">--}}
{{--                                <div>--}}
{{--                                    <button--}}
{{--                                        onclick='Livewire.emit("openModal", "contribute-content.contribute-translation")'--}}
{{--                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-yellow-600 rounded-sm shadow-xs">--}}
{{--                                        Translate Content--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">--}}
{{--                                    Gracias - Asante - 谢谢--}}
{{--                                </h3>--}}
{{--                                <div class="mt-2 font-normal">--}}
{{--                                    <p>--}}
{{--                                        Do you speak Swahili, Spanish, Chinese, Japanese, or French?--}}
{{--                                        <br/>Help translate content!--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="pt-6">
                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">
                            <div class="-mt-6">
                                <div>
                                    <button
                                        onclick='Livewire.emit("openModal", "contribute-content.contribute-recording")'
                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-pink-600 rounded-sm shadow-xs">
                                        Record Article
                                    </button>
                                </div>

                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">
                                    Lend us your voice!
                                </h3>

                                <div class="mt-2 font-normal">
                                    <p>
                                        Voice recordings make website content accessible to more people.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6">
                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">
                            <div class="-mt-6">
                                <div>
                                    <button
                                        onclick='Livewire.emit("openModal", "contribute-content.contribute-money")'
                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-teal-800 rounded-sm shadow-xs">
                                        Give Money
                                    </button>
                                </div>

                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">
                                    Support LIDO Nation
                                </h3>

                                <div class="mt-2 font-normal">
                                    <p>
                                        Donate cash, btc, ada,
                                        <br/>or stake to <strong>LIDO</strong> pool.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-6">
                        <div class="flow-root bg-gray-100 rounded-sm h-full px-6 pb-8">
                            <div class="-mt-6">
                                <div>
                                    <a
                                        href="{{ route('portal') }}"
                                        class="hover:cursor-pointer hover:shadow-lg inline-flex font-semibold items-center text-white justify-center p-3 bg-teal-800 rounded-sm shadow-xs">
                                        Portal
                                    </a>
                                </div>

                                <h3 class="mt-8 text-lg font-semibold text-gray-900 tracking-tight">
                                    Go to your portal
                                </h3>

                                <div class="mt-2 font-normal">
                                    <p>
                                        Manage your account, validate wallet, see contribute stats, etc.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
