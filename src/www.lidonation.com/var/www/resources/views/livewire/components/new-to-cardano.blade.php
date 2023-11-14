    <div class="container px-4 py-12 mx-auto text-center sm:px-6 lg:px-8 lg:py-20">
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
            <h2 class="mb-4 text-2xl font-extrabold text-teal-600 xl:text-4xl 2xl:text-6xl">
                {{$snippets->newToCardano}}
            </h2>
            <p>
                {{$snippets->resourcesToGetYouStarted}}
            </p>
            <div>
                <ul class="grid items-end justify-center grid-cols-2 gap-20 mt-12 lg:grid-cols-4 xl:text-xl 3xl:text-2xl">
                    <li class="flow-root">
                        <a href="{{route('what-is-cardano')}}"
                           class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                            <div class="w-20 icon">
                                @include('svg.cardano')
                            </div>
                            <span>
                                {{$snippets->whatIsCardano}}
                            </span>
                        </a>
                    </li>

                    <li class="flow-root">
                        <a href="{{route('what-is-staking')}}"
                           class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                            <div class="w-20 icon">
                                @include('svg.pool-network')
                            </div>
                            <span>
                            {{$snippets->whatIsStaking}}
                        </span>
                        </a>
                    </li>

                    <li class="flow-root">
                        <a href="{{route('how-to-buy-ada')}}"
                           class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                            <div class="w-20 icon">
                                @include('svg.crypto-bank')
                            </div>
                            <span>
                            {{$snippets->howToBuyADA}}
                        </span>
                        </a>
                    </li>

                    <li class="flow-root">
                        <a href="{{route('how-to-stake-ada')}}"
                           class="flex flex-col items-center gap-5 p-3 -m-3 text-gray-900 rounded-md hover:bg-gray-50">
                            <div class="w-20 icon">
                                @include('svg.funfair')
                            </div>
                            <span>
                                {{$snippets->howToStakeYourADA}}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>