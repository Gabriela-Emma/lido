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
                        <template v-if="learningLesson.model">
                            <div v-if="learningLesson.model?.type === 'Link'" class="flex flex-col items-center justify-center gap-3">
                                <a :href="learningLesson.model?.link" target="_blank"
                                   class="px-6 p-16 border-labs-black border-2 rounded-sm flex  justify-center items-center text-xl xl:text-3xl text-labs-red hover:text-labs-black hover:bg-slate-200">
                                    {{learningLesson.model?.title}}

                                    <ClockIcon class="h-10 w-10"/>

                                    <p class="max-w-md">
                                        Read Article in new take. Return to take quiz after you've read the article.
                                    </p>
                                </a>
                            </div>
                            <div v-else v-html="learningLesson.model?.content"></div>
                        </template>
                    </div>
                    <footer>
                        <div class="bg-labs-red text-white px-8 py-16 mt-8">
                            <div class="" v-if="question">
                                <div class="text-slate-300 mb-2 text-center">Quiz</div>
                                <div class="rounded-sm border border-dashed border-white p-4 flex flex-col gap-6">
                                    <div>
                                        <p class="text-lg md:text-xl xl:text-2xl 2xl:text-3x xl:leading-12 2xl:leading-12 inline box-border box-decoration-clone p-2 tracking-wide bg-white text-teal-900 relative -left-8">
                                            {{ question?.title }}
                                        </p>
                                    </div>
                                    <ul class="mt-4 space-y-2 relative h-full w-full ">
                                        <template v-for="answer in question.answers">
                                            <li class="flex cursor-pointer border border-slate-200 w-full justify-between items-center p-2 bg-slate-100 rounded-sm text-slate-800 answer">
                                                {{ answer.content }}
                                            </li>
                                        </template>
                                    </ul>
                                    <div class="mt-8 flex justify-end">
                                        <button type="button"
                                                class="rounded-sm bg-labs-black px-3.5 py-2.5 text-md xl:text-xl font-semibold text-white shadow-sm hover:bg-labs-black/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-labs-black ml-auto">
                                            Submit
                                        </button>
                                    </div>
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
import {NewspaperIcon, CheckBadgeIcon, ClockIcon, ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/outline';
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
console.log(learningLesson.value);
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
