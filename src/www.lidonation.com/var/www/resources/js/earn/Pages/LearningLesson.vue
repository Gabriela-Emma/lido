<template>
    <section class="py-4 sm:py-4 md:pb-20 md:pt-8 pb-16 xl:pb-24 xl:pt-16 bg-opacity-5 text-white overflow-visible z-5"
             style="background: url('/img/ngong-road-learn.svg') 0% 35% / 100%; background-size: 100% auto;">
        <div class="container">
            <div class="text-center flex flex-col gap-1 sm:gap-2 xl:gap-3">
                <div class="text-xl sm:text-2xl md:text-4xl xl:text-6xl font-bold">
                    {{ $t("Learn2earn") }}
                </div>
                <div class="text-sm sm:text-md md:text-lg xl:text-xl flex gap-2 justify-center">
                    <span class="after:content-['.'] after:text-2xl">
                        {{ $t("Learn") }}
                    </span>
                    <span class="after:content-['.'] after:text-2xl">
                        {{ $t("Take a Quiz") }}
                    </span>
                    <span class="after:content-['.'] after:text-2xl">
                        {{ $t("Earn") }}
                    </span>
                </div>
            </div>
        </div>
    </section>
    <section class="py-8">
        <div class="container text-xl xl:text-2xl">
            <div class="mx-auto divide-y divide-slate-900/10">
                <div>
                    <h2 class="text-2xl xl:text-4xl font-bold leading-10 tracking-tight text-slate-900 text-center">
                        {{ learningLesson?.title }}
                    </h2>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {inject, ref} from "vue";
import {Link} from '@inertiajs/vue3';
import {MinusSmallIcon, PlusSmallIcon, ClockIcon} from '@heroicons/vue/24/outline';
import LearningLessonData = App.DataTransferObjects.LearningLessonData;

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        locale: string,
        lesson: LearningLessonData
    }>(), {});

let learningLesson = ref(props.lesson);
</script>


<style scoped>

</style>
