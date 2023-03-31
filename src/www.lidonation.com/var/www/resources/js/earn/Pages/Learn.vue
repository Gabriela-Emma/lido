<template>
    <section class="py-4 sm:py-8 md:pb-20 md:pt-16 pb-16 xl:pb-36 xl:pt-24 bg-opacity-5 text-white overflow-visible z-5"
             style="background: url('/img/ngong-road-learn.svg'); background-size: 100% auto;">
        <div class="container">
            <div class="text-center flex flex-col gap-2 sm:gap-8 xl:gap-12">
                <div class="text-md sm:text-xl md:text-2xl xl:text-3xl">
                    {{ $t("Lido Nation Presents") }}
                </div>
                <div class="text-xl sm:text-2xl md:text-4xl xl:text-6xl font-bold">
                    {{ $t("Jifunze Ulipweke") }}
                </div>
                <div class="text-md sm:text-xl md:text-2xl xl:text-3xl">
                    {{ $t("Get Paid to Learn!") }}
                </div>
            </div>
        </div>
    </section>
    <section class="py-10 md:py-16 flex flex-row justify-end mt-4">
        <div class="bg-slate-100 rounded-l-full w-4/5 lg:w-3/4 xl:w-2/3">
            <div class="container py-16 px-6 md:px-8">
                <div class="flex flew-wrap justify-between">
                    <div class="gap-1 md:gap-4 flex flex-row items-center justify-start">
                        <h2 class="text-2xl md:text-4xl xl:text-6xl 2xl:text-8xl">1</h2>
                        <p class="text-sm md:text-xl lg:text-2xl xl:text-4xl 2xl:text-5xl">
                            {{ $t("Register or Login") }}
                        </p>
                    </div>
                    <div class="flex gap-3 items-center flex-row mx-auto">
                        <Link href="/earn/learn/login" type="button"
                              class="flex gap-2 md:gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-labs-red py-2 px-2 md:px-4 text-lg md:text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor" class="w-4 md:w-7 h-4 md:h-7">
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
    <section class="py-10 md:py-16 flex flex-row justify-start">
        <div class="bg-slate-100 rounded-r-full w-4/5 lg:w-3/4 xl:w-2/3">
            <div class="container py-16 px-6 md:px-8">
                <div class="flex flex-wrap justify-between">
                    <div class="flex flex-col md:flex-row gap-1 md:gap-3 items-center flex-row mx-auto">
                        <Link href="/earn/learn/login" type="button"
                              class="flex gap-1 md:gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-labs-red py-2 px-2 md:px-4 text-sm md:text-xl 2xl:text-2xl font-medium text-white shadow-sm hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor" class="w-4 md:w-7 h-4 md:h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            <span>{{ $t("Connect Wallet") }}</span>
                        </Link>
                        <span class="text-sm">
                            <Link href="/earn/learn/register" class="font-bold text-labs-red text-xs md:text-base hover:text-labs-black">
                                {{ $t("Need a Wallet?") }}
                            </Link>
                        </span>
                    </div>
                    <div class="text-right gap-2 md:gap-4 flex flex-row items-center justify-end">
                        <p class="text-sm md:text-xl lg:text-3xl xl:text-4xl 2xl:text-5xl">
                            {{ $t("Connect your Wallet") }}
                        </p>
                        <h2 class="text-2xl sm:text-4xl xl:text-6xl 2xl:text-8xl text-right">2</h2>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="py-10 md:py-16 flex flex-row justify-end mb-4">
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor" class="w-4 md:w-7 h-4 md:h-7">
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

                <div class="flex w-52 lg:w-auto max-w-xs">
                    <img alt="lido nation logo" :src="$utils.assetUrl('img/llogo-transparent.png')"
                         class="h-10 lg:h-40"/>
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
    <section class="py-16 sm:py-24 lg:py-36 bg-stone-100">
        <div class="container text-xl xl:text-2xl ">
            <div class="mx-auto divide-y divide-slate-900/10">
                <div>
                    <h2 class="text-2xl xl:text-4xl font-bold leading-10 tracking-tight text-slate-900">
                        Frequently asked questions</h2>
                </div>
                <dl class="mt-10 space-y-6 divide-y divide-slate-900/10">
                    <Disclosure as="div" v-for="faq in faqs" :key="faq.question" class="pt-6" v-slot="{ open }">
                        <dt>
                            <DisclosureButton
                                class="flex w-full items-start justify-between text-left text-slate-900">
                                <div class="max-w-5xl">
                                    <span class="xl:text-2xl font-semibold leading-7">{{ faq.question }}</span>
                                    <p class="leading-7 text-base text-slate-700">
                                        {{ faq.shortAnswer }}
                                        <span class="text-slate-400" v-if="!open"> Continue reading --></span>
                                    </p>
                                </div>
                                <span class="ml-6 flex h-7 items-center">
                              <PlusSmallIcon v-if="!open" class="h-6 w-6" aria-hidden="true"/>
                              <MinusSmallIcon v-else class="h-6 w-6" aria-hidden="true"/>
                            </span>
                            </DisclosureButton>
                        </dt>
                        <DisclosurePanel as="dd" class="mt-4 pr-12 max-w-5xl">
                            <div class="text-base leading-7 text-slate-700 faq-answer"
                                 v-html="$filters.markdown(faq.answer)"></div>
                        </DisclosurePanel>
                    </Disclosure>
                </dl>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {inject} from "vue";
import {Link} from '@inertiajs/vue3';
import {Disclosure, DisclosureButton, DisclosurePanel} from '@headlessui/vue';
import {MinusSmallIcon, PlusSmallIcon} from '@heroicons/vue/24/outline';

const $utils: any = inject('$utils');

const faqs = [
    {
        question: "What is blockchain and cryptocurrency?",
        shortAnswer:
            "Blockchain is a new technology, and a new way of using the internet. It leverages a global network of participants to create a type of security and record keeping that does not depend on big companies and power brokers to run the show.",
        answer:
            `Instead, the blockchain is a secure, decentralized ledger.

It allows anyone to participate, to own their own data, and to access financial tools that they may not have had access to from traditional banks and government institutions.

Blockchain-believers think that anyone should be able to use their money easily.
* You should be able to transfer money to anyone you want without paying high fees.
* You should be able to earn a fair return on money you save, or lend.

You should have access to financial tools that allow you to build a home, and life, no matter where you live.

Cardano is a blockchain that is built to be very secure, and to grow big enough to serve the whole world.

**The digital money on the Cardano blockchain is called $ADA.**`,
    },
    {
        question: "What can I do with $ADA?",
        shortAnswer:
            `$ADA is a type of money, like dollars or euros
            More specifically, it is a "cryptocurrency", or digital currency, like bitcoin, ethereum, and others.`,
        answer:
            `You can trade it for another digital currency, or for your local fiat currency, on an online exchange like Coinbase.

You can use it to buy things at any store that accepts $ADA. You could buy collectibles and digital art at jpg.store. You could book an overnight stay at the Hotel Ginebra in Barcelona, Spain. In the future, the number of online and physical businesses that accept $ADA will continue to grow.

You might decide to learn more about the world of cryptocurrency and start to participate in liquidity farming, and other ways to let your money work for you.`,
    },
    {
        question: "How does this program work?",
        shortAnswer:
            "Every day on Lido Nation you can earn $1 worth of ADA by reading an article and taking a 1-question quiz about what you learned.",
        answer:
            `
All you need is a free Cardano wallet and a Lido Nation login and password to start earning your own $ADA. Follow the steps at the top of the page to get a wallet and get connected.
* You can read one article and earn one dollar's worth of $ADA each day.
* The clock for each day resets at 12 Midnight EAT (Eastern Africa Time).
* When you complete 25 quizzes, you will earn a free NFT!
* When you want to withdraw your rewards to your Wallet, click the "Withdraw" button in the rewards center. There is a small transaction fee when you withdraw rewards, so instead of withdrawing rewards every day, wait until you have several rewards saved up. That way you get to keep MORE of your rewards!

After 25 quizzes, you can't earn more money with this program, but you can earn a second NFT if you complete 25 more quizzes, and a third one if you complete all 75 quizzes. As you complete the reading and quizzes, you learn about other ways to participate in Cardano and earn more $ADA if you want to.
`,
    },
]

</script>
<style scoped>
:deep(li) {
    list-style: disc;
}

:deep(ul) {
    margin-left: 2rem;
}
</style>
