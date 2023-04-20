<template>
    <section class="py-4 sm:py-8 md:pb-20 md:pt-16 pb-16 xl:pb-36 2xl:pt-24 bg-opacity-5 text-white overflow-visible z-5"
             style="background: url('/img/ngong-road-learn.svg') 0% 20% / 100%; background-size: 100% auto;">
        <div class="container">
            <div class="text-center flex flex-col gap-2 sm:gap-6 xl:gap-8 2xl:gap-12">
                <div class="text-md sm:text-xl md:text-2xl xl:text-3xl">
                    {{ $t("lidonationPresents") }}
                </div>
                <div class="text-xl sm:text-2xl md:text-4xl xl:text-6xl font-bold">
                    {{ $t("Learn2earn") }}
                </div>
                <div class="text-md sm:text-xl md:text-2xl xl:text-3xl">
                    {{ $t("paid2learn") }}
                </div>
            </div>
        </div>
    </section>
    <section class="py-10 md:py-16 flex flex-row justify-end mt-4">
        <div class="bg-slate-100 rounded-l-full w-5/6 lg:w-3/4 xl:w-2/3">
            <div class="container py-16 px-6 md:px-8">
                <div class="flex flew-wrap justify-between">
                    <div class="gap-1 md:gap-4 flex flex-row items-center justify-start">
                        <div class="text-xl sm:text-2xl md:text-4xl xl:text-6xl font-bold">1</div>
                        <p class="text-md sm:text-xl md:text-2xl xl:text-3xl">
                            {{ $t("register/login") }}
                        </p>
                    </div>
                    <div v-if="!user" class="flex gap-3 items-center flex-row mx-auto">
                        <Link href="/earn/learn/login" type="button"
                              class="flex gap-2 md:gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-labs-red py-2 px-2 md:px-3 text-sm md:text-lg 2xl:text-xl font-medium text-white shadow-sm hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor" class="w-4 md:w-7 h-4 md:h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            <span>{{ $t("signIn") }}</span>
                        </Link>
                        <span class="text-sm">
                            <Link href="/earn/learn/register" class="font-bold text-labs-red hover:text-labs-black">
                                {{ $t("register") }}
                            </Link>
                        </span>
                    </div>
                    <div v-else class="flex gap-3 items-center flex-row mx-auto">
                        <div v-if="user?.roles.includes('learner')" class="flex gap-2 items-center">
                            <p class="font-bold text-labs-green">Logged In!</p>
                            <CheckIcon class="h-10 lg:h-16 w-10 lg:w-16 text-green-500 font-bold" />
                        </div>
                        <div v-else class="flex gap-2 items-center">
                            <p class="text-sm">Logged in but not registered!</p>
                            <CheckIcon class="h-10 lg:h-16 w-10 lg:w-16 text-green-500 font-bold" />
                            <Link @click="register" type="button"
                                  class="flex gap-2 md:gap-3 items-center justify-center rounded-sm border border-transparent bg-labs-red py-1.5 px-1 md:px-2 text-sm xl:text-lg font-medium text-white shadow-sm hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                <span>{{ $t("register") }}</span>
                            </Link>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-10 md:py-16 flex flex-row justify-start">
        <div class="bg-slate-100 rounded-r-full w-5/6 lg:w-3/4 xl:w-2/3">
            <div class="container py-16 px-6 md:px-8">
                <div class="flex flex-wrap justify-between">
                    <div v-if="! walletData.address" class="flex flex-col md:flex-row gap-1 md:gap-3 items-center  mx-auto">
                        <ConnectWallet :background-color="'bg-labs-red'" @walletData="setWalletName($event)" />
                        <span class="text-sm">
                            <Link href="/earn/learn/register"
                                class="font-bold text-labs-red text-xs md:text-base hover:text-labs-black">
                                {{ $t("needWallet") }}
                            </Link>
                        </span>
                    </div>
                    <div v-else  class="flex flex-col md:flex-row gap-1 md:gap-3 items-center  mx-auto">
                        <CheckIcon class="h-10 lg:h-16 w-10 lg:w-16 text-green-500" />
                        <span class="font-bold text-labs-green">
                                {{ $t("connected") }}
                        </span>
                    </div>
                    <div class="text-right gap-2 md:gap-4 flex flex-row items-center justify-end">
                        <p class="text-md sm:text-xl md:text-2xl xl:text-3xl hidden md:block">
                            {{ $t("connectYourWallet") }}
                        </p>
                        <div class="text-xl sm:text-2xl md:text-4xl xl:text-6xl font-bold">
                            2
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-10 md:py-16 flex flex-row justify-end mb-4">
        <div class="bg-slate-100 rounded-l-full w-5/6 lg:w-3/4 xl:w-2/3">
            <div class="container py-16 px-8">
                <div class="flex flew-wrap justify-between">
                    <div class="gap-4 flex flex-row items-center justify-start">
                        <div class="text-xl sm:text-2xl md:text-4xl xl:text-6xl font-bold">3</div>
                        <p class="text-md sm:text-xl md:text-2xl xl:text-3xl">
                            {{ $t("learn") }}
                        </p>
                    </div>
                    <div class="flex gap-3 items-center flex-row mx-auto">
                        <div v-if="!!user && !user.roles.includes('learner')" class="flex gap-3 items-center flex-row mx-auto">
                            <div class="flex gap-2 items-center">
                                <p class="text-sm">{{ $t("Almost Set!") }}</p>
                            </div>
                            <Link @click="register" type="button"
                                  class="flex gap-2 md:gap-3 items-center justify-center rounded-sm border border-transparent bg-labs-red py-1.5 px-1 md:px-2 text-sm xl:text-lg font-medium text-white shadow-sm hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                <span>{{ $t("Sign up for the Program") }}</span>
                            </Link>
                        </div>

                        <Link v-else :href="$utils.localizeRoute('earn/learn/modules')" type="button"
                              class="flex gap-3 items-center w-full justify-center rounded-sm border border-transparent bg-labs-red py-2 px-3 text-sm md:text-lg 2xl:text-xl font-medium text-white shadow-sm hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor" class="w-4 md:w-7 h-4 md:h-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            <span>{{ $t("go") }}</span>
                        </Link>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section class="py-16 bg-teal-600">
        <div class="container">
            <div class="flex justify-between items-center">
                <div class="max-w-5xl text-white text-md sm:text-xl md:text-2xl xl:text-3xl">
                    {{
                        $t("lidonationWasFundedByProjectCatalyst")
                    }}
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
                        {{ $t("whenYouParticipate") }}
                    </p>
                    <p>
                        {{
                            $t("thereIsNoCatch")
                        }}
                    </p>
                    <p>
                        {{
                            $t("weHopeAreInterested")
                        }}
                    </p>
                    <p>
                        {{ $t("partOfFuture") }}
                    </p>
                    <p class="font-bold text-md sm:text-xl md:text-2xl xl:text-3xl">
                        {{ $t("welcome") }}
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
                                    <span class="xl:text-2xl font-semibold leading-7">{{ $t(faq.question) }}</span>
                                    <p class="leading-7 text-base text-slate-700">
                                        {{ $t(faq.shortAnswer) }}
                                        <span class="text-slate-400" v-if="!open"> {{ $t("continueReading") }}</span>
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
                                 v-html="$filters.markdown($t(faq.answer))"></div>
                        </DisclosurePanel>
                    </Disclosure>
                </dl>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {inject, Ref, ref, computed} from "vue";
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {Disclosure, DisclosureButton, DisclosurePanel} from '@headlessui/vue';
import {MinusSmallIcon, PlusSmallIcon, CheckIcon} from '@heroicons/vue/24/outline';
import { defineAsyncComponent } from 'vue';
import User from "../../global/Shared/Models/user";
import Wallet from '../../catalyst-explorer/models/wallet';
const ConnectWallet = defineAsyncComponent(() =>import('../../global/Shared/Components/ConnectWallet.vue'));

const user = computed(() => usePage().props.user as User);

let walletData:Ref<Wallet> = ref({});
const setWalletName = (wallet:Wallet) => {
     walletData.value = wallet;
}

const $utils: any = inject('$utils');

const faqs = [
    {
        question: "whatIsBlockchain",
        shortAnswer: "blockchainIsNewTech",
        answer: "blockchainAnswer",
    },
    {
        question: "whatCanIDoWith$ADA",
        shortAnswer: "$ADAIsTypeOfMoney",
        answer: "whatToDoWith$ADA"
    },
    {
        question: "howDoesProgramWork",
        shortAnswer: "earn$1FromArticles",
        answer: "howItWorks",
    },
]

function register() {
    let form = useForm({
        email: user.value.email
    });

    const baseUrl = usePage().props.base_url;
    form.post(`${baseUrl}/api/earn/learn/register`, {
        preserveState: false,
        preserveScroll: false
    });

}

</script>
<style scoped>
:deep(li) {
    list-style: disc;
}

:deep(ul) {
    margin-left: 2rem;
}
</style>
