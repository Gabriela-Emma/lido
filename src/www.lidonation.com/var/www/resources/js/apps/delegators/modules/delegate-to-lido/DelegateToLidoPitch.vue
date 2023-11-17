<template>
    <div
        class="relative w-full p-8 rounded-sm bg-gradient-to-br from-teal-800 via-teal-600 to-teal-900 2xl:col-span-2">
        <!-- Stake to lido CTA -->
        <div>
            <div class="relative">
                <p class="text-slate-200 text-2xl xl:text-3xl 2xl:text-4xl font-semibold mb-3">
                    You can stake to Lido Nation by using our pool ticker or Pool ID in any Cardano
                    wallet that supports staking.
                </p>
                <div class="flex flex-col gap-2 border border-slate-300 divide-y divide-slate-300">
                    <div class="flex flex-row gap-2">
                        <dl class="p-3">
                            <dt class="text-slate-300">Ticker</dt>
                            <dd class="text-white font-bold break-all text-2xl">
                                LIDO
                            </dd>
                        </dl>
                    </div>
                    <div class="flex flex-row gap-2">
                        <dl class="p-3">
                            <dt class="text-slate-300">Pool ID</dt>
                            <dd class="text-white font-bold break-all text-2xl select-all">
                                b5a1a820cc3783a4e637bce79d1cc2774b241c08251e45c5d1f8f3f6
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="flex flex-col items-center gap-4 mt-16">
                    <div>
                        <p class="text-slate-100 text-2xl font-bold">
                            If you've got a wallet extension installed: <br/>
                        </p>
                    </div>
                    <div>
                        <DelegateToLido />
                    </div>
                </div>
            </div>

            <div class="absolute z-0 inline-flex mt-auto pointer-events-none right-4 bottom-3">
                <div class="w-[20rem] text-white opacity-25">
                    <img src="https://www.lidonation.com/img/llogo-transparent.png" alt="phone" class="w-full"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import DelegateToLido from "@/global/Components/DelegateToLido.vue";

</script>
