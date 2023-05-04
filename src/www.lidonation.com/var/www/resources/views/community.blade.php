<x-public-layout class="community" metaTitle="LIDO Nation Community">
    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class='font-thin block'>{{__('LIDO Nation') }}</span>
            <span class='font-extrabold text-teal-600'>{{__('Community') }}.</span>
        </x-slot>

        <p>
            Lido Nation is a global community of people who believe the future is for everyone.<br />
            Together we are learning, teaching, and building the world we want to see.<br />
        </p>

        <p>
            We are glad you are here.
        </p>
    </x-public.page-header>
    <section class="bg-teal-600 text-white py-8 z-10 relative">
        <div class="container">
            <h2 class="lg:text-4xl flex flex-row items-baseline flex-wrap gap-4">
                <span>Follow Us on Social Media</span>
                <a class="text-teal-600 hover:text-white flex flex-row items-baseline gap-1 text-base" href="//facebook.com/lidonation" target="_blank">
                    <span class="w-5 h-5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                            <path fill="currentColor" d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                        </svg>
                    </span>
                    <span>/lidonation</span>
                </a>
                <a class="text-teal-600 hover:text-white flex flex-row items-baseline gap-1 text-base" href="//twitter.com/lidonation" target="_blank">
                    <span class="w-5 h-5 relative top-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                            <path fill="currentColor" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-.139 9.237c.209 4.617-3.234 9.765-9.33 9.765-1.854 0-3.579-.543-5.032-1.475 1.742.205 3.48-.278 4.86-1.359-1.437-.027-2.649-.976-3.066-2.28.515.098 1.021.069 1.482-.056-1.579-.317-2.668-1.739-2.633-3.26.442.246.949.394 1.486.411-1.461-.977-1.875-2.907-1.016-4.383 1.619 1.986 4.038 3.293 6.766 3.43-.479-2.053 1.08-4.03 3.199-4.03.943 0 1.797.398 2.395 1.037.748-.147 1.451-.42 2.086-.796-.246.767-.766 1.41-1.443 1.816.664-.08 1.297-.256 1.885-.517-.439.656-.996 1.234-1.639 1.697z"/>
                        </svg>
                    </span>
                    <span>@lidonation</span>
                </a>
            </h2>
            <div class="grid lg:grid-cols-2 gap-8 md:gap-16 mt-6">
                <div class="max-h-[24rem] overflow-y-scroll border-t border-b border-gray-300">
                    @foreach($tweets as $tweet)
                        <div class="border border-gray-300 -mt-px p-3">
                            <div class="flex flex-row">
                                <div>
                                    <div class="flex-shrink-0 mr-3 w-8 sm:w-12">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-.139 9.237c.209 4.617-3.234 9.765-9.33 9.765-1.854 0-3.579-.543-5.032-1.475 1.742.205 3.48-.278 4.86-1.359-1.437-.027-2.649-.976-3.066-2.28.515.098 1.021.069 1.482-.056-1.579-.317-2.668-1.739-2.633-3.26.442.246.949.394 1.486.411-1.461-.977-1.875-2.907-1.016-4.383 1.619 1.986 4.038 3.293 6.766 3.43-.479-2.053 1.08-4.03 3.199-4.03.943 0 1.797.398 2.395 1.037.748-.147 1.451-.42 2.086-.796-.246.767-.766 1.41-1.443 1.816.664-.08 1.297-.256 1.885-.517-.439.656-.996 1.234-1.639 1.697z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="font-semibold text-sm">
                                        <x-carbon :date="$tweet->created_at" human />
                                    </div>
                                    <p class="text-md">
                                        {!! $tweet->text !!}
                                    </p>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
                <div>
                    <h2>Twitter Spaces</h2>
                    <div>
                        LIDO Nation hosts 3  "Twitter Spaces"  (live voice chats) each week. <br />
                        <strong>Join us any time for newcomer-friendly Q&A.</strong>

                        <div class="flow-root mt-8 text-white">
                            <ul role="list" class="-mb-8">
                                <li>
                                    <div class="relative pb-12">
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        <div class="relative flex space-x-4">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-teal-800 flex ring-8 ring-white">
                                                  @include('svg.night')
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="">
                                                        Monday 9:30pm CT
                                                    </p>
                                                </div>
                                                <div class="text-right whitespace-nowrap">
                                                    <span>Tuesday 3:30am UTC</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="relative pb-12">
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        <div class="relative flex space-x-4">
                                            <div>
                                                <div class="h-8 w-8 rounded-full bg-teal-400 flex ring-8 ring-white text-yellow-500">
                                                  @include('svg.sunrise')
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="">
                                                        Wednesday 8am CT
                                                    </p>
                                                </div>
                                                <div class="text-right whitespace-nowrap">
                                                    <span>12PM UTC</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="relative pb-12">
                                        <div class="relative flex space-x-4">
                                            <div>
                                                <div class="h-8 w-8 rounded-full bg-teal-400 flex ring-8 ring-white text-yellow-500">
                                                  @include('svg.sunrise')
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="">
                                                        Friday 8am CT
                                                    </p>
                                                </div>
                                                <div class="text-right whitespace-nowrap">
                                                    <span>12PM UTC</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="relative py-16 bg-pool-bw-light bg-cover bg-center bg-scroll bg-teal-light-500 bg-blend-color-burn" aria-labelledby="quick-links-title">
        <div class="container">
            <div class="relative mx-auto text-white">
                <x-public.meetup></x-public.meetup>
                <div class="block clearfix py-10"></div>

            </div>
        </div>
    </section>

    <section class="relative" id="send-a-message">
        <x-public.contact-lido></x-public.contact-lido>
    </section>

    <x-support-lido heading-leading='Support the' heading-span='Library'/>

</x-public-layout>
