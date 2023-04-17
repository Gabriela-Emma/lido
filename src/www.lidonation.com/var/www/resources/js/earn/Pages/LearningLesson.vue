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
                            <div v-if="learningLesson.model?.type === 'Link'" class="flex flex-col items-center justify-center gap-3 h-full">
                                <a :href="learningLesson.model?.link" target="_blank"
                                   class="px-6 py-16 border-labs-black border-2 rounded-sm flex flex-col justify-center gap-4 items-center text-xl xl:text-3xl text-labs-black hover:text-labs-black hover:bg-slate-200">
                                    {{learningLesson.model?.title}}

                                    <ArrowTopRightOnSquareIcon class="h-16 w-16" />

                                    <p class="text-center text-xl text-slate-800 max-w-md mx-auto px-8">
                                        Read Article in new tab. Return to take quiz after you've read the article.
                                    </p>
                                </a>
                            </div>
                            <div v-else v-html="learningLesson.model?.content"></div>
                        </template>
                    </div>
                    <footer>
                        <div class="text-white px-8 py-16 mt-8" :class="[quizBackGround]">
                            <div class="" v-if="question">
                                <!--an aswer exists already submitted-->
                                <div v-if="submitted">
                                    <div class="text-slate-300 mb-2 text-center">Quiza</div>
                                    <div v-if="submitted" class="text-slate-500 mb-2 text-center">
                                        <div v-if="correct == 'true'" class="text-white">
                                            Correct
                                        </div>
                                        <div v-if="correct == 'false'" class="text-white">
                                            Incorrect
                                        </div>
                                    </div>
                                    <form class="rounded-sm border border-dashed border-white p-4 flex flex-col gap-6">
                                        <div>
                                            <p class="text-lg md:text-xl xl:text-2xl 2xl:text-3x xl:leading-12 2xl:leading-12 inline box-border box-decoration-clone p-2 tracking-wide bg-white text-teal-900 relative -left-8">
                                                {{ question?.title }}
                                            </p>
                                        </div>
                                        <ul class="mt-4 space-y-2 relative h-full w-full ">
                                            <template v-for="answer in question.answers" :key="answer.id">
                                                <li class="mt-2 transition hover:ease-in delay-150">
                                                    <label v-if="selectedAnswer == answer.id" class="w-full">
                                                        <input  type="radio" 
                                                                class="peer sr-only" 
                                                                name="answer" 
                                                                :id="answer.id"
                                                                v-model="selectedAnswer"/>
                                                        <div class="w-full rounded-md bg-white p-5" :class="correct == 'true' ? 'text-green-400' : 'text-orange-500'">
                                                            <div class="flex items-center justify-between">
                                                            <p class="text-sm font-semibold">{{ answer.content }}</p>
                                                            <div>
                                                                <svg width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m10.6 13.8l-2.175-2.175q-.275-.275-.675-.275t-.7.3q-.275.275-.275.7q0 .425.275.7L9.9 15.9q.275.275.7.275q.425 0 .7-.275l5.675-5.675q.275-.275.275-.675t-.3-.7q-.275-.275-.7-.275q-.425 0-.7.275ZM12 22q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z" /></svg>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                    <label v-if="selectedAnswer != answer.id" class="w-full">
                                                        <input  type="radio" 
                                                                class="peer sr-only" 
                                                                name="answer" 
                                                                :id="answer.id"/>
                                                        <div class="w-full rounded-md bg-white p-5 text-gray-500">
                                                            <div class="flex items-center justify-between">
                                                            <p class="text-sm font-semibold">{{ answer.content }}</p>
                                                            <div>
                                                                <svg width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m10.6 13.8l-2.175-2.175q-.275-.275-.675-.275t-.7.3q-.275.275-.275.7q0 .425.275.7L9.9 15.9q.275.275.7.275q.425 0 .7-.275l5.675-5.675q.275-.275.275-.675t-.3-.7q-.275-.275-.7-.275q-.425 0-.7.275ZM12 22q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z" /></svg>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </li>
                                            </template>
                                        </ul>
                                        <div class="mt-8 flex justify-end">
                                            <button type="button"
                                                    @click.prevent="submit"
                                                    :disabled="true"
                                                    :class="{ 'opacity-25 cursor-not-allowed': true }"
                                                    class="rounded-sm bg-labs-black px-3.5 py-2.5 text-md xl:text-xl font-semibold text-white shadow-sm hover:bg-labs-black/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-labs-black ml-auto">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!--actual flow if not submitted already-->
                                <div v-if="!submitted">
                                    <div class="text-slate-300 mb-2 text-center">Quiz</div>
                                    <form class="rounded-sm border border-dashed border-white p-4 flex flex-col gap-6">
                                        <div>
                                            <p class="text-lg md:text-xl xl:text-2xl 2xl:text-3x xl:leading-12 2xl:leading-12 inline box-border box-decoration-clone p-2 tracking-wide bg-white text-teal-900 relative -left-8">
                                                {{ question?.title }}
                                            </p>
                                        </div>
                                        <ul class="mt-4 space-y-2 relative h-full w-full ">
                                            <template v-for="answer in question.answers" :key="answer.id">
                                                <li class="mt-2 transition hover:ease-in delay-150">
                                                    <label class="cursor-pointer w-full">
                                                        <input  type="radio" class="peer sr-only" 
                                                                name="answer" 
                                                                :id="answer.id"
                                                                @click="updateSelectedAnswer(answer.id)"/>
                                                        <div class="w-full rounded-md bg-white text-gray-500 p-5 transition-all hover:shadow peer-checked:text-red-600">
                                                            <div class="flex items-center justify-between">
                                                            <p class="text-sm font-semibold">{{ answer.content }}</p>
                                                            <div>
                                                                <svg width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m10.6 13.8l-2.175-2.175q-.275-.275-.675-.275t-.7.3q-.275.275-.275.7q0 .425.275.7L9.9 15.9q.275.275.7.275q.425 0 .7-.275l5.675-5.675q.275-.275.275-.675t-.3-.7q-.275-.275-.7-.275q-.425 0-.7.275ZM12 22q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z" /></svg>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </li>
                                            </template>
                                        </ul>
                                        <div class="mt-8 flex justify-end">
                                            <button type="button"
                                                    @click.prevent="submit"
                                                    :disabled="disableSubmitButton"
                                                    :class="{ 'opacity-25 cursor-not-allowed': disableSubmitButton }"
                                                    class="rounded-sm bg-labs-black px-3.5 py-2.5 text-md xl:text-xl font-semibold text-white shadow-sm hover:bg-labs-black/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-labs-black ml-auto">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
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
import {Ref, inject, ref, computed, watch} from "vue";
import User from "../../global/Shared/Models/user";
import {useForm, usePage} from '@inertiajs/vue3';
import {NewspaperIcon, CheckBadgeIcon, ClockIcon, ArrowTopRightOnSquareIcon } from '@heroicons/vue/24/outline';
import {CheckBadgeIcon as CheckBadgeIconSolid} from '@heroicons/vue/24/solid';
import LearningLessonData = App.DataTransferObjects.LearningLessonData;
import Footer from "../../../../vendor/laravel/nova/resources/js/layouts/Footer.vue";
import {useAnswerResponseStore} from "../store/answer-response-store" 
import { storeToRefs } from "pinia";

// load responses from store
let answerResponseStore = useAnswerResponseStore();
let {answerResponseData} = storeToRefs(answerResponseStore);

const $utils: any = inject('$utils');
const user = computed(() => usePage().props.user as User)

const props = withDefaults(
    defineProps<{
        locale: string,
        lesson: LearningLessonData
    }>(), {});

let learningLesson = ref(props.lesson);
let quiz, questions, question, answers, correctAnswerId, miki;
if (learningLesson.value?.quizzes?.length > 0) {
    quiz = learningLesson.value?.quizzes[0];
    questions = quiz?.questions;
    if (questions?.length > 0) {
        question = ref(questions[Math.floor(Math.random() * questions?.length)]);
        answers = question.value?.answers;
        correctAnswerId = answers.filter((ans) => {
            return ans.correctness == 'true';
        })[0].id;

    }
}


let selectedAnswer:number = ref() as null;
let disableSubmitButton = ref(true);
let submitted:Ref<boolean> = ref(false);
let correct = ref('');
let quizBackGround = ref('bg-labs-red');

watch(answerResponseData, () => {
    let myInitialResponse  = answerResponseData.value.filter((response) => {
        if (response.user_id == user.value?.id ) {
            return response;
        }
    })

    if (myInitialResponse.length > 0) {
        selectedAnswer = myInitialResponse[0].question_answer_id;
        correctness(correctAnswerId, selectedAnswer);
        submitted.value = true;
        disableSubmitButton.value = true;
    }
})

let updateSelectedAnswer = (answer:number) => {
    selectedAnswer = answer;
    disableSubmitButton.value = false;
}


let submit = () => {
    submitted.value = true;
    correctness(correctAnswerId, selectedAnswer);
    setQuizBackground(correctAnswerId.value);

    // submit the form
    const baseUrl = usePage().props.base_url;
    let form= useForm({
        question_answer_id: selectedAnswer,
        user_id: user?.value?.id,
        quiz_id: quiz?.id,
        question_id: question?.value.id
    });
    answerResponseStore.submitAnswer(baseUrl, form);
}

let correctness = (correctId:number, responseId:number) => {
    correct.value = (correctId == responseId) ? 'true' : 'false';
    setQuizBackground(correct.value);
}

let setQuizBackground= (correctness: string) => {
    if ( correctness == 'true') {
        quizBackGround.value = 'bg-labs-green';
    } else if  (correctness == 'false'){
        quizBackGround.value = 'bg-labs-orange';
    }
};
</script>


<style scoped>

</style>
