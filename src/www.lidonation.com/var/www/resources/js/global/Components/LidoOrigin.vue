<template>
    <div v-if="!!lidoStats" class=" md:grid md:grid-cols-2 2xl:grid-cols-5 lido-origin">
        <div
            class="w-full p-8 rounded-sm bg-gradient-to-tl from-primary-10 to-primary-20 via-primary30 via-slate-50 text-slate-800 2xl:col-span-3">
            <h2 class="md:text-4xl xl:text-5xl">
                Lido Nation: Origin Story
            </h2>
            <p class="leading-loose tracking-wide md:text-xl xl:text-2xl">
                The Lido Nation staking pool launched on the Cardano mainnet in December 2020. From there, a
                couple of dreamers started to talk about what our little corner of the network should look
                like.
                As a pair of curious birds, who get excited about learning and sharing knowledge, we noticed
                that there wasn’t enough of the kind of material we wanted to read about blockchain, and
                Cardano.
            </p>
            <b class="block mt-2 text-3xl font-bold font-title xl:mt-4">So we started to write it!</b>
        </div>
        <div class="w-full p-2 rounded-sm bg-gradient-to-bl md:p-8 2xl:col-span-2"
            :class="[`from-${theme}-700`, `via-${theme}-600`, `to-${theme}-500`]">
            <div class="flex flex-row flex-wrap justify-around font-bold text-slate-50">
                <!-- Analytics -->
                <div class="p-2">
                    <div class="flex justify-center w-32 h-32 p-3 border rounded-full shadow-lg shadow-inner"
                        :class="[`border-${theme}-500`, `bg-${theme}-700`]">
                        <div class="inline-flex flex-col items-center justify-center">
                            <div class="inline-block text-4xl font-bold">
                                <AnimateNumber v-if="lidoStats" :duration="1.5" :digits="lidoStats?.newsArticles" />
                                <p v-else>0</p>
                            </div>
                            <div class="inline-block text-xs text-center">
                                News Articles
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Analytics -->
                <div class="p-2">
                    <div class="flex justify-center w-32 h-32 p-3 border rounded-full shadow-lg shadow-inner"
                        :class="[`border-${theme}-500`, `bg-${theme}-700`]">
                        <div class="inline-flex flex-col items-center justify-center">
                            <div class="inline-block text-4xl font-bold">
                                <AnimateNumber v-if="lidoStats" :duration="1.5" :digits="lidoStats?.educationalArticles" />
                                <p v-else>0</p>
                            </div>
                            <div class="inline-block text-xs text-center">
                                Educational Articles
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics -->
                <div class="p-2">
                    <div class="flex justify-center w-32 h-32 p-3 border rounded-full shadow-lg shadow-inner"
                        :class="[`border-${theme}-500`, `bg-${theme}-700`]">
                        <div class="inline-flex flex-col items-center justify-center">
                            <div class="inline-block text-4xl font-bold">
                                <AnimateNumber v-if="lidoStats" :duration="2.2"
                                    :digits="lidoStats?.minutesOfAudioReadings" />
                                <p v-else>0</p>
                            </div>
                            <div class="inline-block text-xs text-center">
                                Minutes of audio readings
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics -->
                <div class="p-2">
                    <div class="flex justify-center w-32 h-32 p-3 border rounded-full shadow-lg shadow-inner"
                        :class="[`border-${theme}-500`, `bg-${theme}-700`]">
                        <div class="inline-flex flex-col items-center justify-center">
                            <div class="inline-block text-5xl font-bold">
                                <AnimateNumber v-if="lidoStats" :duration="4"
                                    :digits="lidoStats?.hrsOfTwitterSpacesWork" />
                                <p v-else>0</p>
                            </div>
                            <div class="inline-block text-sm text-center">
                                Hrs of twitter spaces/wk
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics -->
                <div class="p-2" wire:poll.60s.visible="get30DaysPageViews">
                    <div class="flex justify-center w-32 h-32 p-3 border rounded-full shadow-lg shadow-inner"
                        :class="[`border-${theme}-500`, `bg-${theme}-700`]">
                        <div class="inline-flex flex-col items-center justify-center">
                            <div class="inline-block text-3xl font-bold">
                                <AnimateNumber v-if="lidoStats" :duration="2" :digits="lidoStats?.thirtyDaysPageViews" />
                                <p v-else>0</p>
                            </div>
                            <div class="inline-block text-sm text-center">
                                30-day Page Views
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics -->
                <div class="p-2" wire:poll.60s.visible="get30DaysCatalystQueries">
                    <div class="flex justify-center p-3 rounded-full border border-{{theme}}-500 w-32 h-32 bg-{{theme}}-700 shadow-inner shadow-lg"
                        :class="[`border-${theme}-500`, `bg-${theme}-700`]">
                        <div class="inline-flex flex-col items-center justify-center">
                            <div class="inline-block text-3xl font-bold">
                                <AnimateNumber v-if="lidoStats" :duration="3"
                                    :digits="lidoStats?.thirtyDaysCatalystQueries" />
                                <p v-else>0</p>

                            </div>
                            <div class="inline-block text-sm text-center">
                                30-day Catalyst Queries
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <OriginPlaceholder v-if="!lidoStats"  />
</template>


<script lang="ts" setup>
import axios from 'axios';
import { Ref } from 'vue';
import { ref, defineAsyncComponent } from 'vue';
import route from 'ziggy-js';
import OriginPlaceholder from './partials/OriginPlaceholder.vue';
const AnimateNumber = defineAsyncComponent(() => import('./partials/AnimateNumber.vue'));




const props = withDefaults(
    defineProps<{
        theme: string
    }>(), {
    theme: 'teal'
})

interface LidoStats {
    thirtyDaysCatalystQueries: number
    thirtyDaysPageViews: number
    hrsOfTwitterSpacesWork: number
    minutesOfAudioReadings: number
    educationalArticles: number
    newsArticles: number
}

let lidoStats: Ref<LidoStats | null> = ref(null);

let getStats = async () => {
    lidoStats.value = (await axios.get(route('lidoStats'))).data
}

getStats()


</script>