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
        <div class="container">
            <div class="grid grid-cols-7 gap-8">
                <div class="col-span-7 md:col-span-4 lg:col-span-5 bg-slate-100 p-6">
                    <header class="flex justify-between items-center">
                        <div>
                            <div class="flex items-center gap-3 text-slate-500">
                                <div class="flex items-center gap-1">
                                    <NewspaperIcon class="h-4 w-4"/>
                                    <p class="">Lesson</p>
                                </div>
                                <div class="flex items-center gap-1">
                                    <div>
                                        <ClockIcon class="h-4 w-4"/>
                                    </div>
                                    <div>
                                        {{
                                            new Date(lesson?.length * 1000).toISOString().substring(14, 19)
                                        }}
                                    </div>
                                </div>
                            </div>

                            <h2 class="text-2xl xl:text-3xl font-bold leading-10 tracking-tight text-slate-900">
                                {{ learningLesson?.title }}
                            </h2>
                        </div>
                        <div>
                            <div class="flex items-center gap-1">
                                <CheckBadgeIconSolid v-if="learningLesson.completed"
                                                     class="h-8 w-8 text-labs-red"/>
                                <CheckBadgeIcon v-else class="h-8 w-8 text-slate-400"/>
                            </div>
                        </div>
                    </header>
                    <div class="border-8 mt-4 p-6 shadow-xs rounded-xs h-96 bg-white/75 overflow-y-auto">
                        <div v-if="learningLesson.model"
                             v-html="$filters.markdown(learningLesson.model?.content)"></div>
                    </div>
                    <footer>

                    </footer>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {inject, ref} from "vue";
import {Link} from '@inertiajs/vue3';
import {NewspaperIcon, CheckBadgeIcon, ClockIcon} from '@heroicons/vue/24/outline';
import {CheckBadgeIcon as CheckBadgeIconSolid} from '@heroicons/vue/24/solid';
import LearningLessonData = App.DataTransferObjects.LearningLessonData;
import Footer from "../../../../vendor/laravel/nova/resources/js/layouts/Footer.vue";

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
