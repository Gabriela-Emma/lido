<div>
    <div class="lg:border-t lg:border-b lg:border-gray-300" x-data="voteSubmission">
        <!-- Navigation -->
        <nav x-transition x-show="validationComplete !== true" class="px-4 mx-auto border-b max-w-7xl sm:px-6 lg:px-8"
            aria-label="Progress" x-cloak>
            <ol role="list"
                class="overflow-hidden rounded-sm lg:flex lg:border-l lg:border-r lg:border-gray-300 lg:rounded-none">
                <li class="relative overflow-hidden lg:flex-1">
                    <div class="overflow-hidden border border-gray-300 lg:border-0">
                        <a href="#" @click.prevent="goToStep(1)" aria-current="step" class="group">
                        <span
                            :class="{
                                'bg-primary-900': active(1) || completed(1),
                                'bg-transparent group-hover:bg-gray-200': !active(1)
                            }"
                            class="absolute top-0 left-0 w-1 h-full lg:w-full lg:h-1 lg:bottom-0 lg:top-auto"
                            aria-hidden="true"></span>
                            <span class="flex items-start px-6 py-5 text-sm font-medium lg:pl-9">
                            <span class="flex-shrink-0">
                            <span
                                :class="{
                                'bg-primary-900': completed(1),
                                'border-primary-900': active(1) || completed(1),
                                'border-gray-300': !active(1) && !completed(1)
                                }"
                                class="flex items-center justify-center w-10 h-10 border-2 rounded-full">
                                <svg
                                    x-show="completed(1)" x-transition
                                    class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"/>
                                </svg>
                                <span :class="{
                                'text-teal-900': active(1),
                                'text-gray-500': !active(1)
                                }" x-show="!completed(1)" x-transition>01</span>
                            </span>
                            </span>
                            <span class="mt-0.5 ml-4 min-w-0 flex flex-col">
                                <span
                                    :class="{
                                        'text-teal-900': active(1),
                                        'text-gray-500': !active(1),
                                    }"
                                    class="text-xs font-semibold tracking-wide uppercase">Create</span>
                                <span class="text-sm font-medium text-gray-500">Create vote</span>
                            </span>
                        </span>
                        </a>

                        <!-- Separator -->
                        <div class="absolute inset-0 top-0 left-0 hidden w-3 lg:block" aria-hidden="true">
                            <svg class="w-full h-full text-gray-300" viewBox="0 0 12 82" fill="none"
                                preserveAspectRatio="none">
                                <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor"
                                    vector-effect="non-scaling-stroke"/>
                            </svg>
                        </div>
                    </div>
                </li>

                <li class="relative overflow-hidden lg:flex-1">
                    <div class="overflow-hidden border border-gray-300 lg:border-0">
                        <a href="#" @click.prevent="goToStep(2)" aria-current="step" class="group">
                        <span
                            :class="{
                                'bg-primary-900': active(2) || completed(2),
                                'bg-transparent group-hover:bg-gray-200': !active(2)
                            }"
                            class="absolute top-0 left-0 w-1 h-full lg:w-full lg:h-1 lg:bottom-0 lg:top-auto"
                            aria-hidden="true"></span>
                            <span class="flex items-start px-6 py-5 text-sm font-medium lg:pl-9">
                            <span class="flex-shrink-0">
                            <span
                                :class="{
                                'bg-primary-900': completed(2),
                                'border-primary-900': active(2) || completed(2),
                                'border-gray-300': !active(2) && !completed(2)
                                }"
                                class="flex items-center justify-center w-10 h-10 border-2 rounded-full">
                                <svg
                                    x-show="completed(2)" x-transition
                                    class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"/>
                                </svg>
                                <span :class="{
                                'text-teal-900': active(2),
                                'text-gray-500': !active(2)
                                }" x-show="!completed(2)" x-transition>02</span>
                            </span>
                            </span>
                            <span class="mt-0.5 ml-4 min-w-0 flex flex-col">
                                <span
                                    :class="{
                                        'text-teal-900': active(2),
                                        'text-gray-500': !active(2),
                                    }"
                                    class="text-xs font-semibold tracking-wide uppercase">Submit</span>
                                <span class="text-sm font-medium text-gray-500">Submit Vote</span>
                            </span>
                        </span>
                        </a>

                        <!-- Separator -->
                        <div class="absolute inset-0 top-0 left-0 hidden w-3 lg:block" aria-hidden="true">
                            <svg class="w-full h-full text-gray-300" viewBox="0 0 12 82" fill="none"
                                preserveAspectRatio="none">
                                <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor"
                                    vector-effect="non-scaling-stroke"/>
                            </svg>
                        </div>
                    </div>
                </li>

                <li class="relative overflow-hidden lg:flex-1">
                    <div class="overflow-hidden border border-t-0 border-gray-300 rounded-b-md lg:border-0">
                        <a href="#" @click.prevent="goToStep(3)" aria-current="step" class="group">
                        <span
                            :class="{
                                'bg-primary-900': active(3) || completed(3),
                                'bg-transparent group-hover:bg-gray-200': !active(3)
                            }"
                            class="absolute top-0 left-0 w-1 h-full lg:w-full lg:h-1 lg:bottom-0 lg:top-auto"
                            aria-hidden="true"></span>
                            <span class="flex items-start px-6 py-5 text-sm font-medium lg:pl-9">
                            <span class="flex-shrink-0">
                            <span
                                :class="{
                                    'bg-primary-900': completed(3),
                                    'border-primary-900': active(3) || completed(3),
                                    'border-gray-300': !active(3) && !completed(3)
                                }"
                                class="flex items-center justify-center w-10 h-10 border-2 rounded-full">
                                <svg
                                    x-show="completed(3)" x-transition
                                    class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"/>
                                </svg>
                                <span :class="{
                                'text-teal-900': active(3),
                                'text-gray-500': !active(3)
                                }" x-show="!completed(3)" x-transition>03</span>
                            </span>
                            </span>
                            <span class="mt-0.5 ml-4 min-w-0 flex flex-col">
                            <span
                                :class="{
                                    'text-teal-900': active(3),
                                    'text-gray-500': !active(3),
                                }"
                                class="text-xs font-semibold tracking-wide uppercase">Confirmation</span>
                            <span
                                class="text-sm font-medium text-gray-500">Confirm Vote</span>
                            </span>
                        </span>
                        </a>
                        <!-- Separator -->
                        <div class="absolute inset-0 top-0 left-0 hidden w-3 lg:block" aria-hidden="true">
                            <svg class="w-full h-full text-gray-300" viewBox="0 0 12 82" fill="none"
                                preserveAspectRatio="none">
                                <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor"
                                    vector-effect="non-scaling-stroke"/>
                            </svg>
                        </div>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Step 1 -->
        <div class="p-8" x-show="active(1)" x-transition wire:key="mintStep1">
            <div class="bg-white">
                <div class="bg-primary-50 bg-opacity-20">
                    <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:py-24 lg:px-8 lg:flex lg:items-center lg:justify-between">
                        <div class="min-w-25">
                            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 md:text-4xl">
                                <span class="block">Thanks for voting</span>
                                @if($this->cause)
                                    for <span class="inline-block text-teal-600">{{$this->cause?->title}}!</span>
                                @endif
                            </h2>
                            @if($votes)
                                <div class="mt-8 max-w-2xl border border-primary-800">
                                    <h3 class="mb-2 px-3 py-1">Recent Votes</h3>
                                    @foreach($votes as $vote)
                                        <div class="">
                                            <hr class="border-primary-800 border-t-0 border-b my-0" />
                                            <div>
                                                <ul role="list" class="divide-y divide-gray-200">
                                                    <li class="px-3 py-4">
                                                        <div class="flex space-x-3">
                                                            <img class="h-6 w-6 rounded-full" src="{{$vote->cause?->thumbnail_url}}" alt="">
                                                            <div class="flex-1 space-y-1">
                                                                <div class="flex items-center justify-between">
                                                                    <h3 class="text-sm font-semibold text-teal-900">
                                                                        {{$vote?->cause?->title}}
                                                                    </h3>
                                                                    <p class="text-sm text-teal-900">
                                                                        <x-carbon :date="$vote->updated_at" human />
                                                                    </p>
                                                                </div>
                                                                <div class="text-sm text-teal-900 flex flex-row gap-3">
                                                                    <div>
                                                                        <span>Amount:</span>
                                                                        <span>
                                                                            {{humanNumber($vote->amount)}}
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span>Status:</span>
                                                                        <span>
                                                                            {{$vote->status}}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="flex mt-8 lg:mt-0 lg:flex-shrink-0">
                            @if($this->phuffyUtxosBalance > 5000000)
                                <div class="inline-flex rounded-md shadow">
                                    <button
                                        wire:click='startVote()'
                                        class="inline-flex items-center justify-center px-5 py-3 text-xl font-medium text-white border border-transparent rounded-sm hover:text-gray-100 bg-primary-900 hover:bg-primary-1000">
                                        {{!!$this->vote ? 'Resume' : 'Start'}}
                                    </button>
                                </div>
                            @else
                                <p class="w-40 text-center text-gray-700">
                                    You must have more than 5M PHUFFY to vote.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="p-8" x-show="active(2)" x-transition wire:key="mintStep2">
            <div class="bg-white">
                <div class="px-4 py-16 mx-auto max-w-7xl sm:py-24 sm:px-6 lg:px-8 lg:flex lg:justify-between">
                    @if(isset($voteDepositAddress['id']) && $voteDepositAddress['qr'])
                        <div x-transition
                            wire:poll.visible="checkWalletBalance"
                            class="grid items-start w-full grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-12 lg:items-center lg:gap-x-8">
                            <div class="overflow-hidden rounded-sm sm:col-span-4 lg:col-span-5">
                                <img src="{{$voteDepositAddress['qr']}}"
                                    alt="ADA Address QR Code." class="object-scale-down object-center w-full qr-code"
                                    id="step-1-qr-code"/>
                            </div>

                            <div class="sm:col-span-8 lg:col-span-7">
                                <h2 class="font-semibold text-gray-900">
                                    Send send a minimum of 5 Million Phuffy to this address.
                                </h2>

                                <section aria-labelledby="information-heading" class="flex flex-col gap-8 mt-4">
                                    <h3 id="information-heading" class="sr-only">ADA Address</h3>
                                    <div>
                                        <p>
                                            <span
                                                class="text-2xl font-semibold text-gray-900 break-all select-all cursor-text">
                                                {{$voteDepositAddress['id']}}
                                            </span>
                                            <button type="button" @click="$clipboard('{{$voteDepositAddress['id']}}')">
                                                <span @click="copyAddress()"
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-sm font-medium bg-primary-400 hover:bg-primary-600 text-white">
                                                    <svg x-transition.scale.400
                                                            x-transition:enter.duration.50ms
                                                            x-transition:leave.duration.100ms
                                                            :class="{'text-pink-300': !addressCopied, 'text-accent-500': addressCopied}"
                                                            class="-ml-0.5 mr-1.5 h-2 w-2" fill="currentColor"
                                                            viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3"/>
                                                    </svg>
                                                    <span x-show="!addressCopied">Copy &nbsp;</span>
                                                    <span x-show="addressCopied">Copied</span>
                                                </span>
                                            </button>
                                        </p>
                                    </div>

                                    @if($this->currentStep === 2)
                                        <div x-transition>
                                            @if($this->utxos && $this->utxos->isNotEmpty())
                                                <p>
                                                    <b>Votes Received:</b>
                                                </p>

                                                <div>
                                                    @foreach($utxos as $utxo)
                                                        <div>
                                                            <hr/>
                                                            {{$utxo->quantityFormatted}} PHUFFY
                                                        </div>
                                                    @endforeach
                                                    <hr/>
                                                    <div>
                                                        <button
                                                            @click="next()"
                                                            class="inline-flex justify-center px-4 py-1 font-semibold text-white border border-transparent rounded-sm shadow-xs bg-accent-700 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                                            Next
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                <p>
                                                    <span
                                                        class="flex flex-row gap-2 font-semibold bg-white text-teal-900">
                                                        <svg
                                                            class="w-5 h-5 border-t-2 border-b-2 rounded-full animate-spin border-primary-900"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                                    stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                        <span>Checking for deposit. This can take up to 2 minutes after you send the funds.</span>
                                                    </span>
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </section>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div x-show="active(3)" class="p-8" x-transition wire:key="mintStep3">
            <div class="bg-white">
                <div x-show="!completed(3)" x-transition>
                    <div class="py-12 overflow-hidden bg-gray-50">
                        <div class="relative max-w-xl px-4 mx-auto sm:px-6 lg:px-8 lg:max-w-7xl">
                            <svg class="absolute hidden transform -translate-x-1/2 lg:block left-full -translate-y-1/4" width="404" height="784" fill="none" viewBox="0 0 404 784" aria-hidden="true">
                                <defs>
                                <pattern id="b1e6e422-73f8-40a6-b5d9-c8586e37e0e7" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                    <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                                </pattern>
                                </defs>
                                <rect width="404" height="784" fill="url(#b1e6e422-73f8-40a6-b5d9-c8586e37e0e7)" />
                            </svg>

                            <div class="relative mt-2 lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                                <div class="relative">
                                    <h3 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                                        You're about to submit your vote!
                                    </h3>
                                    <p class="mt-3 text-lg text-gray-500">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur minima sequi recusandae, porro maiores officia assumenda aliquam laborum ab aliquid veritatis impedit odit adipisci optio iste blanditiis facere. Totam, velit.
                                    </p>

                                    <dl class="mt-10 space-y-10">
                                        <div class="relative">
                                            <dt>
                                                <div class="absolute flex items-center justify-center w-12 h-12 text-white bg-indigo-500 rounded-md">
                                                <!-- Heroicon name: outline/globe-alt -->
                                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                </svg>
                                                </div>
                                                <p class="ml-16 text-lg font-medium leading-6 text-gray-900">Competitive exchange rates</p>
                                            </dt>
                                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.
                                            </dd>
                                        </div>

                                        <div class="relative">
                                            <dt>
                                                <div class="absolute flex items-center justify-center w-12 h-12 text-white bg-indigo-500 rounded-md">
                                                <!-- Heroicon name: outline/scale -->
                                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                                </svg>
                                                </div>
                                                <p class="ml-16 text-lg font-medium leading-6 text-gray-900">No hidden fees</p>
                                            </dt>
                                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.
                                            </dd>
                                        </div>

                                        <div class="relative">
                                            <dt>
                                                <div class="absolute flex items-center justify-center w-12 h-12 text-white bg-indigo-500 rounded-md">
                                                <!-- Heroicon name: outline/lightning-bolt -->
                                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                                </div>
                                                <p class="ml-16 text-lg font-medium leading-6 text-gray-900">Transfers are instant</p>
                                            </dt>
                                            <dd class="mt-2 ml-16 text-base text-gray-500">
                                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maiores impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.
                                            </dd>
                                        </div>
                                    </dl>
                                </div>

                                <div class="relative p-12 mt-10 -mx-4 lg:mt-0" aria-hidden="true">
                                    <div class="pt-10 bg-white rounded-md shadow-md">
                                        <svg class="absolute transform -translate-x-1/2 translate-y-16 left-1/2 lg:hidden" width="784" height="404" fill="none" viewBox="0 0 784 404">
                                            <defs>
                                                <pattern id="ca9667ae-9f92-4be7-abcb-9e3d727f2941" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                                    <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                                                </pattern>
                                            </defs>
                                            <rect width="784" height="404" fill="url(#ca9667ae-9f92-4be7-abcb-9e3d727f2941)" />
                                        </svg>
                                        <div class="px-6">
                                            <h3 class="font-semibold">Vote Details</h3>
                                            <p>When you hit submit, your vote will be submitted to the blockchain.</p>
                                        </div>
                                        <div class="flex flex-col gap-6 mt-8 mb-6">
                                            <div>
                                                <div class="px-6 mb-6">
                                                    <label for="cause" class="block text-sm font-medium text-gray-700">Cause</label>
                                                    <div class="mt-1">
                                                        <select id="cause" name="cause" autocomplete="false" disabled="disabled"
                                                            class="block w-full border-gray-300 rounded-sm shadow-sm focus:ring-primary-900 focus:border-primary-900 sm:text-sm">
                                                            <option value="{{$cause->id}}">
                                                                {{$cause->title}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr class="mb-0 border-gray-200" />
                                            </div>

                                            <div>
                                                <div class="px-6">
                                                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                                    <div class="mt-1">
                                                        <input type="text" name="amount" id="amount" value="{{humanNumber($this->voteDepositWalletBalance)}}"
                                                        autocomplete="false" disabled="disabled"
                                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-900 focus:border-primary-900 sm:text-sm">
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="px-6">
                                                    <button type="button" class="flex items-center justify-between w-full p-2 space-x-3 text-left border border-gray-300 rounded-md shadow-sm hover:cursor-default group focus:outline-none">
                                                        <span class="flex items-center flex-1 min-w-0 space-x-3">
                                                            <span class="flex-shrink-0 block">
                                                                <div class="w-10 h-10 rounded-full bg-primary-900"></div>
                                                            </span>
                                                            <span class="flex-1 block min-w-0">
                                                                <span class="block text-sm font-medium text-gray-900 truncate">
                                                                    Balance after vote
                                                                </span>
                                                                <span class="block text-sm font-medium text-gray-500 truncate">
                                                                    {{humanNumber($this->phuffyUtxosBalance - $this->voteDepositWalletBalance, 2)}}
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <footer class="p-6 bg-gray-50 flex justify-between">
                                            <div wire:loading.class.remove="hidden" wire:loading.delay.shortest.class="block" wire:target="submitVote"
                                                class="p-0 hidden">
                                                <svg class="relative w-8 h-8 border-t-2 border-b-2 rounded-full animate-spin border-primary-600"
                                                     viewBox="0 0 24 24"></svg>
                                            </div>

                                            <div class="flex flex-row justify-end gap-4 ml-auto">
                                                {{-- <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-primary-100 hover:bg-primary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                    Cancel
                                                </button> --}}
                                                <button
                                                    wire:click='submitVote()'
                                                    type="button"
                                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-primary-900 hover:bg-primary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                    Submit
                                                </button>
                                            </div>
                                        </footer>
                                    </div>
                                </div>
                            </div>

                            <svg class="absolute hidden transform translate-x-1/2 translate-y-12 lg:block right-full" width="404" height="784" fill="none" viewBox="0 0 404 784" aria-hidden="true">
                                <defs>
                                    <pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                        <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                                    </pattern>
                                </defs>
                                <rect width="404" height="784" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div x-show="completed(3)" x-transition>
                    <div class="relative bg-white overflow-hidden">
                        <div class="max-w-7xl mx-auto">
                            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                                    <polygon points="50,0 100,0 50,100 0,100" />
                                </svg>

                                <div>
                                    <div class="relative pt-6 px-4 sm:px-6 lg:px-8">

                                    </div>
                                </div>

                                <div class="lg:text-left flex flex-col justify-start gap-6 h-full px-8">
                                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                        <span class="block xl:inline">
                                            Vote Submitted
                                        </span>
                                        <span class="block text-teal-800 xl:inline">
                                            Successfully!
                                        </span>
                                    </h1>
                                    <div>
                                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                            Your vote was successfully submitted our Governor's address.
                                            All votes will be tallied April 1st. Winning cause will receive ada then.
                                            We've also sent <span class="font-semibold text-teal-700">5 MAJI</span> along with a refund of your voting cost.
                                        </p>
                                    </div>
                                    <div class="mt-5 sm:mys-8 sm:flex sm:justify-center lg:justify-start">
                                        <div class="rounded-md shadow">
                                            <a href="#" class="w-full flex items-center justify-center px-8 py-3 gap-2 flex-no-wrap border border-transparent text-base font-medium rounded-sm text-white bg-teal-800 hover:bg-primary-700 md:py-4 md:text-sm md:px-10 hover:text-white">
                                                <span>View on Blockchain</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="mt-3 sm:mt-0 sm:ml-3">
                                            <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-sm text-teal-700 bg-primary-100 hover:bg-primary-200 md:py-4 md:text-sm md:px-10 hover:text-white">
                                                PHUFFY Coin Landing Page
                                            </a>
                                        </div>
                                    </div>
                                    <div class="max-w-md relative top-7 md:top-16 lg:top-24 xl:top-28">
                                        <p class="text-xs text-gray-600">
                                            MAJI is LIDO Pool Cardano Native token that you can use to buy physical and digital productions from the lido marketplace.
                                            Marketplace coming soon!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://storage.googleapis.com/www.lidonation.com/165/brigitte-tohm-enjoy-the-little-things-unsplash.jpeg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Errors -->
        @if($errors->isNotEmpty())
            <x-public.errors :errors="$errors"></x-public.errors>
        @endif
    </div>

    <script type="text/javascript">
        window.voteSubmission = function voteSubmission() {
            return {
                address: null,
                addressCopied: false,
                amountCopied: false,
                completedSteps: [<?php echo implode(',', $this->completedSteps); ?>],
                currentWork: 'Retrieving a new deposit wallet',
                voteDepositWalletBalance: <?php echo $this->voteDepositWalletBalance; ?>,
                errors: [],
                isDelegator: null,
                isDelegatorInterval: null,
                nftAuthenticated: false,
                nftAuthIssuedInterval: null,
                paymentReceivedInterval: null,
                paymentReceived: false,
                refundAmount: null,
                step: <?php echo $this->currentStep; ?>,
                validationComplete: false,
                working: false,
                async init() {
                    Livewire.on('voteSubmitted', postId => {
                        this.completedSteps.push(1);
                        this.completedSteps.push(2);
                        this.step = 3;
                    });
                },
                next() {
                    if (this.completedSteps.includes(this.step + 1)) {
                        return null;
                    }
                    this.completeStep(this.step);
                    this.step = this.step + 1;
                },
                prev() {
                    if ((this.step - 1) > 0) {
                        this.step = this.step - 1;
                    }
                },
                goToStep(step) {
                    if (step <= 0) {
                        return null;
                    }
                    this.step = step;
                },
                completeStep(step) {
                    this.completedSteps.push(step);
                },
                active(step) {
                    return this.step === step;
                },
                completed(step) {
                    return this.completedSteps.includes(step);
                },
                copyAddress() {
                    this.addressCopied = true;
                    setTimeout(() => this.addressCopied = false, 3000);
                },
                copyAmount() {
                    this.amountCopied = true;
                    setTimeout(() => this.amountCopied = false, 3000);
                },
                setPaymentReceive() {

                },
                isValidating() {

                },
                pushError(error) {
                    this.errors.push(error);
                    setTimeout(() => {
                        this.errors = [];
                    }, 15000);
                }
            }
        }
    </script>
</div>
