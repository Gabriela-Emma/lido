<div>
    <div class="lg:border-t lg:border-b lg:border-gray-300" x-data="delegatorRegistration">
        <!-- Navigation -->
        <nav x-transition x-show="validationComplete !== true" class="px-4 mx-auto border-b max-w-7xl sm:px-6 lg:px-8"
             aria-label="Progress" x-cloak>
            <ol role="list"
                class="overflow-hidden rounded-sm lg:flex lg:border-l lg:border-r lg:border-gray-300 lg:rounded-none">
                <li class="relative overflow-hidden lg:flex-1">
                    <div class="overflow-hidden border border-b-0 border-gray-300 rounded-t-md lg:border-0">
                        <a href="#" @click.prevent="goToStep(1)" aria-current="step" class="group">
                        <span
                            :class="{
                                'bg-primary-600': active(1) || completed(1),
                                'bg-transparent group-hover:bg-gray-200': !active(1)
                            }"
                            class="absolute top-0 left-0 w-1 h-full lg:w-full lg:h-1 lg:bottom-0 lg:top-auto"
                            aria-hidden="true"></span>
                            <span class="flex items-start px-6 py-5 text-sm font-medium lg:pl-9">
                            <span class="flex-shrink-0">
                            <span
                                :class="{
                                'bg-primary-600': completed(1),
                                'border-primary-600': active(1) || completed(1),
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
                                'text-teal-600': active(1),
                                'text-gray-500': !active(1)
                                }" x-show="!completed(1)" x-transition>01</span>
                            </span>
                            </span>
                            <span class="mt-0.5 ml-4 min-w-0 flex flex-col">
                                <span
                                    :class="{
                                        'text-teal-600': active(1),
                                        'text-gray-500': !active(1),
                                    }"
                                    class="text-xs font-semibold tracking-wide uppercase">Details</span>
                                <span class="text-sm font-medium text-gray-500">Minting information.</span>
                            </span>
                        </span>
                        </a>
                    </div>
                </li>

                <li class="relative overflow-hidden lg:flex-1">
                    <div class="overflow-hidden border border-gray-300 lg:border-0">
                        <a href="#" @click.prevent="goToStep(2)" aria-current="step" class="group">
                        <span
                            :class="{
                                'bg-primary-600': active(2) || completed(2),
                                'bg-transparent group-hover:bg-gray-200': !active(2)
                            }"
                            class="absolute top-0 left-0 w-1 h-full lg:w-full lg:h-1 lg:bottom-0 lg:top-auto"
                            aria-hidden="true"></span>
                            <span class="flex items-start px-6 py-5 text-sm font-medium lg:pl-9">
                            <span class="flex-shrink-0">
                            <span
                                :class="{
                                'bg-primary-600': completed(2),
                                'border-primary-600': active(2) || completed(2),
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
                                'text-teal-600': active(2),
                                'text-gray-500': !active(2)
                                }" x-show="!completed(2)" x-transition>02</span>
                            </span>
                            </span>
                            <span class="mt-0.5 ml-4 min-w-0 flex flex-col">
                                <span
                                    :class="{
                                        'text-teal-600': active(2),
                                        'text-gray-500': !active(2),
                                    }"
                                    class="text-xs font-semibold tracking-wide uppercase">Payment</span>
                                <span class="text-sm font-medium text-gray-500">Submit ADA to wrap.</span>
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
                                'bg-primary-600': active(3) || completed(3),
                                'bg-transparent group-hover:bg-gray-200': !active(3)
                            }"
                            class="absolute top-0 left-0 w-1 h-full lg:w-full lg:h-1 lg:bottom-0 lg:top-auto"
                            aria-hidden="true"></span>
                            <span class="flex items-start px-6 py-5 text-sm font-medium lg:pl-9">
                            <span class="flex-shrink-0">
                            <span
                                :class="{
                                'bg-primary-600': completed(3),
                                'border-primary-600': active(3) || completed(3),
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
                                'text-teal-600': active(3),
                                'text-gray-500': !active(3)
                                }" x-show="!completed(2)" x-transition>03</span>
                            </span>
                            </span>
                            <span class="mt-0.5 ml-4 min-w-0 flex flex-col">
                            <span
                                :class="{
                                    'text-teal-600': active(3),
                                    'text-gray-500': !active(3),
                                }"
                                class="text-xs font-semibold tracking-wide uppercase">Mint Preview</span>
                            <span
                                class="text-sm font-medium text-gray-500">Details about the mint and distribution.</span>
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
        <div class="p-8 border-t" x-show="active(1)" x-transition wire:key="mintStep1">
            <div class="relative flex flex-col max-w-lg gap-4 p-4 text-white rounded-sm bg-primary-600">
                <div class="top-0 left-0 flex items-center justify-center hidden w-full h-full bg-white bg-opacity-90"
                     wire:loading.class.remove="hidden" wire:loading.class="absolute" wire:target="submitDetails">
                    <svg class="w-10 h-10 border-t-2 border-b-2 rounded-full animate-spin border-primary-600"
                         viewBox="0 0 24 24"></svg>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="type" class="block font-semibold">Mint Type</label>
                    <select id="type" name="type" autocomplete="off" wire:model.defer="mintType"
                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border rounded-sm shadow-xs border-accent-600 focus:outline-none focus:ring-accent-600 focus:border-accent-600 sm:text-sm">
                        <option value="pool">Pool</option>
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="epoch" class="block font-semibold">Epoch</label>
                    <input type="number"
                           name="epoch"
                           id="epoch"
                           min="1"
                           max="{{$currEpoch - 1}}"
                           wire:model.defer="mintEpoch"
                           autocomplete="off"
                           class="block w-full mt-1 text-gray-700 border-gray-300 rounded-sm shadow-xs focus:ring-accent-600 focus:border-accent-600">
                    <div class="p-1 text-sm text-white">
                        Current Epoch: <span class="font-semibold">{{$currEpoch}}</span>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="memo" class="block font-semibold">Memo</label>
                    <input type="text"
                           name="memo"
                           id="memo"
                           wire:model.defer="mintMemo"
                           autocomplete="off"
                           class="block w-full mt-1 text-gray-700 border-gray-300 rounded-sm shadow-xs focus:ring-accent-600 focus:border-accent-600">
                </div>

                <button
                    wire:click="submitDetails"
                    class="inline-flex justify-center px-4 py-1 font-semibold text-white border border-transparent rounded-sm shadow-xs bg-accent-700 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                    Next
                </button>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="p-8" x-show="active(2)" x-transition wire:key="mintStep2">
            <div class="relative flex flex-col max-w-lg gap-4 p-4 text-white rounded-sm bg-primary-600">
                <div class="col-span-6 sm:col-span-3">
                    <label for="depositWalletBalance" class="block font-semibold">
                        Amount to distribute
                    </label>
                    <input type="number"
                           name="depositWalletBalance"
                           id="depositWalletBalance"
                           wire:model.defer="depositWalletBalance"
                           autocomplete="off"
                           class="block w-full mt-1 text-gray-700 border-gray-300 rounded-sm shadow-xs focus:ring-accent-600 focus:border-accent-600" />
                </div>

                <button
                    wire:click="generateMintDetails"
                    class="inline-flex justify-center px-4 py-1 font-semibold text-white border border-transparent rounded-sm shadow-xs bg-accent-700 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                    Preview
                </button>
            </div>
        </div>

        <!-- Step 3 -->
        <div x-show="active(3)" class="p-8" x-transition wire:key="mintStep3">
            <div class="bg-white">
                @if($this->mint?->status === 'minted')
                    <div>
                        <header>
                            <h1 class="flex gap-4">
                                Mint Completed
                            </h1>
                            <div class="flex gap-5">
                                <div class="flex gap-1">
                                    <div class="font-thin">Memo:</div>
                                    <div class="font-semibold">{{$mint?->memo}}</div>
                                </div>
                                @isset($depositAddress['id'])
                                    <div class="flex gap-1">
                                        <div class="font-thin">View on Explorer:</div>
                                        <div class="font-semibold">
                                            <a target="_blank"
                                               href="//{{config('cardano.explorer')}}/address/{{$depositAddress['id']}}">{{config('cardano.explorer')}}</a>
                                        </div>
                                    </div>
                                @endisset
                            </div>
                            <hr/>
                            <div class="flex gap-5">
                                <div class="flex gap-1">
                                    <div class="font-thin">Amount:</div>
                                    <div class="font-semibold">₳ {{$mint->mint_seed_amount / 1000000}}</div>
                                </div>
                                <div class="flex gap-1">
                                    <div class="font-thin">Epoch:</div>
                                    <div class="font-semibold">{{$mint?->epoch ?? '-'}}</div>
                                </div>
                                <div class="flex gap-1">
                                    <div class="font-thin">Qualified Users:</div>
                                    <div class="font-semibold">{{$mintTxs?->count() ?? '-'}}</div>
                                </div>
                                <div class="flex gap-1">
                                    <div class="font-thin">Date:</div>
                                    <div class="font-semibold">{{$mint?->created_at}}</div>
                                </div>
                                <div class="flex gap-1">
                                    <div class="font-thin">Issue By:</div>
                                    <div class="font-semibold">{{$mint?->author}}</div>
                                </div>
                            </div>
                            <hr/>
                        </header>
                        <div class="">
                            <h2>Distribution Details</h2>
                            <x-portal.mint-tx-table :mintTxs="$mintTxs"/>
                        </div>
                    </div>
                @endif
                @if($this->mint?->status !== 'minted' && $this->mintTxs && $this->mintTxs?->isNotEmpty())
                    <div class="flex flex-col gap-4 mx-auto max-w-7xl">
                        <header>
                            <h1 class="flex gap-4">
                                Mint Distribution Details
                            </h1>
                            <hr/>
                            <div class="flex gap-5">
                                <div class="flex gap-1">
                                    <div class="font-thin">Distributing:</div>
                                    <div class="font-semibold">₳ {{$depositWalletBalance}}</div>
                                </div>
                                <div class="flex gap-1">
                                    <div class="font-thin">Epoch:</div>
                                    <div class="font-semibold">{{$mint?->epoch ?? '-'}}</div>
                                </div>
                                <div class="flex gap-1">
                                    <div class="font-thin">Qualified Users:</div>
                                    <div class="font-semibold">{{$mintTxs?->count() ?? '-'}}</div>
                                </div>
{{--                                <div class="flex gap-1">--}}
{{--                                    <div class="font-thin">Highest Delegated:</div>--}}
{{--                                    <div class="font-semibold">--}}
{{--                                        ₳ {{ number_format($cohortHighestDelegatedAmount/1000000, 0, '.', ',') ?? '-'}}</div>--}}
{{--                                </div>--}}
                            </div>
                            <hr/>
                        </header>
                        <div>
                            @if($mintTxs?->isNotEmpty())
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <x-portal.mint-tx-table :mintTxs="$mintTxs"/>
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-2 mt-5">
                                        <div class="flex items-center justify-center hidden"
                                             wire:loading.class.remove="hidden" wire:loading.class="block"
                                             wire:target="mintPhuffies">
                                            <svg
                                                class="w-4 h-4 border-t-2 border-b-2 rounded-full animate-spin border-primary-600"
                                                viewBox="0 0 24 24"></svg>
                                        </div>
                                        <div class="sm:flex sm:items-center hover:cursor-pointer">
                                            <div type="button" wire:click="mintPhuffies"
                                                 class="inline-flex items-center px-4 py-2 font-medium text-white border border-transparent rounded-sm shadow-sm hover:text-yellow-900 bg-accent-700 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                                <span>Mint Phuffies</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center justify-center p-8 border rounded-sm bg-gray-50">
                                    <div class="flex items-center justify-center hidden"
                                         wire:loading.class.remove="hidden" wire:loading.class="block"
                                         wire:target="mintPhuffies">
                                        <svg
                                            class="w-4 h-4 border-t-2 border-b-2 rounded-full animate-spin border-primary-600"
                                            viewBox="0 0 24 24"></svg>
                                    </div>
                                    <button
                                        wire:click="generateMintDetails"
                                        class="inline-flex justify-center gap-2 px-4 py-2 text-2xl font-semibold text-white border border-transparent rounded-sm shadow-xs bg-accent-700 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                                        <span>Preview</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Errors -->
        @if($errors->isNotEmpty())
            <x-public.errors :errors="$errors"/>
        @endif
    </div>

    <script type="text/javascript">
        window.delegatorRegistration = function delegatorRegistration() {
            return {
                address: null,
                addressCopied: false,
                amountCopied: false,
                completedSteps: [<?php echo implode(',', $this->completedSteps); ?>],
                currentWork: 'Retrieving a new deposit wallet',
                depositWalletBalance: <?php echo $this->depositWalletBalance; ?>,
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
                    Livewire.on('mintDetailsSubmitted', postId => {
                        this.completedSteps.push(1);
                        this.step = 2;
                    });
                },
                next() {
                    if (this.completedSteps.includes(this.step)) {
                        return null;
                    }
                    console.log('this.step::', this.step);
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
