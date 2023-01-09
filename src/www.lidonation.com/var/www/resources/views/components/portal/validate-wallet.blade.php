<div class="lg:border-t lg:border-b lg:border-gray-300" x-data="delegatorRegistration">
    <!-- Navigation -->
    <nav x-transition x-show="validationComplete !== true" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 border-b"
         aria-label="Progress" x-cloak>
        <ol role="list"
            class="rounded-sm overflow-hidden lg:flex lg:border-l lg:border-r lg:border-gray-300 lg:rounded-none">
            <li class="relative overflow-hidden lg:flex-1">
                <div class="border border-gray-300 overflow-hidden border-b-0 rounded-t-md lg:border-0">
                    <a href="#" @click.prevent="goToStep(1)" aria-current="step" class="group">
                        <span
                            :class="{
                                'bg-primary-600': active(1) || completed(1),
                                'bg-transparent group-hover:bg-gray-200': !active(1)
                            }"
                            class="absolute top-0 left-0 w-1 h-full lg:w-full lg:h-1 lg:bottom-0 lg:top-auto"
                            aria-hidden="true"></span>
                        <span class="px-6 py-5 flex items-start text-sm font-medium lg:pl-9">
                          <span class="flex-shrink-0">
                            <span
                                :class="{
                                'bg-primary-600': completed(1),
                                'border-primary-600': active(1) || completed(1),
                                'border-gray-300': !active(1) && !completed(1)
                                }"
                                class="w-10 h-10 flex items-center justify-center border-2 rounded-full">
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
                                class="text-xs font-semibold tracking-wide uppercase">Send Fund</span>
                            <span class="text-sm font-medium text-gray-500">Lets us verify your wallet.</span>
                          </span>
                        </span>
                    </a>
                </div>
            </li>

            <li class="relative overflow-hidden lg:flex-1">
                <div class="border border-gray-300 overflow-hidden lg:border-0">
                    <a href="#" @click.prevent="goToStep(2)" aria-current="step" class="group">
                        <span
                            :class="{
                                'bg-primary-600': active(2) || completed(2),
                                'bg-transparent group-hover:bg-gray-200': !active(2)
                            }"
                            class="absolute top-0 left-0 w-1 h-full lg:w-full lg:h-1 lg:bottom-0 lg:top-auto"
                            aria-hidden="true"></span>
                        <span class="px-6 py-5 flex items-start text-sm font-medium lg:pl-9">
                          <span class="flex-shrink-0">
                            <span
                                :class="{
                                'bg-primary-600': completed(2),
                                'border-primary-600': active(2) || completed(2),
                                'border-gray-300': !active(2) && !completed(2)
                                }"
                                class="w-10 h-10 flex items-center justify-center border-2 rounded-full">
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
                                class="text-xs font-semibold tracking-wide uppercase">Verification</span>
                            <span class="text-sm font-medium text-gray-500">Confirmation and Validation.</span>
                          </span>
                        </span>
                    </a>

                    <!-- Separator -->
                    <div class="hidden absolute top-0 left-0 w-3 inset-0 lg:block" aria-hidden="true">
                        <svg class="h-full w-full text-gray-300" viewBox="0 0 12 82" fill="none"
                             preserveAspectRatio="none">
                            <path d="M0.5 0V31L10.5 41L0.5 51V82" stroke="currentcolor"
                                  vector-effect="non-scaling-stroke"/>
                        </svg>
                    </div>
                </div>
            </li>

            <li class="relative overflow-hidden lg:flex-1">
                <div class="border border-gray-300 overflow-hidden border-t-0 rounded-b-md lg:border-0">
                    <a href="#" @click.prevent="goToStep(3)" aria-current="step" class="group">
                        <span
                            :class="{
                                'bg-primary-600': active(3) || completed(3),
                                'bg-transparent group-hover:bg-gray-200': !active(3)
                            }"
                            class="absolute top-0 left-0 w-1 h-full lg:w-full lg:h-1 lg:bottom-0 lg:top-auto"
                            aria-hidden="true"></span>
                        <span class="px-6 py-5 flex items-start text-sm font-medium lg:pl-9">
                          <span class="flex-shrink-0">
                            <span
                                :class="{
                                'bg-primary-600': completed(3),
                                'border-primary-600': active(3) || completed(3),
                                'border-gray-300': !active(3) && !completed(3)
                                }"
                                class="w-10 h-10 flex items-center justify-center border-2 rounded-full">
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
                                class="text-xs font-semibold tracking-wide uppercase">Sending NFT</span>
                            <span class="text-sm font-medium text-gray-500">Your ADA is sent back with LIDO NFT.</span>
                          </span>
                        </span>
                    </a>
                    <!-- Separator -->
                    <div class="hidden absolute top-0 left-0 w-3 inset-0 lg:block" aria-hidden="true">
                        <svg class="h-full w-full text-gray-300" viewBox="0 0 12 82" fill="none"
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
    <div class="p-8 border-t" x-show="active(1)" x-transition>
        <button
            x-show="!validationComplete && !address" x-transition
            @click="startVerification();"
            type="button"
            class="relative block w-full border-2 group border-gray-300 border-dashed rounded-sm p-12 text-center hover:border-primary-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-teal-600" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z"
                      clip-rule="evenodd"/>
            </svg>
            <span
                class="mt-2 block text-sm font-medium text-gray-900 group-hover:text-teal-600">
                Start
            </span>
        </button>

        <div
            x-show="!!address" x-transition
            class="w-full grid grid-cols-1 gap-y-8 gap-x-6 items-start sm:grid-cols-12 lg:items-center lg:gap-x-8">
            <div class="rounded-sm overflow-hidden sm:col-span-4 lg:col-span-5">
                <img src="{{asset('img/lido-nation-future-for-everyone.jpg')}}"
                     alt="ADA Address QR Code." class="qr-code object-center object-scale-down w-full"
                     id="step-1-qr-code"/>
            </div>

            <div class="sm:col-span-8 lg:col-span-7">
                <h2 class="text-xl font-medium text-gray-900 sm:pr-12">
                    <span>To verify your ownership of this address please send exactly
                        1.681000 ADA</span>

                    <button type="button" @click="$clipboard(1.681000)">
                        <span
                            @click="copyAmount()"
                            class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-sm font-medium bg-primary-400 hover:bg-primary-600 text-white">
                          <svg @click="" class="-ml-0.5 mr-1.5 h-2 w-2" fill="currentColor"
                               :class="{'text-pink-300': !amountCopied, 'text-teal-600': amountCopied}"
                               viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3"/>
                          </svg>
                            <span x-show="!amountCopied">Copy &nbsp;</span>
                            <span x-show="amountCopied">Copied</span>
                        </span>
                    </button>
                </h2>

                <section aria-labelledby="information-heading" class="mt-4 flex flex-col gap-8">
                    <h3 id="information-heading" class="sr-only">ADA Address</h3>

                    <div>
                        <p>
                        <span x-html="address?.id"
                              class="font-semibold text-2xl text-gray-900 break-all select-all cursor-text"></span>
                            <button type="button" @click="$clipboard(address?.id)">
                                <span
                                    @click="copyAddress()"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-sm font-medium bg-primary-400 hover:bg-primary-600 text-white">
                                  <svg x-transition.scale.400
                                       x-transition:enter.duration.50ms
                                       x-transition:leave.duration.100ms
                                       :class="{'text-pink-300': !addressCopied, 'text-teal-600': addressCopied}"
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

                    <div>
                        <p class="text-gray-900">
                            Once we receive 1.681000 ADA at the address above,
                            we will send the same amount back to you along with any fees you paid, plus a lido nft.
                            The nft will be used to periodically sync your lido nation features, access controls,
                            and privileges with the Cardano blockchain.
                        </p>
                        <p x-show="depositWalletBalance < 1">
                            <span class="flex flex-row gap-2 text-teal-600 font-semibold bg-white">
                                <svg class="animate-spin rounded-full border-t-2 border-b-2 border-primary-600 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Checking for deposit. This can take up to 2 minutes after you send the funds.</span>
                            </span>
                        </p>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Step 2 -->
    <div class="p-8" x-show="active(2) && !working" x-transition>
        <div x-show="isDelegator === false" x-transition>
            <div class="bg-white">
                <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 lg:flex lg:justify-between">
                    <div class="max-w-xl">
                        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl sm:tracking-tight lg:text-5xl">
                            We could not verify your <span class="text-teal-600">lido</span> delegation
                        </h2>
                        <p class="mt-5 text-xl text-gray-500">
                            If you only recently delegated to lido, it can take up to 10 days before we will be able to
                            verify your delegation. Wait until you receive your first staking reward, then then come
                            back
                            here to finish setting up your account.
                        </p>
                    </div>
                    <div class="w-full max-w-xs">
                        <div class="relative">
                            <img class="h-64 w-64 rounded-full" src="{{asset('img/confused-puppy.jpeg')}}"
                                 alt="Confused puppy. Delegation not found.">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 3 -->
    <div class="p-8" x-show="active(3)" x-transition>
        <div x-show="validationComplete === true" x-transition>
            <div class="bg-white">
                <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 lg:flex lg:justify-between">
                    <div class="max-w-xl">
                        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl sm:tracking-tight lg:text-5xl">
                            You did it! Welcome properly to <span class="text-teal-600">lido</span> nation.
                        </h2>
                        <p class="mt-5 text-xl text-gray-500">
                            A world of possibilities awaits you.
                        </p>
                    </div>
                    <div class="w-full max-w-xs">
                        <div class="relative">
                            <img class="h-64 w-64 rounded-full" src="{{asset('img/fancy-tomatoes.jpeg')}}"
                                 alt="Fancy Tomatoes. Verification Successful.">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Messages -->
    <div x-transition
         x-show="isValidating()"
         class="flex flex-row gap-4 items-center p-8 border-t">
        <div>
            <x-icons.cog class="h-10 w-10 animate-spin rounded-full border-t-2 border-b-2 border-primary-600"/>
        </div>
        <div>
            <p class="text-2xl" x-html="currentWork"></p>
        </div>
    </div>

    <!-- Errors -->
    <div class="bg-pink-600 px-6 py-4 w-full h-full flex flex-col justify-center"
         x-show="errors.length > 0" x-transition>
        <ul class="flex flex-row flex-wrap gap-1 items-end">
            <template x-for="error in errors">
                <li class="font-semibold text-white text-sm" x-html="error"></li>
            </template>
            <li>
                <button
                    @click="retryStep"
                    type="button"
                    class="bg-pink-50 px-2 py-1.5 rounded-sm text-sm font-medium text-pink-800 hover:bg-pink-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-pink-50 focus:ring-pink-600">
                    Try again
                </button>
            </li>
        </ul>
    </div>
</div>

<script type="text/javascript">
    window.delegatorRegistration = function delegatorRegistration() {
        return {
            address: null,
            addressCopied: false,
            amountCopied: false,
            completedSteps: [],
            currentWork: 'Retrieving a new deposit wallet',
            depositWalletBalance: null,
            errors: [],
            isDelegator: null,
            isDelegatorInterval: null,
            nftAuthenticated: false,
            nftAuthIssuedInterval: null,
            paymentReceivedInterval: null,
            paymentReceived: false,
            refundAmount: null,
            step: 1,
            validationComplete: false,
            working: false,
            async init() {
                await this.authenticateWallet();

                if (this.validationComplete) {
                    return;
                }

                // Step 1
                await this.listenForPayment();
                await this.preloadVerification();
                if (!this.depositWalletBalance) {
                    this.paymentReceivedInterval = setInterval(await this.listenForPayment.bind(this), 10000);
                }

                // Step 2
                if (this.depositWalletBalance >= 1681000) {
                    await this.confirmDelegation();
                    if (!this.isDelegatorInterval && this.isDelegator === null) {
                        this.isDelegatorInterval = setInterval(await this.confirmDelegation.bind(this), 5000);
                    }
                }

                // Step 3
                if (this.isDelegator) {
                    await this.issueRefund();
                    if (!this.nftAuthIssuedInterval) {
                        this.nftAuthIssuedInterval = setInterval(await this.authenticateWallet.bind(this), 5000);
                    }
                }
            },
            next() {
                this.step = this.step + 1;
            },
            prev() {
                this.step = this.step - 1;
            },
            goToStep(step) {
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
            retryStep() {
                switch (this.step) {
                    case 1:
                        this.startVerification();
                        break;
                    case 2:
                        this.confirmDelegation();
                        break;
                    case 3:
                        this.startVerification();
                        break;
                }
            },
            copyAddress() {
                this.addressCopied = true;
                setTimeout(() => this.addressCopied = false, 3000);
            },
            copyAmount() {
                this.amountCopied = true;
                setTimeout(() => this.amountCopied = false, 3000);
            },
            async authenticateWallet() {
                try {
                    this.working = true;
                    const res = await window.axios.post('/validate-wallet/nft-auth', {
                        headers: {'Content-Type': 'application/json'}
                    });
                    if (res.status === 200) {
                        clearInterval(this.nftAuthIssuedInterval);
                        this.validationComplete = true;
                        this.isDelegator = true;
                        this.nftAuthenticated = true;
                        this.completedSteps.push(1);
                        this.completedSteps.push(2);
                        this.completedSteps.push(3);
                        this.currentWork = null;
                        this.step = 3;
                        this.working = false;
                    }
                } catch (reason) {
                }
            },
            async listenForPayment() {
                // wait for step one to complete
                if (!this.address) {
                    return;
                }
                // skip if payment already made
                if (this.depositWalletBalance >= 1681000) {
                    this.working = false;
                    clearInterval(this.paymentReceivedInterval);
                    return;
                }

                const res = await window.axios.post('/validate-wallet/balance', {
                    headers: {'Content-Type': 'application/json'},
                    create_if_missing: false
                });
                if (res.status === 200 && parseInt(res.data) >= 1681000) {
                    clearInterval(this.paymentReceivedInterval);
                    this.depositWalletBalance = parseInt(res.data);
                    this.setPaymentReceive();
                    this.isDelegatorInterval = setInterval(await this.confirmDelegation.bind(this), 5000);
                    this.working = false;
                }
            },
            async preloadVerification() {
                this.working = true;
                const res = await window.axios.post('/validate-wallet/start', {
                    headers: {'Content-Type': 'application/json'},
                    create_if_missing: false
                });

                if (res.status === 200 && typeof res.data === 'object') {
                    document.getElementById('step-1-qr-code').src = res.data.qr;
                    this.address = res.data;
                    await this.listenForPayment();
                    this.setPaymentReceive();
                }
                this.working = false;
            },
            async getRefundAmount() {
                try {
                    const res = await window.axios.get('/validate-wallet/refund', {
                        headers: {'Content-Type': 'application/json'}
                    });
                    if (res.status === 200) {
                        this.refundAmount = res.data;
                    }
                } catch (reason) {
                    this.pushError('We hit a snag validating your delegation.')
                }
            },
            async confirmDelegation() {
                try {
                    this.working = true;
                    const res = await window.axios.post('/validate-wallet/delegation', {
                        headers: {'Content-Type': 'application/json'}
                    });
                    if (res.status === 200) {
                        await this.getRefundAmount();
                        this.step = 3;
                        this.isDelegator = true;
                        this.completedSteps.push(2);
                        this.currentWork = `You're in! Refunding your wallet with <span class="font-semibold px-2">~${this.refundAmount / 1000000} ₳</span> and a LIDO NFT Key.`;
                        clearInterval(this.isDelegatorInterval);
                        await this.issueRefund()
                        this.working = false;
                    }
                } catch (reason) {
                    if (reason.response.status === 403) {
                        this.isDelegator = false;
                        this.working = false;
                        clearInterval(this.isDelegatorInterval);
                    } else if( reason.response.status === 404) {

                    } else {
                        this.working = false;
                        this.errors = [];
                        this.pushError('We hit a snag validating your delegation.');
                    }
                }
            },
            async startVerification() {
                this.working = true;
                try {
                    const res = await window.axios.post('/validate-wallet/start', {
                        headers: {'Content-Type': 'application/json'}
                    });
                    document.getElementById('step-1-qr-code').src = res.data.qr;
                    this.address = res.data;
                    await this.listenForPayment();
                    this.setPaymentReceive();
                    this.working = false;
                } catch (reason) {
                    this.pushError(`${reason.response.statusText} ${reason.response.data}`);
                }
            },
            async issueRefund() {
                try {
                    this.working = true;
                    const res = await window.axios.post('/validate-wallet/refund', {
                        headers: {'Content-Type': 'application/json'}
                    });

                    if (res.status === 200) {
                        await this.authenticateWallet();
                    }
                } catch (reason) {
                    this.pushError(reason.response.data);
                    await this.authenticateWallet();
                }
            },
            setPaymentReceive() {
                if (this.step > 2) {
                    return;
                }
                if (!this.depositWalletBalance) {
                    return;
                }
                this.paymentReceived = true;
                this.step = 2;
                this.completedSteps.push(1);
                this.currentWork = 'Payment Received. Validating Delegation';
            },
            isValidating() {
                return this.currentWork && this.working &&
                    (
                        (this.step === 1 && !this.address) ||
                        (this.step === 2 && !this.depositWalletBalance) ||
                        (this.step === 3 && !this.isDelegator) ||
                        this.validationComplete === false
                    ) &&
                    this.errors.length === 0;
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
