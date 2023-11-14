<script lang="ts">
import LayoutWithSidebar from "../Layouts/LayoutWithSidebar.vue";

export default {
    layout: LayoutWithSidebar
};
</script>
<template>
    <header class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 text-slate-500">
                <div class="flex items-center gap-1">
                    <NewspaperIcon class="w-4 h-4"/>
                    <p class="">{{$t('lesson')}}</p>
                </div>
                <div class="flex items-center gap-1">
                    <div>
                        <ClockIcon class="w-4 h-4"/>
                    </div>
                    <div>
                        {{
                            new Date(lesson?.length * 1000).toISOString().substring(14, 19)
                        }}
                    </div>
                </div>
            </div>

            <h2 class="text-2xl font-bold leading-10 tracking-tight xl:text-3xl text-slate-900">
                {{ learningLesson?.title }}
            </h2>
        </div>
        <div>
            <div class="flex items-center gap-1">
                <CheckBadgeIconSolid v-if="learningLesson.completed"
                                     class="w-8 h-8 text-labs-green"/>
                <CheckBadgeIcon v-else class="w-8 h-8 text-slate-400"/>
            </div>
        </div>
    </header>
    <div class="mt-4 p-6 shadow-xs rounded-xs h-[40rem] bg-slate-100/75 overflow-y-auto">
        <template v-if="learningLesson.model">
            <div v-if="learningLesson.model?.type === 'Link'"
                 class="flex flex-col items-center justify-center h-full gap-3">
                <a :href="learningLesson.model?.link" target="_blank"
                   class="flex flex-col items-center justify-center gap-4 px-6 py-16 text-xl border-2 rounded-sm border-labs-black xl:text-3xl text-labs-black hover:text-teal-light-600 hover:bg-slate-200">
                    {{ learningLesson.model?.title }}

                    <ArrowTopRightOnSquareIcon class="w-16 h-16" />

                    <p class="max-w-md px-8 mx-auto text-xl text-center text-slate-800">
                       {{$t('readInNewTab')}}
                    </p>
                </a>
            </div>
            <div v-else v-html="learningLesson.model?.content"></div>
        </template>
    </div>
    <footer>
        <div class="px-8 py-16 mt-8 text-white" :class="[quizBackGround]">
            <div class="" v-if="question">
                <!--an answer exists already submitted-->
                <div v-if="userLatestResponse">
                    <div class="mb-2 text-center text-slate-300">{{$t('quiz')}}</div>
                    <div class="mb-2 text-center text-slate-500">
                        <div class="text-white">
                            <div v-if="userLatestResponse.correct === true">
                                {{$t('gotIt')}}!
                            </div>
                            <div v-else>
                                {{$t('uIncorrect')}} :(
                            </div>
                        </div>
                    </div>
                    <form class="flex flex-col gap-6 p-4 border border-white border-dashed rounded-sm">
                        <div class="flex justify-between">
                            <p class="box-border relative inline p-2 text-lg tracking-wide text-teal-900 bg-white md:text-xl xl:text-2xl 2xl:text-3x xl:leading-12 2xl:leading-12 box-decoration-clone -left-8">
                                {{ question?.title }}
                            </p>
                        </div>
                        <ul class="relative w-full h-full mt-4 space-y-2 ">
                            <template v-for="answer in question.answers" :key="answer.id">
                                <li class="mt-2 transition delay-150 hover:ease-in">
                                    <label class="w-full">
                                        <input type="radio" class="sr-only peer" name="answer"
                                               :id="answer.id" v-model="userSelectionId" />

                                        <div class="w-full p-5 bg-white rounded-md" :class="{
                                                            'text-green-400' : userLatestResponse.correct === true && userLatestResponse.questionAnswerId === answer.id,
                                                            'text-orange-500': !userLatestResponse.correct === true && userLatestResponse.questionAnswerId === answer.id,
                                                            'text-slate-600': userLatestResponse.questionAnswerId !== answer.id
                                                        }">
                                            <div class="flex items-center justify-between">
                                                <p class="pr-8 text-sm font-semibold">
                                                    {{ answer.content }}
                                                </p>
                                                <div class="flex-shrink-0 w-4 h-4">
                                                    <svg fill='currentColor' id="Layer_1_1_"
                                                         style="enable-background:new 0 0 16 16;"
                                                         version="1.1" viewBox="0 0 16 16"
                                                         xml:space="preserve"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink"><circle cx="8" cy="8" r="8"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </li>
                            </template>
                        </ul>

                        <div v-if="awardedAmount"
                             class="inline-flex flex-wrap items-center gap-2 p-2 mx-auto mt-8 text-lg font-bold border rounded-sm text-labs-black border-labs-black">
                            <div class="flex items-center gap-4">
                                <div class="text-slate-700">{{$t('awarded')}}</div>
                                <div>{{ awardedAmount }}</div>
                            </div>
                            <div class="flex gap-1" v-if="assetMetadata?.ticker">
                                <div>{{ assetMetadata?.ticker }}</div>
                                <div v-if="assetMetadata?.logo">
                                    <img class="inline-flex w-5 h-5 rounded-full"
                                         alt="asset logo"
                                         :src="'data:image/png;base64,'+`${assetMetadata?.logo}`">
                                </div>
                            </div>

                        </div>

                        <div class="flex justify-center font-bold lg:text-lg xl:text-xl" v-if="retryAt" >
                            <countdown :time="retryAt" v-slot="{ days, hours, minutes, seconds }" class="flex flex-row">
                                <span class="mr-1 text-slate-200"> {{$t('tryIn')}}: </span>
                                <div  v-if="locale !== 'sw'">
                                    {{ hours }} {{$t('hours')}}, {{ minutes }} {{$t('minutes')}}, {{ seconds }} {{$t('seconds')}}.
                                </div>
                                <div  v-if="locale == 'sw'" >
                                    {{$t('hours')}} {{ hours }}, {{$t('minutes')}} {{ minutes }},  {{$t('seconds')}} {{ seconds }}.
                                </div>
                            </countdown>
                        </div>

                        <div class="flex justify-end mt-8">
                            <button type="button"
                                    @click.prevent="submit"
                                    :disabled="true"
                                    :class="{ 'opacity-25 cursor-not-allowed': true }"
                                    class="rounded-sm bg-labs-black px-3.5 py-2.5 text-md xl:text-xl font-semibold text-white shadow-sm hover:bg-labs-black/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-labs-black ml-auto">
                                {{('submit')}}
                            </button>
                        </div>
                    </form>
                </div>

                <!--actual flow if not submitted already-->
                <div v-if="!userLatestResponse">
                    <div class="mb-2 text-center text-slate-300">{{$t('quiz')}}</div>
                    <form class="flex flex-col gap-6 p-4 border border-white border-dashed rounded-sm">
                        <div>
                            <p class="box-border relative inline p-2 text-lg tracking-wide text-teal-900 bg-white md:text-xl xl:text-2xl 2xl:text-3x xl:leading-12 2xl:leading-12 box-decoration-clone -left-8">
                                {{ question?.title }}
                            </p>
                        </div>
                        <ul class="relative w-full h-full mt-4 space-y-2" v-if="!nextLessonAt">
                            <template v-for="answer in question.answers" :key="answer.id">
                                <li class="mt-2">
                                    <label class="w-full cursor-pointer">
                                        <input type="radio" class="sr-only peer" name="answer"
                                               :id="answer.id" :value="answer.id"
                                               v-model="userSelectionId"/>
                                        <div
                                            class="w-full p-5 text-gray-500 transition-all bg-white rounded-md hover:shadow peer-checked:text-labs-black peer-checked:bg-sky-400 peer-checked:ring-blue-light-900 peer-checked:ring-4 peer-checked:border-transparent">
                                            <div class="flex items-center justify-between">
                                                <p class="pr-8 text-sm font-semibold">{{
                                                        answer.content
                                                    }}</p>
                                                <div class="flex-shrink-0 w-4 h-4">
                                                    <svg fill='currentColor' id="Layer_1_1_"
                                                         style="enable-background:new 0 0 16 16;"
                                                         version="1.1" viewBox="0 0 16 16"
                                                         xml:space="preserve"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink"><circle cx="8" cy="8" r="8"/></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </li>
                            </template>
                        </ul>
                        <div class="flex justify-center font-bold lg:text-lg xl:text-xl"
                             v-if="nextLessonAt && !retryAt">
                            <countdown :time="nextLessonAt" v-slot="{ days, hours, minutes, seconds }" class="flex flex-row">
                                <span class="block mb-2 mr-1 text-center text-slate-300">{{$t('quizUnlocksIn')}}: </span>
                                <div v-if="locale !== 'sw'">
                                    {{ hours }} {{$t('hours')}}, {{ minutes }} {{$t('minutes')}}, {{ seconds }} {{$t('seconds')}}.
                                </div>
                                <div v-if="locale === 'sw'" >
                                    {{$t('hours')}} {{ hours }}, {{$t('minutes')}} {{ minutes }},  {{$t('seconds')}} {{ seconds }}.
                                </div>
                            </countdown>
                        </div>
                        <div class="flex justify-end mt-8">
                            <button type="button"
                                    @click.prevent="submit"
                                    :disabled="!!userLatestResponse || nextLessonAt > 0 "
                                    :class="{ 'opacity-25 cursor-not-allowed': !!userLatestResponse || nextLessonAt > 0 }"
                                    class="rounded-sm bg-labs-black px-3.5 py-2.5 text-md xl:text-xl font-semibold text-white shadow-sm hover:bg-labs-black/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-labs-black ml-auto">
                                {{('submit')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center" v-else>
                <p class="lg:text-xl">Error loading quiz. Contact support.</p>
            </div>
        </div>
    </footer>
</template>
<script lang="ts" setup>
import {computed, inject, ref, Ref} from "vue";
import {storeToRefs} from 'pinia';
import User from "@/global/models/user";
import {useForm, usePage} from '@inertiajs/vue3';
import {ArrowTopRightOnSquareIcon, CheckBadgeIcon, ClockIcon, NewspaperIcon} from '@heroicons/vue/24/outline';
import {CheckBadgeIcon as CheckBadgeIconSolid} from '@heroicons/vue/24/solid';
import Footer from "../../../../vendor/laravel/nova/resources/js/layouts/Footer.vue";
import {useAnswerResponseStore} from "../store/answer-response-store"
import Countdown from "@/global/Components/countdown";
import moment from "moment-timezone";
import LearningLessonData = App.DataTransferObjects.LearningLessonData;
import AnswerResponseData = App.DataTransferObjects.AnswerResponseData;
import RewardData = App.DataTransferObjects.RewardData;
import { useWalletStore } from "@/global/stores/wallet-store";
import Wallet from '@apps/catalyst-explorer/models/wallet';
import {useLearnerDataStore} from "../store/learner-data-store";

const $utils: any = inject('$utils');
const user = computed(() => usePage().props.user as User)
let locale = computed(() => usePage().props.locale);

const props = withDefaults(
    defineProps<{
        userResponses: AnswerResponseData[],
        nextLessonAt?: string,
        lesson: LearningLessonData
        reward: RewardData
    }>(), {});

let answerResponseStore = useAnswerResponseStore();

let learnerDataStore = useLearnerDataStore();
learnerDataStore.getLearnerData();
const {learnerData} = storeToRefs(learnerDataStore);

let learningLesson = ref(props.lesson);
let submitted: Ref<boolean> = ref(false);
let userReward = ref(props.reward);
let awardedAmount, assetMetadata, quiz, questions, question, answers, answer, correct,
    userSelectionId = ref(null);

const currentDay = moment()
    .tz('Africa/Nairobi')
    .day();

let nextLessonAt = computed(() => {
    const nextLesson = moment(learnerData.value.nextLessonAt).tz('Africa/Nairobi').startOf('day')
        .diff(
            moment().tz('Africa/Nairobi')
        );
    if (nextLesson > 0) {
        return nextLesson
    }
    return null
});

let userLatestResponse = computed(() => {
    //filter out responses older than midnight previous day East Africa Time
    const responses = [...props.userResponses].filter((response) => {
        if (response.correct) {
            return true;
        }

        const lastAttempt = moment(response.createdAt)
            .tz('Africa/Nairobi')
            .day();

        return currentDay === lastAttempt
    });

    if (responses?.length > 0) {
        return responses[0];
    }
    return null;
});

if (userReward.value?.amount && userReward.value?.asset == 'lovelace') {
    awardedAmount = userReward.value?.amount / 1000000;
    assetMetadata = userReward.value?.asset_details.metadata;
}

const quizBackGround = computed(() => {
    if (userLatestResponse.value?.correct === true) {
        return 'bg-labs-green';
    } else if (userLatestResponse.value?.answer.correct === false) {
        return 'bg-labs-orange';
    }

    return 'bg-labs-red';
});

const retryAt = computed(() => {
    if (learningLesson.value.retryAt) {
        return moment(learningLesson.value.retryAt).tz('Africa/Nairobi').startOf('day')
            .diff(
                moment().tz('Africa/Nairobi')
            );
    }
    return null;
});

if (userLatestResponse.value) {
    quiz = userLatestResponse.value?.quiz;
    question = userLatestResponse.value?.question;
    answer = userLatestResponse.value?.answer;
    correct = answer.correct;
} else {
    if (learningLesson.value?.quizzes?.length > 0) {
        quiz = learningLesson.value?.quizzes[0];
        questions = quiz?.questions;
        if (questions?.length > 0) {
            question = ref(questions[Math.floor(Math.random() * questions?.length)]);
        }
    }
}

answers = question?.value?.answers;

let walletStore = useWalletStore();
let {walletData} = storeToRefs(walletStore);
let myWallet: Ref<Wallet> = computed(() => walletData.value);

function submit() {
    submitted.value = true;

    // submit the form
    const baseUrl = usePage().props.ziggy.url;
    let form = useForm({
        learningLessonHash: learningLesson.value?.hash,
        question_answer_id: userSelectionId.value,
        user_id: user?.value?.id,
        quiz_id: quiz?.id,
        question_id: question?.value.id,
        wallet_stake_address: myWallet?.value?.stakeAddress,
        wallet_address: myWallet?.value?.address,

    });
    answerResponseStore.submitAnswer(baseUrl, form);
    useLearnerDataStore().getLearnerData();
}
</script>


<style scoped>

</style>
