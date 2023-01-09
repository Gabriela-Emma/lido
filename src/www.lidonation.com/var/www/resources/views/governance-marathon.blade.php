<x-public-layout class="governance-marathon" title="Proof of Participation">
    @push('styles')
        <link rel="stylesheet" href="{{ asset(mix('css/governance-day.css')) }}">
    @endpush
    <section class="bg-gradient-to-br bg-gradi from-teal-light-500 to-teal-light-600 py-16" x-data="governanceMarathon">
        <div class="container grid grid-cols-12">
            <div class="col-span-1 relative">
                <div
                    class="event-title h-full w-auto p-0 text-lg lg:text-4xl 2xl:text-5xl rotate-180 text-center font-bold uppercase mr-auto text-teal-800 sticky top-16">
                    24hr Governance Marathon
                </div>
            </div>
            <div class="col-span-11 relative sm:py-16 h-auto">
                <div aria-hidden="true" class="hidden sm:block">
                    <div
                        class="absolute inset-y-0 left-0 w-1/2 rounded-r-2xl bg-teal-light-500 2xl:max-h-[32rem]"></div>
                    <svg class="absolute top-8 left-1/2 -ml-3" width="404" height="392" fill="none"
                         viewBox="0 0 404 392">
                        <defs>
                            <pattern id="8228f071-bcee-4ec8-905a-2a059a2cc4fb" x="0" y="0" width="20" height="20"
                                     patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor"/>
                            </pattern>
                        </defs>
                        <rect width="404" height="392" fill="url(#8228f071-bcee-4ec8-905a-2a059a2cc4fb)"/>
                    </svg>
                </div>
                <div class="mx-auto pl-4 sm:pl-6 w-full lg:pl-8">
                    <div
                        class="relative overflow-hidden rounded-sm bg-teal-500 px-2 xl:px-6 py-10 shadow-xl sm:px-12 sm:py-20 ">
                        <div aria-hidden="true" class="absolute inset-0 -mt-72 sm:-mt-32 md:mt-0">
                            <svg class="absolute inset-0 h-full w-full" preserveAspectRatio="xMidYMid slice"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1463 360">
                                <path class="text-teal-400 text-opacity-40" fill="currentColor"
                                      d="M-82.673 72l1761.849 472.086-134.327 501.315-1761.85-472.086z"/>
                                <path class="text-teal-600 text-opacity-40" fill="currentColor"
                                      d="M-217.088 544.086L1544.761 72l134.327 501.316-1761.849 472.086z"/>
                            </svg>
                        </div>
                        <div class="relative">
                            <div class="sm:text-center">
                                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl uppercase">
                                    Proof of Participation
                                </h2>
                                <div class="mt-4">
                                    <a target="_blank"
                                       href="https://twitter.com/i/spaces/1mrGmkqkdDnxy?s=20"
                                       class="text-yellow-500 hover:text-teal-light-300 inline-block border-yellow-500 border-2 rounded-sm p-2 inline-flex items-center gap-2">
                                        <span class="w-5 h-5 inline-block">@include('svg.twitter')</span>
                                        <span>Join the Space</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                        </svg>
                                    </a>
                                </div>
                                <p class="mx-auto mt-6 max-w-2xl text-lg text-teal-100">
                                    3rd 24hr Governance Marathon
                                </p>
                                <p>Connect your twitter account to record that you participated in </p>
                            </div>

                            <div class="flex justify-center items-center mt-6 gap-4">
                                @isset($twitter_access_token)
                                    <span
                                        class="bg-teal-800 text-teal-300 border-teal-800 p-3 inline-flex round-sm inset-1 items-center gap-2">
                                        <span class="w-5 h-5 inline-block">@include('svg.twitter')</span>
                                        Successfully connected as {{$twitter_access_token->screen_name}}
                                    </span>
                                @else
                                    <a href="{{route('twitter.login')}}" type="submit"
                                       class="rounded-sm border border-transparent bg-gray-900 px-5 py-3 text-base font-medium text-white shadow hover:bg-black focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-rose-500 sm:px-10">
                                        Connect Twitter
                                    </a>
                                @endisset

                                @if(request()->session()->has('notice'))
                                    <p>
                                        {{request()->session()->get('notice')}}
                                    </p>
                                @endif
                            </div>

                            @isset($twitter_access_token)
                                <form id="giveawayForm" class="max-w-3xl mx-auto mt-8"
                                      @submit.prevent="submitToGiveaway">
                                    @csrf
                                    <div x-show="!!giveAwayEntered" class="text-teal-light-100">
                                        <h2 class="text-white">Thanks! Your participation has been recorded</h2>
                                        <p>
                                            There's not much to do at the moment. More coming to your wallets later.
                                            Announcements will be made via the @lidonation twitter account
                                        </p>
                                        <hr class="border-0 border-t border-teal-200"/>
                                        <p class="text-teal-50 2xl:text-2xl">If you entered the giveaways winners will
                                            be posted here and tweeted out by the @lidonation account</p>
                                    </div>
                                    <div x-show="!giveAwayEntered"
                                         class="flex flex-wrap flex-col gap-4 xl:justify-center">
                                        <div class="min-w-[24rem]">
                                            <label for="email-address" class="block text-teal-light-300">
                                                Stake Address (required)
                                            </label>
                                            <div class="">
                                                <input type="text" id="stake_address" name="stake_address"
                                                       autocomplete="wallet" x-model="formData.stake_address"
                                                       required="required" placeholder="stake..."
                                                       class="block w-full bg-teal-light-400 rounded-sm teal-gray-300 shadow-sm border-teal-600 focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                            </div>
                                        </div>
                                        <div class="min-w-[24rem] flex flex-col justify-center">
                                            <label for="email-address" class="block text-teal-light-300">
                                                Reward Address <sub class="relative -top-0.5">(optional: a different
                                                    address than associated with your stake)</sub>
                                            </label>
                                            <div class="">
                                                <input type="text" id="reward_address" name="reward_address"
                                                       autocomplete="wallet" placeholder="addr..."
                                                       x-model="formData.reward_address"
                                                       class="block w-full bg-teal-light-400 rounded-sm teal-gray-300 shadow-sm border-teal-600 focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                            </div>
                                        </div>
                                    </div>

                                    <div x-show="!giveAwayEntered" class="max-w-3xl mx-auto mt-8">
                                        <fieldset>
                                            <legend class="text-xl font-medium text-white">
                                                Giveaways
                                                <sub class="relative -top-0.5">(optional: select the giveaways you would
                                                    like to be entered into)</sub>
                                            </legend>
                                            <div
                                                class="mt-4 divide-y divide-teal-200 border-t border-b border-teal-200">
                                                <div class="relative flex items-start py-4">
                                                    <div class="min-w-0 flex-1 text-sm">
                                                        <label for="firstPrinciples"
                                                               class="select-none font-medium text-slate-900">
                                                            First Principles of Governance NFT Collection
                                                        </label>
                                                    </div>
                                                    <div class="ml-3 flex h-5 items-center">
                                                        <input id="firstPrinciples" name="firstPrinciples"
                                                               type="checkbox" x-model="formData.firstPrinciples"
                                                               class="h-5 w-5 rounded border-teal-300 text-teal-300 focus:ring-teal-500">
                                                    </div>
                                                </div>

                                                <div class="relative flex items-start py-4">
                                                    <div class="min-w-0 flex-1 text-sm">
                                                        <label for="copperSeed"
                                                               class="select-none font-medium text-slate-900">
                                                            Copper Seed Save (24 winners)
                                                        </label>
                                                    </div>
                                                    <div class="ml-3 flex h-5 items-center">
                                                        <input id="copperSeed" name="copperSeed" type="checkbox"
                                                               x-model="formData.copperSeed"
                                                               class="h-5 w-5 rounded border-teal-300 text-teal-300 focus:ring-teal-500">
                                                    </div>
                                                </div>

                                                <div class="relative flex items-start py-4">
                                                    <div class="min-w-0 flex-1 text-sm">
                                                        <label for="resiToken"
                                                               class="select-none font-medium text-slate-900">
                                                            Resi Token (1 winner)
                                                        </label>
                                                    </div>
                                                    <div class="ml-3 flex h-5 items-center">
                                                        <input id="resiToken" name="resiToken" type="checkbox"
                                                               x-model="formData.resiToken"
                                                               class="h-5 w-5 rounded border-teal-300 text-teal-300 focus:ring-teal-500">
                                                    </div>
                                                </div>


                                                <div class="relative flex items-start py-4">
                                                    <div class="min-w-0 flex-1 text-sm">
                                                        <label for="cardaworlds"
                                                               class="select-none font-medium text-slate-900">
                                                            Cardaworlds NFT Collection (20 winners)
                                                        </label>
                                                    </div>
                                                    <div class="ml-3 flex h-5 items-center">
                                                        <input id="cardaworlds" name="cardaworlds" type="checkbox"
                                                               x-model="formData.cardaworlds"
                                                               class="h-5 w-5 rounded border-teal-300 text-teal-300 focus:ring-teal-500">
                                                    </div>
                                                </div>

                                                <div class="relative flex items-start py-4">
                                                    <div class="min-w-0 flex-1 text-sm">
                                                        <label for="roundtable"
                                                               class="select-none font-medium text-slate-900">
                                                            Would like to participate in a Roundtable experiment.
                                                        </label>
                                                    </div>
                                                    <div class="ml-3 flex h-5 items-center">
                                                        <input id="roundtable" name="roundtable" type="checkbox"
                                                               x-model="formData.roundtable"
                                                               class="h-5 w-5 rounded border-teal-300 text-teal-300 focus:ring-teal-500">
                                                    </div>
                                                </div>


                                                {{--                                            <div class="relative flex items-start py-4">--}}
                                                {{--                                                <div class="min-w-0 flex-1 text-sm">--}}
                                                {{--                                                    <label for="person-4" class="select-none font-medium text-slate-900">Kathryn Murphy</label>--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="ml-3 flex h-5 items-center">--}}
                                                {{--                                                    <input id="person-4" name="person-4" type="checkbox" class="h-4 w-4 rounded border-teal-300 text-teal-300 focus:ring-teal-500">--}}
                                                {{--                                                </div>--}}
                                                {{--                                            </div>--}}

                                                {{--                                            <div class="relative flex items-start py-4">--}}
                                                {{--                                                <div class="min-w-0 flex-1 text-sm">--}}
                                                {{--                                                    <label for="person-5" class="select-none font-medium text-slate-900">Theresa Webb</label>--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="ml-3 flex h-5 items-center">--}}
                                                {{--                                                    <input id="person-5" name="person-5" type="checkbox" class="h-4 w-4 rounded border-teal-300 text-teal-300 focus:ring-teal-500">--}}
                                                {{--                                                </div>--}}
                                                {{--                                            </div>--}}
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div x-show="!giveAwayEntered" class="h-full mt-8">
                                        <label for="email-address" class="block text-teal-light-300"></label>
                                        <button type="submit"
                                                class="block w-full rounded-md border border-transparent bg-gray-900 px-5 py-3 text-base font-medium text-white shadow hover:bg-black focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-rose-500 sm:px-10">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            @endisset

                            @if($giveaways)
                                @foreach($giveaways as $giveaway)
                                    <div class="mt-16 bg-teal-700 bg-opacity-50 p-4 lg:p-8">
                                        <h2 class="text-white mb-3 text-lg xl:text-3xl">
                                            Giveaway {{$loop->iteration}} Winners ({{$giveaway->count()}})
                                            @auth()
                                                <a class="text-yellow-500 hover:text-teal-300 text-sm inline-flex items-center gap-1 lg:ml-4"
                                                   href="http://twitter.com/share?text=Congratulations {{$giveaway->pluck('username')->implode(' @')}}"
                                                   target="_blank">
                                                    <span class="w-4 h-4 inline-block">
                                                        @include('svg.twitter')
                                                    </span>
                                                    <span class="text-xs md:text-base ">Tweet out winners</span>
                                                </a>
                                            @endauth
                                        </h2>
                                        <div class="flex flex-row flex-wrap justify-around gap-x-2 lg:gap-x-3 gap-y-3 lg:gap-y-5">
                                            @foreach($giveaway as $user)
                                                <div class="text-center">
                                                    <img
                                                        class="rounded-full w-10 h-10 lg:w-16 lg:h-16 inline-block border-4 {{ !!($twitter_access_token?->user_id == $user?->id) ? 'border-yellow-500' : 'border-transparent'}}"
                                                        src="{{$user?->profile_image_url}}" alt="twitter profile"/>
                                                    <div
                                                        class="text-sm lg:text-base {{ !!($twitter_access_token?->user_id == $user?->id) ? 'text-yellow-500' : 'text-teal-20' }}">
                                                        {{$user?->username}}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            @if($space)
                                <div class="mt-16 bg-teal-700 bg-opacity-50 p-4 lg:p-8">
                                    <h3 class="mb-3 text-teal-100">Speakers ({{count($twitterUsers)}})</h3>
                                    <div class="flex flex-row flex-wrap justify-around gap-x-2 lg:gap-x-3 gap-y-3 lg:gap-y-5">
                                        @foreach($twitterUsers as $user)
                                            <div class="text-center">
                                                <img
                                                    class="rounded-full w-10 h-10 lg:w-16 lg:h-16 inline-block border-4 {{ !!($twitter_access_token?->user_id == $user?->id) ? 'border-yellow-500' : 'border-transparent'}}"
                                                    src="{{$user?->profile_image_url}}" alt="twitter profile"/>
                                                <div
                                                    class="text-sm lg:text-base {{ !!($twitter_access_token?->user_id == $user?->id) ? 'text-yellow-500' : 'text-teal-200' }}">
                                                    {{$user?->username}}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($retweeters)
                                <div class="mt-16 bg-teal-700 bg-opacity-50 p-4 lg:p-8">
                                    <h3 class="mb-3 text-teal-100">Retweeters ({{count($retweeters)}})</h3>
                                    <div class="flex flex-row flex-wrap justify-around gap-x-2 lg:gap-x-3 gap-y-3 lg:gap-y-5">
                                        @foreach($retweeters as $user)
                                            <div class="text-center">
                                                <img
                                                    class="rounded-full w-10 h-10 lg:w-16 lg:h-16 inline-block border-4 {{ !!($twitter_access_token?->user_id == $user?->id) ? 'border-yellow-500' : 'border-transparent'}}"
                                                    src="{{$user?->profile_image_url}}" alt="twitter profile"/>
                                                <div
                                                    class="text-sm lg:text-base {{ !!($twitter_access_token?->user_id == $user?->id) ? 'text-yellow-500' : 'text-teal-200' }}">
                                                    {{$user?->username}}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="{{ mix('js/governance-marathon.js') }}" defer></script>
    @endpush
</x-public-layout>
