<div class="bg-white">

    <x-public.page-header :size="'md'">
        <x-slot name="title">
            <span class="z-20 flex flex-col block gap-3">
                <span class='z-20 font-light'>{{__('LIDO Nation') }}</span>
                <span class='z-20 font-black text-teal-600 block'>{{__('Catalyst Proposals') }}</span>
            </span>
        </x-slot>
    </x-public.page-header>

    <!-- Top two proposals -->
    <section class="relative pt-16 pb-32 z-10 overflow-hidden">
        <div aria-hidden="true" class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-gray-100"></div>

        <!-- Content & Insights: Multi-Channel  -->
        <div class="relative container">
            <div class="lg:mx-auto lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-16 lg:max-w-none lg:mx-0 lg:px-0">
                    <div>
                        <div class="mt-6">
                            <h2 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-1">
                                Content & Insights: Multi-Channel
                            </h2>
                            <p class="mb-6">
                                Our proposal to add an investigative journalist to the lido team!
                            </p>


                            <div class="flex flex-col gap-4">
                                <div>
                                    <div>
                                        <span
                                            class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                            <span class="text-xs">Problem</span>
                                        </span>
                                    </div>
                                    <div class="text-lg text-gray-500 mt-0">
                                        Project Catalyst will grow when more people are exposed to the excitement,
                                        innovation, and positive community in the Cardano ecosystem.
                                    </div>
                                </div>

                                <div>
                                    <div>
                                        <span
                                            class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            <span class="text-xs">Solution</span>
                                        </span>
                                    </div>
                                    <div class="text-lg text-gray-500 mt-0">
                                        Articles about Catalyst roles & topics, Interviews w/ Catalyst participants,
                                        Community leadership on twitter w/ 100+ live participants daily.
                                    </div>
                                </div>

                                <div>
                                    <div>
                                        <span
                                            class="h-6 w-24 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-xs">Experience</span>
                                        </span>
                                    </div>
                                    <div class="text-lg text-gray-500 mt-0">
                                        We publish Cardano articles weekly, built a Catalyst research tool, & host daily
                                        twitter shows. We were funded by Catalyst to found a mentoring & outreach Lab in
                                        Kenya, & to
                                        translate our Content Library into Swahili & Spanish. Blockchain developer, Tech
                                        evangelist, Web designer.
                                    </div>
                                </div>
                            </div>


                            <div class="mt-6">
                                <a href="https://cardano.ideascale.com/c/idea/401884/comments"
                                   target="_blank"
                                   class="inline-flex bg-gradient-to-r from-secondary-600 to-primary-600 bg-origin-border px-4 py-2 border border-transparent text-base font-medium rounded-sm shadow-sm text-white hover:from-secondary-700 hover:to-primary-700">
                                    Leave a feedback on Ideascale
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-12 sm:mt-16 lg:mt-0">
                    <div class="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                        <img
                            class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none"
                            src="{{asset('img/just-start-unsplash.jpeg')}}"
                            alt="Inbox user interface">
                    </div>
                </div>
            </div>
        </div>

        <!-- Real Journalism = Cardano Insights -->
        <div class="mt-24">
            <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-32 lg:max-w-none lg:mx-0 lg:px-0 lg:col-start-2">
                    <h2 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-1">
                        Real Journalism = Cardano Insights
                    </h2>
                    <p class="mb-6">Our proposal to onboard new humans onto catalyst!</p>

                    <div class="flex flex-col gap-4">
                        <div>
                            <div>
                                <span
                                    class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    <span class="text-xs">Problem</span>
                                </span>
                            </div>
                            <div class="text-lg text-gray-500 mt-0">
                                Traditional news often misses the point; online pundits vary in quality and
                                accessibility. Cardano deserves quality research and journalism.
                            </div>
                        </div>

                        <div>
                            <div>
                                <span
                                    class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span class="text-xs">Solution</span>
                                </span>
                            </div>
                            <div class="text-lg text-gray-500 mt-0">
                                Add an experienced journalist to the team to specialize in news about Cardano
                                blockchain and ecosystem. Publish & distribute content.
                            </div>
                        </div>

                        <div>
                            <div>
                                <span
                                    class="h-6 w-24 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs">Experience</span>
                                </span>
                            </div>
                            <div class="text-lg text-gray-500 mt-0">
                                We publish Cardano articles weekly, built a Catalyst research tool, & host daily
                                twitter shows.
                                We were funded by Catalyst to found a mentoring & outreach Lab in Kenya, & to
                                translate our Content Library into Swahili & Spanish.
                                Blockchain developer, Tech evangelist, Web designer.
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="https://cardano.ideascale.com/c/idea/401765/comments"
                           target="_blank"
                           class="inline-flex bg-gradient-to-r from-secondary-600 to-primary-600 bg-origin-border px-4 py-2 border border-transparent text-base font-medium rounded-sm shadow-sm text-white hover:from-secondary-700 hover:to-primary-700">
                            Leave a feedback on Ideascale
                        </a>
                    </div>
                </div>
                <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-start-1">
                    <div class="pr-4 -ml-48 sm:pr-6 md:-ml-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                        <img
                            class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:right-0 lg:h-full lg:w-auto lg:max-w-none"
                            src="{{asset('img/rocks-unsplash.jpeg')}}"
                            alt="Customer profile user interface">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LIDO big on cardano-->
    <section class="bg-gradient-to-r from-primary-900 to-primary-700">
        <div class="max-w-4xl mx-auto px-4 py-16 sm:px-6 sm:pt-20 sm:pb-24 lg:max-w-7xl lg:pt-24 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">
                LIDO Nation is big on Cardano and Big on Catalyst
            </h2>
            <p class="mt-4 max-w-3xl text-lg text-teal-200">
                We have participated as Proposal Assessor, a Veteran Proposal Assessor,
                in Catalyst Circle governance meetings -- and of course as voters!
            </p>
            <p class="mt-4 max-w-3xl text-lg text-teal-200">
                We run a Blockchain Learning Center in Kenya, thanks to a funded catalyst Fund 7 <a class="text-white" href="https://www.lidonation.com/en/proposals/cardano-blockchain-lab-in-kenya">proposal</a>.
            </p>

            <div
                class="mt-12 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-2 lg:mt-16 lg:grid-cols-4 lg:gap-x-8 lg:gap-y-16">
                <div>
                    <div>
                      <span class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-10">
                        <!-- Heroicon name: outline/inbox -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                      </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-white">
                            Multi-language resources
                        </h3>
                        <p class="mt-2 text-base text-teal-200">
                            Thanks to successful fund 6 and 7 proposals, we are one track to have all of our content library in swahili, english, and spanish.
                        </p>
                    </div>
                </div>

                <div>
                    <div>
              <span class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-10">
                <!-- Heroicon name: outline/users -->
                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
              </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-white">
                            12+ hrs/wk twitter spaces
                        </h3>
                        <p class="mt-2 text-base text-teal-200">
                            We co-host Cardano Over Coffee every week day @ 14:30 UTC and host new to blockchain every Tuesday at 3:30am UTC.
                        </p>
                    </div>
                </div>

                <div>
                    <div>
              <span class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-10">
                <!-- Heroicon name: outline/trash -->
                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
              </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-white">
                            2hr/wk Zoom office hours
                        </h3>
                        <p class="mt-2 text-base text-teal-200">
                            We hold 30 minute zoom office hours throughout the week to help anyone rubber duck-it.
                            Get help with a catalyst proposal. Ask questions, etc.
                        </p>
                    </div>
                </div>

                <div>
                    <div>
                      <span class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-10">
                        <!-- Heroicon name: outline/pencil-alt -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                      </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-white">
                            Catalyst Proposal Assessor
                        </h3>
                        <p class="mt-2 text-base text-teal-200">We've been helping review proposals since fund 6.
                            We're gearing to teach our Kenyan community how to be awesome proposal assessor!</p>
                    </div>
                </div>

                <div>
                    <div>
                      <span class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-10">
                        <!-- Heroicon name: outline/document-report -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                      </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-white">
                            Stake Pool Operators
                        </h3>
                        <p class="mt-2 text-base text-teal-200">
                            We run LIDO stake pool on the mainnet as well as the testnet!
                            We've never missed a block on mainnet.
                        </p>
                    </div>
                </div>

                <div>
                    <div>
                      <span class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-10">
                        <!-- Heroicon name: outline/reply -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                        </svg>
                      </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-white">
                            Open Source contributors
                        </h3>
                        <p class="mt-2 text-base text-teal-200">
                            We maintain the castalyst proposal open api project on github.
                            Also planning to host and offer it for free to anyone wanting to build tools around catalyst proposal data.
                        </p>
                    </div>
                </div>

                <div>
                    <div>
                        <span class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-10">
                            <!-- Heroicon name: outline/chat-alt -->
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" aria-hidden="true">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-white">
                            Catalyst Townhall Participants
                        </h3>
                        <p class="mt-2 text-base text-teal-200">
                            We watch every townhall, mostly in person, sometimes the replay on YouTube.
                            We are also active participants in after townhall rooms!
                        </p>
                    </div>
                </div>

                <div>
                    <div>
                      <span class="flex items-center justify-center h-12 w-12 rounded-md bg-white bg-opacity-10">
                        <!-- Heroicon name: outline/heart -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                      </span>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-white">
                            Developer Mentorship
                        </h3>
                        <p class="mt-2 text-base text-teal-200">
                            Thanks to a Fund 7 winning proposal, we run a blockchain learning center Kenya,
                            mentoring developers to help businesses build on Cardano.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative pt-16 pb-32 z-10 overflow-hidden">
        <div aria-hidden="true" class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-gray-100"></div>
        <!--  ADA Pay Plugin - WordPress/Laravel -->
        <div class="relative pt-16 pb-32 z-10 overflow-hidden">
            <div aria-hidden="true" class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-gray-100"></div>
            <div class="relative container">
                <div class="lg:mx-auto lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                    <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-16 lg:max-w-none lg:mx-0 lg:px-0">
                        <div class="mt-6">
                            <h2 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-3">
                                ADA Pay Plugin - WordPress/Laravel
                            </h2>
                            <p class="mb-4">
                                Our proposal to make adding Cardano payment to any WordPress site with a plugin! Vroom! Vroom!
                            </p>

                            <div class="flex flex-col gap-4">
                                <div>
                                    <div>
                                    <span
                                        class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                        <span class="text-xs">Problem</span>
                                    </span>
                                    </div>
                                    <div class="text-lg text-gray-500 mt-0">
                                        There is no high quality WordPress plugin for receiving ADA payments.
                                        1/4 of all websites are built on WordPress, more than 2M on Laravel.
                                    </div>
                                </div>

                                <div>
                                    <div>
                                    <span
                                        class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span class="text-xs">Solution</span>
                                    </span>
                                    </div>
                                    <div class="text-lg text-gray-500 mt-0">
                                        Create a WordPress & Laravel plugin to enable ADA payments for the market of 1.4 Billion websites built using PHP.
                                    </div>
                                </div>

                                <div>
                                    <div>
                                    <span
                                        class="h-6 w-24 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-xs">Experience</span>
                                    </span>
                                    </div>
                                    <div class="text-lg text-gray-500 mt-0">
                                        14+ years of software and cloud system engineering. Built a Catalyst research tool,
                                        host daily twitter shows, founded a blockchain software mentoring & outreach Lab in Kenya.

                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="https://cardano.ideascale.com/c/idea/402180/comments"
                                   target="_blank"
                                   class="inline-flex bg-gradient-to-r from-secondary-600 to-primary-600 bg-origin-border px-4 py-2 border border-transparent text-base font-medium rounded-sm shadow-sm text-white hover:from-secondary-700 hover:to-primary-700">
                                    Leave a feedback on Ideascale
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 sm:mt-16 lg:mt-0">
                        <div class="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                            <img
                                class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none"
                                src="{{asset('img/wordpress-moritz-mentges-unsplash.jpg')}}"
                                alt="Inbox user interface">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Migrating from ETH: Newcomer Setup -->
        <div class="mt-24">
            <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-32 lg:max-w-none lg:mx-0 lg:px-0 lg:col-start-2">
                    <h2 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-1">
                        Migrating from ETH: Newcomer Setup
                    </h2>
                    <p class="mb-6">
                        Our proposal to help current Eth users and businesses make sense of Cardano!
                    </p>

                    <div class="flex flex-col gap-4">
                        <div>
                            <div>
                                        <span
                                            class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                            <span class="text-xs">Problem</span>
                                        </span>
                            </div>
                            <div class="text-lg text-gray-500 mt-0">
                                There is no landing page to help translate Eth concepts, tech, philosophies,
                                and choices to Cardano's - for users and businesses
                            </div>
                        </div>

                        <div>
                            <div>
                                <span
                                    class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span class="text-xs">Solution</span>
                                </span>
                            </div>
                            <div class="text-lg text-gray-500 mt-0">
                                Getting started, "how to"s, insights, and technical articles about Cardano technologies
                                that specifically targets an Ethereum audience.
                            </div>
                        </div>

                        <div>
                            <div>
                                <span
                                    class="h-6 w-24 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs">Experience</span>
                                </span>
                            </div>
                            <div class="text-lg text-gray-500 mt-0">
                                We publish Cardano articles weekly, built a Catalyst research tool, & host daily twitter shows.
                                We were funded by Catalyst to found a mentoring & outreach Lab in Kenya, & to translate
                                our Content Library into Swahili & Spanish. Blockchain developer, Tech evangelist, Web designer.
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="https://cardano.ideascale.com/c/idea/402914/comments"
                           target="_blank"
                           class="inline-flex bg-gradient-to-r from-secondary-600 to-primary-600 bg-origin-border px-4 py-2 border border-transparent text-base font-medium rounded-sm shadow-sm text-white hover:from-secondary-700 hover:to-primary-700">
                            Leave a feedback on Ideascale
                        </a>
                    </div>
                </div>
                <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-start-1">
                    <div class="pr-4 -ml-48 sm:pr-6 md:-ml-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                        <img
                            class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:right-0 lg:h-full lg:w-auto lg:max-w-none"
                            src="{{asset('img/cardano-and-ethereum.jpeg')}}"
                            alt="Ethereum Cardano logos">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LIDO Community partners -->
    <section class="bg-gray-100">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-semibold uppercase text-gray-500 tracking-wide">
                Our Community Partners
            </p>
            <div class="mt-6 grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5 grayscale">
                <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                    <img class="h-9"
                        src="{{asset('img/ada-cafe-logo.png')}}"
                         alt="ADA Cafe logo">
                </div>
                <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                    <img class="h-9" src="{{asset('img/pace-logo.png')}}"
                         alt="PACE logo">
                </div>
                <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                    <img class="h-12" src="{{asset('img/ngong-road-logo.png')}}"
                         alt="Ngong Road logo">
                </div>
                <div class="col-span-1 flex justify-center md:col-span-2 md:col-start-2 lg:col-span-1">
                    <img class="h-12" src="{{asset('img/gimbalabs-logo.png')}}"
                         alt="Gimbalabs Logo">
                </div>
                <div class="col-span-2 flex justify-center md:col-span-2 md:col-start-4 lg:col-span-1">
                    <img class="h-12" src="{{asset('img/freeloaderz-logo.png')}}"
                         alt="Freeloaderz">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="bg-teal-800">
        <div class="max-w-7xl mx-auto md:grid md:grid-cols-2 md:px-6 lg:px-8">
            <div class="py-12 px-4 sm:px-6 md:flex md:flex-col md:py-16 md:pl-0 md:pr-10 md:border-r md:border-primary-900 lg:pr-16">
                <blockquote class="mt-6 md:flex-grow md:flex md:flex-col">
                    <div class="relative text-lg font-medium text-white md:flex-grow">
                        <svg class="absolute top-0 left-0 transform -translate-x-3 -translate-y-2 h-8 w-8 text-teal-600" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                        </svg>
                        <p class="relative">
                            I agree 💯% that a NEW perspective is needed. Blockchain is a new
                            tool, but how do we use that new tool? <br/> <br/>

                            I believe the Cardano Community needs to connect much more in Project
                            Catalyst itself.
                            Cardano is a scientific, methodical, "fact based" community which is why
                            I believe in it, but at the same time,
                            I feel that there is that lack of connection that you mention. It almost
                            feels like the Cardano Community is building a playground,
                            but few are playing in it: <br/> <br/>

                            I take the perspective that I am doing Gonzo journalism right now in
                            Project Catalyst through my Ideascale
                            proposals and comments themselves. It is my attempt to further
                            connection here and everywhere. <br/> <br/>

                            I don't want to regret this opportunity and later say that I knew my
                            ideas were new,
                            so I would love your or anyone else from LIDO Nation's opinion on two of
                            my F8 proposals, but no pressure at all.
                        </p>
                    </div>
                    <footer class="mt-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 inline-flex rounded-full border-2 border-white">
                                <img class="h-12 w-12 rounded-full"
                                     src="{{asset('img/ideascale-logo.png')}}"
                                     alt="Ideascale logo">
                            </div>
                            <div class="ml-4">
                                <div class="text-base font-medium text-white">
                                    JO8N(@@jo8n)
                                </div>
                                <div class="text-base font-medium text-teal-200">
                                    Ideascale member
                                </div>
                            </div>
                        </div>
                    </footer>
                </blockquote>
            </div>
            <div class="py-12 px-4 border-t-2 border-primary-900 sm:px-6 md:py-16 md:pr-0 md:pl-10 md:border-t-0 md:border-l lg:pl-16">
                <blockquote class="mt-6 mb-16 md:flex-grow md:flex md:flex-col">
                    <div class="relative text-lg font-medium text-white md:flex-grow">
                        <svg class="absolute top-0 left-0 transform -translate-x-3 -translate-y-2 h-8 w-8 text-teal-600" fill="currentColor" viewBox="0 0 32 32">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                        </svg>
                        <p class="relative">
                            Very nice proposal, well thought out and complete, which is always appreciated.
                            Keep up the good work multiplying and deepening connections to Catalyst!
                        </p>
                    </div>
                    <footer class="mt-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 inline-flex rounded-full border-2 border-white">
                                <img class="h-12 w-12 rounded-full"
                                     src="{{asset('img/ideascale-logo.png')}}"
                                     alt="Ideascale logo">
                            </div>
                            <div class="ml-4">
                                <div class="text-base font-medium text-white">
                                    Styg(@styg50)
                                </div>
                                <div class="text-base font-medium text-teal-200">
                                    Ideascale member
                                </div>
                            </div>
                        </div>
                    </footer>
                </blockquote>
                <blockquote class="mt-6 md:flex-grow md:flex md:flex-col">
                    <div class="relative text-lg font-medium text-white md:flex-grow">
                        <svg class="absolute top-0 left-0 transform -translate-x-3 -translate-y-2 h-8 w-8 text-teal-600" fill="currentColor" viewBox="0 0 32 32">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                        </svg>
                        <p class="relative">
                            This is an exemplary proposal. Quickly three things: <br/> <br/>

                            the headline tells a story and entices. <br/> <br/>

                            I kinda love this part " FREE --> Organize and host a 24-hour
                            Governance-Day
                            Twitter marathon for each Voting Round in 2022 " <br/> <br/>

                            Addressing the Challenge Metric one by one. It seems like an obvious
                            thing
                            to do in a proposal, but often overlooked. <br/> <br/>

                            Very well done! I'm curious to read your "What makes a good proposal?"
                            blog post.
                            Cheers and I hope to see you and your journalism around here. Let's work
                            together to bring the issues of journalism to the conversation.
                        </p>
                    </div>
                    <footer class="mt-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 inline-flex rounded-full border-2 border-white">
                                <img class="h-12 w-12 rounded-full"
                                     src="{{asset('img/ideascale-logo.png')}}"
                                     alt="Ideascale logo">
                            </div>
                            <div class="ml-4">
                                <div class="text-base font-medium text-white">
                                    N S Lanier(@newman5)
                                </div>
                                <div class="text-base font-medium text-teal-200">
                                    Ideascale member
                                </div>
                            </div>
                        </div>
                    </footer>
                </blockquote>
            </div>
        </div>
    </section>

    <section class="relative pt-16 pb-32 z-10 overflow-hidden">
        <div aria-hidden="true" class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-gray-100"></div>
        <!--  Proposal Translation with Human QAl -->
        <div class="relative pt-16 pb-32 z-10 overflow-hidden">
            <div aria-hidden="true" class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-gray-100"></div>
            <div class="relative container">
                <div class="lg:mx-auto lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                    <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-16 lg:max-w-none lg:mx-0 lg:px-0">
                        <div class="mt-6">
                            <h2 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-3">
                                Proposal Translation with Human QA
                            </h2>
                            <p class="mb-4">
                                Our proposal to translate funded proposal details into spanish to empower spanish native
                                to help keep those theme accountable and learn from their successes.
                            </p>

                            <div class="flex flex-col gap-4">
                                <div>
                                    <div>
                                    <span
                                        class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                        <span class="text-xs">Problem</span>
                                    </span>
                                    </div>
                                    <div class="text-lg text-gray-500 mt-0">
                                        Proposal details & breakdowns are only available in English,
                                        excluding non-english speaking communities from participating in Auditing.
                                    </div>
                                </div>

                                <div>
                                    <div>
                                    <span
                                        class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        <span class="text-xs">Solution</span>
                                    </span>
                                    </div>
                                    <div class="text-lg text-gray-500 mt-0">
                                        Incentivize native Spanish-speakers to QA and edit machine translated funded proposals details and breakdowns in Spanish.                                    </div>
                                </div>

                                <div>
                                    <div>
                                    <span
                                        class="h-6 w-24 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-xs">Experience</span>
                                    </span>
                                    </div>
                                    <div class="text-lg text-gray-500 mt-0">
                                        We publish Cardano articles weekly, built a Catalyst research tool, & host daily twitter shows.
                                        We were funded by Catalyst to found a mentoring & outreach Lab in Kenya, & to translate our Content Library into Swahili & Spanish.
                                        Blockchain developer, Tech evangelist, Web designer.

                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="https://cardano.ideascale.com/c/idea/402831/comments"
                                   target="_blank"
                                   class="inline-flex bg-gradient-to-r from-secondary-600 to-primary-600 bg-origin-border px-4 py-2 border border-transparent text-base font-medium rounded-sm shadow-sm text-white hover:from-secondary-700 hover:to-primary-700">
                                    Leave a feedback on Ideascale
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 sm:mt-16 lg:mt-0">
                        <div class="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                            <img
                                class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none"
                                src="{{asset('img/leonardo-toshiro-catalyst-spanish-proposal-unsplash.jpeg')}}"
                                alt="Inbox user interface">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Open Source Translate 2 Earn Webapp -->
        <div class="mt-24">
            <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
                <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-32 lg:max-w-none lg:mx-0 lg:px-0 lg:col-start-2">
                    <h2 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-1">
                        Open Source Translate 2 Earn Webapp
                    </h2>
                    <p class="mb-6">
                        Our proposal to opensource our translation management system and add more features to it to power translations across Cardano!
                    </p>

                    <div class="flex flex-col gap-4">
                        <div>
                            <div>
                                <span
                                    class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    <span class="text-xs">Problem</span>
                                </span>
                            </div>
                            <div class="text-lg text-gray-500 mt-0">
                                There is no Open Source crowd sourcing translation tool.
                                All Cardano websites & communities need translation work & a way to pay translators.
                            </div>
                        </div>

                        <div>
                            <div>
                                <span
                                    class="h-6 w-20 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span class="text-xs">Solution</span>
                                </span>
                            </div>
                            <div class="text-lg text-gray-500 mt-0">
                                Opensource our current translation tool so anyone can deploy it to manage translations &
                                compensate participation using ADA or Native Tokens.
                            </div>
                        </div>

                        <div>
                            <div>
                                <span
                                    class="h-6 w-24 rounded-sm flex items-center gap-1 justify-center bg-gradient-to-r from-secondary-600 to-primary-600 text-white font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs">Experience</span>
                                </span>
                            </div>
                            <div class="text-lg text-gray-500 mt-0">
                                14+ years of software and cloud system engineering.
                                Built a Catalyst research and crowd sourcing translation tool, host daily twitter shows,
                                founded a blockchain software mentoring & outreach Lab in Kenya.
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="https://cardano.ideascale.com/c/idea/402656/comments"
                           target="_blank"
                           class="inline-flex bg-gradient-to-r from-secondary-600 to-primary-600 bg-origin-border px-4 py-2 border border-transparent text-base font-medium rounded-sm shadow-sm text-white hover:from-secondary-700 hover:to-primary-700">
                            Leave a feedback on Ideascale
                        </a>
                    </div>
                </div>
                <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-start-1">
                    <div class="pr-4 -ml-48 sm:pr-6 md:-ml-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
                        <img
                            class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:right-0 lg:h-full lg:w-auto lg:max-w-none"
                            src="{{asset('img/annie-spratt-catalyst-crowd-source-proposal-unsplash.jpeg')}}"
                            alt="Ethereum Cardano logos">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats section -->
{{--    <div class="relative bg-gray-900">--}}
{{--        <div class="h-80 absolute inset-x-0 bottom-0 xl:top-0 xl:h-full">--}}
{{--            <div class="h-full w-full xl:grid xl:grid-cols-2">--}}
{{--                <div class="h-full xl:relative xl:col-start-2">--}}
{{--                    <img class="h-full w-full object-cover opacity-25 xl:absolute xl:inset-0"--}}
{{--                         src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100"--}}
{{--                         alt="People working on laptops">--}}
{{--                    <div aria-hidden="true"--}}
{{--                         class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-gray-900 xl:inset-y-0 xl:left-0 xl:h-full xl:w-32 xl:bg-gradient-to-r"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div--}}
{{--            class="max-w-4xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8 xl:grid xl:grid-cols-2 xl:grid-flow-col-dense xl:gap-x-8">--}}
{{--            <div class="relative pt-12 pb-64 sm:pt-24 sm:pb-64 xl:col-start-1 xl:pb-24">--}}
{{--                <h2 class="text-sm font-semibold tracking-wide uppercase">--}}
{{--                    <span class="bg-gradient-to-r from-secondary-300 to-primary-300 bg-clip-text text-transparent">Valuable Metrics</span>--}}
{{--                </h2>--}}
{{--                <p class="mt-3 text-3xl font-extrabold text-white">--}}
{{--                    LIDO Nation on Catalyst by the Numbers--}}
{{--                </p>--}}
{{--                <p class="mt-5 text-lg text-gray-300">--}}
{{--                    We been active participants of project catalyst since Fund 5. Our first proposal came in fund 6. Don't take our words for it, here are the numbers.--}}
{{--                </p>--}}
{{--                <div class="mt-12 grid grid-cols-1 gap-y-12 gap-x-6 sm:grid-cols-2">--}}
{{--                    <p>--}}
{{--                        <span class="block text-2xl font-bold text-white">5</span>--}}
{{--                        <span class="mt-1 block text-base text-gray-300"><span--}}
{{--                                class="font-medium text-white">Funded</span> proposals across all funds.</span>--}}
{{--                    </p>--}}

{{--                    <p>--}}
{{--                        <span class="block text-2xl font-bold text-white">3</span>--}}
{{--                        <span class="mt-1 block text-base text-gray-300"><span class="font-medium text-white">Completed</span> proposals across all funds.</span>--}}
{{--                    </p>--}}

{{--                    <p>--}}
{{--                        <span class="block text-2xl font-bold text-white">98%</span>--}}
{{--                        <span class="mt-1 block text-base text-gray-300"><span class="font-medium text-white">Customer satisfaction</span> laoreet amet lacus nibh integer quis.</span>--}}
{{--                    </p>--}}

{{--                    <p>--}}
{{--                        <span class="block text-2xl font-bold text-white">12M+</span>--}}
{{--                        <span class="mt-1 block text-base text-gray-300"><span class="font-medium text-white">Issues resolved</span> lacus nibh integer quis.</span>--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- CTA Section -->
    <div class="bg-gray-200">
        <div
            class="max-w-4xl mx-auto py-16 px-4 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-2sxl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                <span class="block">Ready to help drive innovation in Cardano?</span>
                <span class="block bg-gradient-to-r from-secondary-600 to-primary-600 bg-clip-text text-transparent">
                    Create an account, jump in, and earn some ADA!
                </span>
            </h2>
            <div class="mt-6 space-y-4 sm:space-y-0 sm:flex sm:space-x-5">
                <a href="https://cardano.ideascale.com/"
                   target="_blank"
                   class="flex items-center justify-center bg-gradient-to-r from-secondary-600 to-primary-600 bg-origin-border px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white hover:from-secondary-700 hover:to-primary-700">
                    Get started</a>
            </div>
        </div>
    </div>

</div>
