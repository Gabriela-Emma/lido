<x-modal>
    <x-slot name="title">
        Contribute Money
    </x-slot>

    <x-slot name="content">
        <div class="" x-data="lidoStripePayment()">
            <section class="relative h-full flex flex-col" x-cloak>
                <div class="">
                    <dl class="rounded-sm bg-white shadow-xs w-full flex flex-row flex-wrap gap-y-4">
                        <div
                            :class="tab=='stripe' ? 'bg-primary-600 text-white border-primary-400' : 'border-gray-300'"
                            @click="payWithStripe()"
                            class="group flex flex-col p-6 text-center hover:cursor-pointer border  round-sm flex-1">
                            <dt :class="tab=='stripe' ? 'text-white' : 'text-gray-500'"
                                class="order-2 mt-2 text-lg leading-6 font-medium ">
                                Securely Powered by Stripe
                            </dt>
                            <dd
                                :class="tab=='stripe' ? 'text-white' : 'text-teal-600 group-hover:text-yellow-500'"
                                class="order-1 text-4xl font-extrabold">
                                <span>Pay with </span><br/>
                                <span>Card</span>
                            </dd>
                        </div>
                        <div
                            :class="tab=='crypto' ? 'bg-accent-700 text-white border-accent-600' : 'border-gray-300'"
                            @click="payWithCrypto()"
                            class="group flex flex-col p-6 text-center hover:cursor-pointer -mx-px border round-sm flex-1">
                            <dt :class="tab=='crypto' ? 'text-white' : 'text-gray-500'"
                                class="order-2 mt-2 text-lg leading-6 font-medium">
                                We accept ADA & Bitcoin
                            </dt>
                            <dd :class="tab=='crypto' ? 'text-white' : 'text-teal-600 group-hover:text-yellow-500'"
                                class="order-1 text-4xl font-extrabold">
                                <span>Send</span><br/>
                                <span>Crypto</span>
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="bg-accent-700 py-14" x-show="tab=='crypto'" x-transition>
                    <div class="px-6 text-white">
                        <div>
                            <h1>ADA</h1>
                            <div class="text-xl break-all font-semibold select-all cursor-text">
                                addr1qx0hjsn7vzsz0hkz3sj2yvmkckgkkvf5e9ntqg6gckp3xptcwnx0qegy50aedq33dy4z8s65f6sh6w8uq4ecaavc2jfsjwzfuv
                            </div>
                        </div>

                        <div class="mt-6">
                            <h1>Bitcoin</h1>
                            <div class="text-xl break-all font-semibold select-all cursor-text">
                                bc1qsdcjx7xur5jm9g2qgkn6dn8nykxhax3wz50tlx
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-primary-600 py-16" x-show="tab=='stripe'" x-transition>
                    <div class="max-w-lg px-6" x-transition>
                        <div x-show="paymentSuccessful && !makingPayment" class="mt-6 rounded-sm p-4 text-white">
                            <h1>Thank you for your donation!</h1>
                        </div>

                        <div x-transition x-show="!makingPayment && !paymentSuccessful">
                            <form class="bg-teal-600 rounded-sm p-4 text-white">
                                <div class="flex flex-row gap-4 items-end">
                                    <div class="flex-1">
                                        <label class="block text-sm font-bold text-white" for="donation-amount">
                                            Amount (USD) <span class="text-gray-200">(min: $5, max: $1,000)</span>
                                        </label>
                                        <input
                                            class="block w-full border-gray-300 rounded-sm shadow-xs focus:ring-accent-800 focus:border-accent-800 sm:text-sm h-10"
                                            min="5"
                                            max="1000"
                                            type="text"
                                            value="5"
                                            name="amount"
                                            id="donation-amount" />
                                    </div>
                                    <div>
                                        <button
                                            @click="collectPayment()"
                                            type="button"
                                            class="inline-flex items-center px-8 py-2 border border-transparent shadow-xs text-sm leading-4 font-medium rounded-sm text-white bg-accent-700 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-600">
                                            Next
                                            <!-- Heroicon name: solid/mail -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <form id="donation-payment-form" class="flex flex-col gap-0" x-transition x-show="makingPayment && !paymentSuccessful">
                            <style>
                                /* spinner/processing state, errors */
                                .spinner,
                                .spinner:before,
                                .spinner:after {
                                    border-radius: 50%;
                                }
                                .spinner {
                                    color: #ffffff;
                                    font-size: 22px;
                                    text-indent: -99999px;
                                    margin: 0px auto;
                                    position: relative;
                                    width: 20px;
                                    height: 20px;
                                    box-shadow: inset 0 0 0 2px;
                                    -webkit-transform: translateZ(0);
                                    -ms-transform: translateZ(0);
                                    transform: translateZ(0);
                                }
                                .spinner:before,
                                .spinner:after {
                                    position: absolute;
                                    content: "";
                                }
                                .spinner:before {
                                    width: 10.4px;
                                    height: 20.4px;
                                    background: #5469d4;
                                    border-radius: 20.4px 0 0 20.4px;
                                    top: -0.2px;
                                    left: -0.2px;
                                    -webkit-transform-origin: 10.4px 10.2px;
                                    transform-origin: 10.4px 10.2px;
                                    -webkit-animation: loading 2s infinite ease 1.5s;
                                    animation: loading 2s infinite ease 1.5s;
                                }
                                .spinner:after {
                                    width: 10.4px;
                                    height: 10.2px;
                                    background: #5469d4;
                                    border-radius: 0 10.2px 10.2px 0;
                                    top: -0.1px;
                                    left: 10.2px;
                                    -webkit-transform-origin: 0px 10.2px;
                                    transform-origin: 0px 10.2px;
                                    -webkit-animation: loading 2s infinite ease;
                                    animation: loading 2s infinite ease;
                                }
                                @-webkit-keyframes loading {
                                    0% {
                                        -webkit-transform: rotate(0deg);
                                        transform: rotate(0deg);
                                    }
                                    100% {
                                        -webkit-transform: rotate(360deg);
                                        transform: rotate(360deg);
                                    }
                                }
                                @keyframes loading {
                                    0% {
                                        -webkit-transform: rotate(0deg);
                                        transform: rotate(0deg);
                                    }
                                    100% {
                                        -webkit-transform: rotate(360deg);
                                        transform: rotate(360deg);
                                    }
                                }
                                @media only screen and (max-width: 600px) {
                                    form {
                                        width: 80vw;
                                    }
                                }
                            </style>
                            <div id="donation-card-element" class="bg-gray-100 rounded-tl-sm rounded-tr-sm px-2 py-4">
                                <!--Stripe.js injects the Card Element-->
                            </div>

                            <div>
                                <button
                                    class="w-full bg-accent-600 text-white hover:bg-accent-500 hover:text-gray-100 py-3"
                                    id="submitStripeDonation">
                                    <div class="spinner hidden text-white" id="spinner"></div>
                                    <span id="button-text" class="text-xl">Pay now</span>
                                </button>
                            </div>

                            <div>
                                <p id="card-error" role="alert"></p>
                            </div>

                            <div>
                                <p class="result-message hidden">
                                    Payment succeeded!
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </x-slot>

    <x-slot name="buttons">
        <button type="button"
                x-transition
                onclick='Livewire.emit("closeModal", "contribute-content.contribute-article")'
                class="h-10 px-4 py-2 relative top-1 border border-transparent m-0 text-sm font-medium rounded-sm shadow-xs text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Close
        </button>
    </x-slot>
</x-modal>
