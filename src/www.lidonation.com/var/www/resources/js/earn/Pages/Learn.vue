<template>
    <section class="py-8 md:pb-20 md:pt-16 xl:pb-36 xl:pt-24 bg-opacity-5 text-white"
             style="background: url('/img/ngong-road-learn.svg'); background-size: 100% auto;">
        <div class="container">
            <div class="text-center flex flex-col gap-8 xl:gap-12">
                <div class="text-xl md:text-2xl xl:text-3xl">
                    {{ $t("Lido Nation Presents") }}
                </div>
                <div class="text-2xl md:text-4xl xl:text-6xl font-bold">
                    {{ $t("Jifunze Ulipweke") }}
                </div>
                <div class="text-xl md:text-2xl xl:text-3xl">
                    {{ $t("Get Paid to Learn!") }}
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 flex flex-row justify-end mt-4">
        <div class="bg-slate-100 rounded-l-full w-4/5 lg:w-3/4 xl:w-2/3">
            <div class="container py-16 px-8">
                <div class="flex flew-wrap justify-between">
                    <div class="gap-4 flex flex-row items-center justify-start">
                        <h2 class="text-2xl sm:text-4xl xl:text-6xl 2xl:text-8xl">1</h2>
                        <p class="text-xl sm:text-3xl xl:text-4xl 2xl:text-5xl">
                            {{ $t("Register or Login") }}
                        </p>
                    </div>
                    <div class="flex gap-3 items-center flex-row mx-auto">
                        <Link href="/earn/learn/login" type="button"
                              class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-labs-red py-2 px-4 text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            <span>{{ $t("Sign in") }}</span>
                        </Link>
                        <span class="text-sm">
                            <Link href="/earn/learn/register" class="font-bold text-labs-red hover:text-labs-black">
                                {{ $t("Register") }}
                            </Link>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 flex flex-row justify-start">
        <div class="bg-slate-100 rounded-r-full w-4/5 lg:w-3/4 xl:w-2/3">
            <div class="container py-16 px-8">
                <div class="flex flex-wrap justify-between">
                    <div class="flex gap-3 items-center flex-row mx-auto">
                        <Link href="/earn/learn/login" type="button"
                              class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-labs-red py-2 px-4 text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            <span>{{ $t("Connect Wallet") }}</span>
                        </Link>
                        <span class="text-sm">
                            <Link href="/earn/learn/register" class="font-bold text-labs-red hover:text-labs-black">
                                {{ $t("Need a Wallet?") }}
                            </Link>
                        </span>
                    </div>
                    <div class="text-right gap-4 flex flex-row items-center justify-end">
                        <p class="text-xl sm:text-3xl xl:text-4xl 2xl:text-5xl">
                            {{ $t("Connect your Wallet") }}
                        </p>
                        <h2 class="text-2xl sm:text-4xl xl:text-6xl 2xl:text-8xl text-right">2</h2>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="py-16 flex flex-row justify-end mb-4">
        <div class="bg-slate-100 rounded-l-full w-4/5 lg:w-3/4 xl:w-2/3">
            <div class="container py-16 px-8">
                <div class="flex flew-wrap justify-between">
                    <div class="gap-4 flex flex-row items-center justify-start">
                        <h2 class="text-2xl sm:text-4xl xl:text-6xl 2xl:text-8xl">3</h2>
                        <p class="text-xl sm:text-3xl xl:text-4xl 2xl:text-5xl">
                            {{ $t("Learn") }}
                        </p>
                    </div>
                    <div class="flex gap-3 items-center flex-row mx-auto">
                        <Link href="/earn/learn/login" type="button"
                              class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-labs-red py-2 px-4 text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            <span>{{ $t("GO!") }}</span>
                        </Link>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="py-16 bg-teal-600">
        <div class="container">
            <div class="flex justify-between items-center">
                <div class="max-w-5xl text-white text-lg md:text-xl xl:text-3xl 2xl:text-4xl">
                    <p>
                        {{
                            $t("Lido Nation was funded by Cardano's Project Catalyst to create educational materials about blockchain technology for people who speak Swahili.")
                        }}
                    </p>
                </div>

                <div>
                    <img alt="lido nation logo" :src="$utils.assetUrl('img/llogo-transparent.png')"
                         class="h-40"/>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-white">
        <div class="container text-xl xl:text-2xl ">
            <div class="flex justify-start">
                <div class="max-w-5xl">
                    <p>
                        {{ $t("When you participate and learn about the Cardano blockchain, WE GIVE YOU MONEY.") }}
                    </p>
                    <p>
                        {{
                            $t("There is no catch - and don't get too excited, it's not a lot of money. It's a thank you present, and an invitation.")
                        }}
                    </p>
                    <p>
                        {{
                            $t("We hope you are interested in what you learn and we hope you will hang around. To keep learning. To participate.")
                        }}
                    </p>
                    <p>
                        {{ $t("And to be a part of a future that works for everyone.") }}
                    </p>
                    <p class="font-bold text-xl xl:text-4xl">
                        {{ $t("Welcome") }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {inject} from "vue";
import {Link} from '@inertiajs/vue3';

const $utils: any = inject('$utils');

import {
    AcademicCapIcon,
    BanknotesIcon,
    CheckBadgeIcon,
    ClockIcon,
    ReceiptRefundIcon,
    UsersIcon,
} from '@heroicons/vue/24/outline';


</script>
