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
                <div class="col-span-7 md:col-span-4 xl:col-span-5 border-8 border-labs-red p-8 rounded-sm">
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
                    <div class="mt-4 p-6 shadow-xs rounded-xs h-[40rem] bg-slate-100/75 overflow-y-auto">
                        <div v-if="learningLesson.model" v-html="learningLesson.model?.content"></div>
                    </div>
                    <footer>
                        <div class="bg-labs-red text-white px-8 py-16 mt-8 text-center">
                            <div class="flex flex-col items-center gap-6" v-if="question">
                                <div>
                                    <div class="text-slate-300">Quiz</div>
                                    <h2 class="text-2xl xl:text-3xl font-bold leading-10 tracking-tight">
                                        {{ question?.title }}
                                    </h2>
                                </div>
                                <ul class="flex justify-center gap-5 flex-wrap">
                                    <template v-for="answer in question.answers">
                                        <li class="p-4 bg-white text-labs-black rounded-sm">
                                            {{ answer.content }}
                                        </li>
                                    </template>
                                </ul>
                                <div class="mt-8">
                                    <button type="button"
                                            class="rounded-sm bg-labs-black px-3.5 py-2.5 text-md xl:text-xl font-semibold text-white shadow-sm hover:bg-labs-black/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-labs-black ml-auto">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
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

let question, questions;
if (learningLesson.value?.quizzes?.length > 0) {
    questions = learningLesson.value?.quizzes[0]?.questions;
    if (questions?.length > 0) {
        question = ref(questions[Math.floor(Math.random() * questions?.length)]);
    }
}
</script>


<style scoped>

</style>
