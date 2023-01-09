<section class="overflow-hidden text-gray-600 bg-white">
    <div class="container relative py-12 mx-auto">
        <img
            class="absolute transform opacity-2 lg:translate-x-3/6 lg:-translate-y-3/5 lg:top-60 xl:top-40"
            width="480"
            height="480"
            fill="none"
            aria-hidden="true"
            src="{{asset('img/llogo-transparent.png')}}"
            alt="lido nation logo"
        />

        <img
            class="absolute left-full transform opacity-2 lg:-translate-x-3/6 lg:translate-y-1/5 lg:top-60 xl:top-40"
            width="480"
            height="480"
            fill="none"
            aria-hidden="true"
            src="{{asset('img/llogo-transparent.png')}}"
            alt="lido nation logo"
        />
        <img
            class="absolute transform opacity-3 lg:opacity-4 translate-x-4/6 -translate-y-2/5 lg:-translate-x-4/6 lg:translate-y-3/5 lg:top-60 xl:top-40"
            width="480"
            height="480"
            fill="none"
            aria-hidden="true"
            src="{{asset('img/llogo-transparent.png')}}"
            alt="lido nation logo"
        />

        <div class="relative lg:grid lg:grid-cols-3 lg:gap-x-8">
            <div class="flex flex-col justify-center lg:col-span-1">
                <h2 class="text-4xl font-light tracking-tight leading-tight text-gray-900 uppercase sm:text-5xl lg:text-7xl 3xl:text-8xl">
                    Join our <span class='font-black text-teal-600'>pool!</span>
                </h2>
            </div>
            <dl class="mt-10 space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-x-8 sm:gap-y-10 lg:mt-0 lg:col-span-2">
                <div>
                    <div class="flex justify-center items-center w-12 h-12 text-white rounded-sm bg-teal-600">
                        <!-- Heroicon name: chip -->
                        <svg class='w-6 h-6' xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                        </svg>
                    </div>
                    <div class="mt-5">
                        <dt class="text-xl font-medium leading-6 text-gray-900">
                            Unmatched Support
                        </dt>
                        <dd class="mt-2">
                            We provide phone and email support for all of our delegates.
                            We understand that many of our community members are not tech or crypto nerds. You expect
                            the same level of service and support you get from Reggie down at the bank or Saiid,
                            your nephew or friend at the office that won't stop talking about Bitcoin.
                            <span class="block mt-3">
                                We host weekly <a href="//meetup.com/lido-nation-cardano-pool-meetup">meetups</a> (currently online due to Covid).
                                Visit our <a href="{{localizeRoute('connect')}}">connect</a> page for all the ways you can reach us.
                            </span>
                        </dd>
                    </div>
                </div>
                <div>
                    <div class="flex justify-center items-center w-12 h-12 text-white rounded-sm bg-teal-600">
                        <!-- Heroicon name: cloud -->
                        <svg class='w-6 h-6' xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                        </svg>
                    </div>
                    <div class="mt-5">
                        <dt class="text-xl font-medium leading-6 text-gray-900">
                            Best in class servers
                        </dt>
                        <dd class="mt-2">
                            <span class="block">
                                Our servers are run and managed by professionals whose only job is to manage and run servers 24/7 365/6 days a year.
                            </span>

                            <span class="block mt-3">
                                We run our Cardano nodes on the same servers powering other services you've come to rely on everyday,
                                like Google and Pokemon Go.
                            </span>

                            <span class="block mt-3">
                                What this means for you is that our servers are always online and available to process transactions,
                                earning you and the causes we support the optimal amount of $$$$.
                                Visit our <a href="{{localizeRoute('lido-pool')}}">pool page</a> for more technical details.
                            </span>
                        </dd>
                    </div>
                </div>
                <div>
                    <div class="flex justify-center items-center w-12 h-12 text-white rounded-sm bg-teal-600">
                        <!-- Heroicon name: library -->
                        <svg class='w-6 h-6' xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                        </svg>
                    </div>
                    <div class="mt-5">
                        <dt class="text-xl font-medium leading-6 text-gray-900">
                            4% <span class='text-gray-500'>for community development and investment</span>
                        </dt>
                        <dd class="mt-2">
                            <span>Of all the rewards that come in, we keep 4% annually. All 4% goes towards charities you pick,
                            paying LIDO nation community members like yourself to write code and content for the site,
                                and grants for local community educational projects.</span>
                            <span class="block mt-3">
                                See our <a href="{{localizeRoute('financial-details')}}">financials page</a> for full records of our spending, more details, and breakdowns.
                            </span>
                        </dd>
                    </div>
                </div>

                <div>
                    <div class="flex justify-center items-center w-12 h-12 text-white rounded-sm bg-teal-600">
                        <!-- Heroicon name: heart -->
                        <svg class='w-6 h-6' xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div class="mt-5">
                        <dt class="text-xl font-medium leading-6 text-gray-900">
                            An Amazing Community
                        </dt>
                        <dd class="mt-2">
                            <span>When you delegate and join LIDO Nation, you get to participate in creating a space for people to interact, meet, learn, and teach each other.
                                You get to be part of the engine that works to make every voice heard with equal importance.</span>
                            <span class="block mt-3">
                                LIDO Nation is an idea. Delegate, take it and lets make something great!
                            </span>
                        </dd>
                    </div>
                </div>




            </dl>
        </div>
    </div>
</section>
