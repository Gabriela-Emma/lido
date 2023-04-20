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
                            <div v-if="learningLesson.model?.type === 'Link'"
                                 class="flex flex-col items-center justify-center gap-3 h-full">
                                <a :href="learningLesson.model?.link" target="_blank"
                                   class="px-6 py-16 border-labs-black border-2 rounded-sm flex flex-col justify-center gap-4 items-center text-xl xl:text-3xl text-labs-black hover:text-teal-light-600 hover:bg-slate-200">
                                    {{ learningLesson.model?.title }}

                                    <ArrowTopRightOnSquareIcon class="h-16 w-16"/>

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
                                <!--an answer exists already submitted-->
                                <div v-if="userLatestResponse">
                                    <div class="text-slate-300 mb-2 text-center">Quiz</div>
                                    <div class="text-slate-500 mb-2 text-center">
                                        <div class="text-white">
                                            <div v-if="userLatestResponse.correct === true">
                                                You got it!
                                            </div>
                                            <div v-else>
                                                You're incorrect :(
                                            </div>
                                        </div>
                                    </div>
                                    <form class="rounded-sm border border-dashed border-white p-4 flex flex-col gap-6">
                                        <div class="flex justify-between">
                                            <p class="text-lg md:text-xl xl:text-2xl 2xl:text-3x xl:leading-12 2xl:leading-12 inline box-border box-decoration-clone p-2 tracking-wide bg-white text-teal-900 relative -left-8">
                                                {{ question?.title }}
                                            </p>
                                            <span v-if="correct" class="flex gap-2 items-center bg-white text-md text-labs-black p-2 h-8">
                                                <span>
                                                    Awarded :
                                                </span>
                                                <span class="text-md">
                                                    {{ awardedAmount }}
                                                </span>
                                                <span v-if="assetMetadata.logo"
                                                    class="relative inline-flex items-center rounded-full 2xl:w-5 w-4 2xl:h-5">
                                                        <img class="inline-flex"
                                                                alt="asset logo"
                                                                :src="'data:image/png;base64,'+`${assetMetadata.logo}`">
                                                    </span>
                                                <span v-else-if="assetMetadata.ticker"
                                                    class="relative inline-block rounded-full w-3 h-3">
                                                        {{ assetMetadata.ticker }}
                                                </span>
                                                <span v-else="assetName"
                                                        class="relative inline-block rounded-full w-3 h-3">
                                                            {{ assetName }}
                                                </span>
                                            </span>
                                        </div>
                                        <ul class="mt-4 space-y-2 relative h-full w-full ">
                                            <template v-for="answer in question.answers" :key="answer.id">
                                                <li class="mt-2 transition hover:ease-in delay-150">
                                                    <label class="w-full">
                                                        <input type="radio" class="peer sr-only" name="answer"
                                                               :id="answer.id" v-model="userSelectionId"/>

                                                        <div class="w-full rounded-md bg-white p-5" :class="{
                                                            'text-green-400' : userLatestResponse.correct === true && userLatestResponse.questionAnswerId === answer.id,
                                                            'text-orange-500': !userLatestResponse.correct === true && userLatestResponse.questionAnswerId === answer.id,
                                                            'text-slate-600': userLatestResponse.questionAnswerId !== answer.id
                                                        }">
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-sm font-semibold pr-8">
                                                                    {{ answer.content }}
                                                                </p>
                                                                <div class="w-4 h-4">
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

                                        <div class="font-bold flex justify-center lg:text-lg xl:text-xl" v-if="retryAt">
                                            <countdown :time="retryAt" v-slot="{ days, hours, minutes, seconds }">
                                                <span class="text-slate-200"> You can try again in: </span>
                                                {{ hours }} hours, {{ minutes }} minutes, {{ seconds }} seconds.
                                            </countdown>
                                        </div>

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
                                <div v-if="!userLatestResponse">
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
                                                        <input type="radio" class="peer sr-only" name="answer"
                                                               :id="answer.id" :value="answer.id"
                                                               v-model="userSelectionId"/>
                                                        <div
                                                            class="w-full rounded-md bg-white text-gray-500 p-5 transition-all hover:shadow peer-checked:text-teal-light-600">
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-sm font-semibold pr-8">{{
                                                                        answer.content
                                                                    }}</p>
                                                                <div class="w-4 h-4">
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
                                        <div class="mt-8 flex justify-end">
                                            <button type="button"
                                                    @click.prevent="submit"
                                                    :disabled="!!userLatestResponse"
                                                    :class="{ 'opacity-25 cursor-not-allowed': !!userLatestResponse }"
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
import {computed, inject, ref, Ref} from "vue";
import { storeToRefs } from 'pinia';
import User from "../../global/Shared/Models/user";
import {useForm, usePage} from '@inertiajs/vue3';
import {ArrowTopRightOnSquareIcon, CheckBadgeIcon, ClockIcon, NewspaperIcon} from '@heroicons/vue/24/outline';
import {CheckBadgeIcon as CheckBadgeIconSolid} from '@heroicons/vue/24/solid';
import Footer from "../../../../vendor/laravel/nova/resources/js/layouts/Footer.vue";
import {useAnswerResponseStore} from "../store/answer-response-store"
import Countdown from "../../global/Shared/Components/countdown";
import moment from "moment-timezone";
import LearningLessonData = App.DataTransferObjects.LearningLessonData;
import AnswerResponseData = App.DataTransferObjects.AnswerResponseData;
import RewardData = App.DataTransferObjects.RewardData;
import { useWalletStore } from "../../catalyst-explorer/stores/wallet-store";
import Wallet from '../../catalyst-explorer/models/wallet';

const $utils: any = inject('$utils');
const user = computed(() => usePage().props.user as User)

const props = withDefaults(
    defineProps<{
        locale: string,
        userResponses: AnswerResponseData[],
        lesson: LearningLessonData
        reward: RewardData[]
    }>(), {});

let answerResponseStore = useAnswerResponseStore();

let learningLesson = ref(props.lesson);
let reward = ref(props.reward);
let submitted: Ref<boolean> = ref(false);

let quiz, questions, question, answers, answer, correct, userSelectionId = ref(null);

let userLatestResponse = computed(() => {
    //filter out responses older than midnight previous day East Africa Time
    const responses = [...props.userResponses].filter((response) => {
        const currentDay = moment()
            .tz('Africa/Nairobi')
            .day();

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

let userReward = computed(() => {
    if (props.reward?.length > 0) {
        return props.reward[0];
    }
    return null;
})

let awardedAmount = userReward.value?.amount / userReward.value?.asset_details?.divisibility;
let assetName = userReward.value?.asset_details?.asset_name;
let assetMetadata = userReward.value?.asset_details.metadata;

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
        return moment(learningLesson.value.retryAt).tz('Africa/Nairobi')
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

answers = question.value?.answers;

let walletStore = useWalletStore();
let {walletData} = storeToRefs(walletStore);
let myWallet:Ref<Wallet> = computed(() => walletData.value);


function submit() {
    submitted.value = true;

    // submit the form
    const baseUrl = usePage().props.base_url;
    let form = useForm({
        learningLessonHash: learningLesson.value?.hash,
        question_answer_id: userSelectionId.value,
        user_id: user?.value?.id,
        quiz_id: quiz?.id,
        question_id: question?.value.id,
        wallet_stake_addr: myWallet?.value?.stakeAddress,
        wallet_addr: myWallet?.value?.address,

    });
    answerResponseStore.submitAnswer(baseUrl, form);
}
</script>


<style scoped>

</style>
