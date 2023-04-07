<template>
    <div v-if="learningModule"
        class="flex flex-col gap-8 lg:flex-row flex-nowrap items-center justify-between overflow-y-hidden lg:overflow-y-visible mb-16 border-8 rounded-sm border-labs-red overflow-clip p-4">
        <div class="shrink-0  max-w-md">
            <div
                class="flex flex-col font-semibold text-labs-black text-2xl md:text-3xl lg:text-4xl xl:text-5xl 2xl:text-6xl">
                    <span class="block">
                        {{ learningModule.title }}
                    </span>
            </div>

            <div class="mb-4" v-html="$filters.markdown(learningModule.content)"></div>

            <Link :href="$utils.localizeRoute('earn/learn/modules')" type="button"
                  class="inline-flex gap-2 items-center justify-center rounded-sm border border-transparent bg-labs-red py-2 px-2 md:px-3 text-sm md:text-lg 2xl:text-xl font-medium text-white shadow-sm hover:bg-labs-black hover:text-white focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/>
                </svg>
                <span>{{ $t("Start") }}</span>
            </Link>
        </div>

        <div class="shrink relative flex flex-col justify-center items-center">
            <div class="z-10 w-96 h-80 flex items-center justify-center text-white">
                <ul class="flex gap-3 list-none">
                    <li class="border border-stone-300 py-2 px-3 rounded-sm">
                        <span class="text-stone-300">
                            {{ $t('Units') }}:
                        </span>
                        <span>{{ learningModule.topics_count }}</span>
                    </li>
                    <li class="border border-stone-300 py-2 px-3 rounded-sm">
                        <span class="text-stone-300">
                            {{ $t('Lessons') }}:
                        </span>
                        <span>{{ learningModule.lessons_count }}</span>
                    </li>
                </ul>
            </div>
            <div class="absolute w-full h-full z-0 left-[-24rem] md:left-[-18rem] top-[-4rem]">
                <svg id="visual" viewBox="0 0 900 600" width="900" height="600"
                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g transform="translate(435.86526828378726 306.0637348583508)">
                        <path
                            d="M216.6 -276.8C283.5 -249.5 342.4 -190 384.1 -112.7C425.8 -35.5 450.2 59.3 413.1 122.1C375.9 184.8 277.3 215.4 198.2 239.8C119.1 264.3 59.6 282.6 -0.9 283.9C-61.3 285.1 -122.7 269.1 -165 232.7C-207.3 196.3 -230.6 139.4 -283.2 70.2C-335.7 0.9 -417.5 -80.7 -400.9 -129.8C-384.3 -178.9 -269.3 -195.7 -186.1 -217.6C-102.9 -239.6 -51.4 -266.8 11.7 -282.9C74.8 -299 149.7 -304 216.6 -276.8"
                            fill="#C02025"></path>
                    </g>
                </svg>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {inject} from "vue";
import {Link} from '@inertiajs/vue3';
import LearningModule from "../../../../catalyst-explorer/models/learning-module";

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        learningModule: LearningModule
    }>(), {});
</script>
<style scoped>

</style>
