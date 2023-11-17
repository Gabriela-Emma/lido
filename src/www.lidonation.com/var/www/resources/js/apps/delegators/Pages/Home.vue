<template>
    <Head title="Lido Delegators" />

    <section class="container relative py-8">
        <div class="flex w-full h-auto gap-">
            <DelegateToLidoPitch class="w-full xl:w-2/5" />

            <Blocks class="w-full xl:w-3/5"></Blocks>
        </div>
    </section>

    <section class="container relative">
        <EveryEpoch />
    </section>

    <section class="relative pt-6 pb-16 bg-white">
        <div class="container relative">
            <LidoOrigin />
        </div>
    </section>

    <section class="relative mb-16">
        <div class="relative overflow-hidden bg-white">
            <div class="lg:absolute lg:inset-y-0 lg:left-0 lg:w-1/2">
                <img class="object-cover w-full h-56 sm:h-72 md:h-96 lg:w-full lg:h-full"
                    src="https://www.lidonation.com/img/lido-pond-1.jpg" alt="">
            </div>

            <div class="container h-full">
                <div class="relative z-10 h-full ml-auto bg-white pb8 lg:max-w-2xl lg:w-full">
                    <svg class="hidden lg:block absolute left-0 inset-y-0 h-full w-60 text-white transform translate-x1/2 rotate-[175deg] translate-x-[-6rem] 2xl:translate-x-[-9rem] -translate-y-1"
                        fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                        <polygon points="50,0 100,0 50,100 0,100" />
                    </svg>

                    <div class="mx-auto max-w-7xl">
                        <div class="pt-16 sm:text-center lg:text-left pl-28 2xl:pl-16">
                            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">
                                    Our Why
                                </span>
                            </h1>
                            <div
                                class="mt-3 text-base text-slate-600 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                <p>
                                    Blockchains are about decentralization, and decentralization means involving a
                                    lot
                                    of people, from lots of places of the world.
                                    The more decentralized a network is, the stronger it is. Therefore, a growing
                                    and
                                    resilient network needs to appeal not just to the people who are already in it:
                                </p>
                                <p class="text-xl font-bold text-slate-800">
                                    It needs to be attractive to newcomers, to curious explorers from other
                                    blockchains,
                                    and to people who don’t just speak English!
                                </p>
                                <p>We write about introductory topics, complex topics, and news from the
                                    block-o-sphere.</p>
                                <p>
                                    No matter the topic, we write in a way that a newcomer could start to understand
                                    -
                                    and an O.G. might still learn something!
                                </p>
                                <p>
                                    We started to translate our articles into Swahili and Spanish - two high-impact
                                    languages to reach new continents with accessible blockchain education.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-16 bg-white">
        <div class="container">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl 2xl:text-5xl">
                        Ready to jump in the Pool?
                    </h2>
                    <p class="max-w-3xl mt-3 text-lg text-slate-600">
                        Whether you showed up today because you saw that we got the Foundation delegation, or
                        because you like the articles,
                        or because you are using the Project Catalyst tool, or because you just can’t wait to get
                        some Phuffy - we are glad you are here.
                    </p>
                    <p>
                        You can stake to Lido Nation by using our pool ticker LIDO or Pool ID
                        <span
                            class="font-bold break-all select-all">b5a1a820cc3783a4e637bce79d1cc2774b241c08251e45c5d1f8f3f6</span>
                        in any Cardano wallet that supports staking.
                    </p>
                    <p>
                        After you delegate, be sure to create a login here at the website and register your wallet!
                        This step is optional - you can choose not to register your wallet.
                    </p>
                    <p>
                        Your stake will still support our pool and help secure the Cardano network, and you will
                        still receive all your staking rewards, automatically.
                        Registering is the only way to get your free Phuffy coins, and get access to other pool
                        member benefits.
                    </p>
                    <p>
                        If you need help, drop us a line: <a :href="route('community')"> Connect</a>.
                    </p>
                    <p class="font-semibold">Because the future is for everyone!</p>
                </div>
                <DelegateToLido class="" :column="false"></DelegateToLido>
            </div>

        </div>
    </section>
</template>

<script lang="ts" setup>
import EveryEpoch from "@apps/delegators/modules/everyEpoch/EveryEpoch.vue";
import Blocks from "@apps/delegators/modules/blocks/Blocks.vue";
import LidoOrigin from "@/global/Components/LidoOrigin.vue";
import DelegateToLidoPitch from "@apps/delegators/modules/delegate-to-lido/DelegateToLidoPitch.vue";
import DelegateToLido from "@/global/Components/DelegateToLido.vue";
import {Head} from "@inertiajs/vue3";

</script>

<style scoped></style>
