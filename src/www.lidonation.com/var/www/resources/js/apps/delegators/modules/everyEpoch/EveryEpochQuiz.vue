<template>
    <div v-if="!answerResponse && !!quiz" class="">
        <h2 class="mb-3 text-xl md:text-2xl xl:text-3xl 2xl:text-4xl">
            {{ quiz?.title }} <span class="text-lg text-yellow-300 "> - {{$t('Take the quiz')}}!</span>
        </h2>
        <form class="flex flex-col gap-6 p-4 border border-white border-dashed rounded-sm">
            <div>
                <p
                    class="box-border relative inline p-2 text-lg tracking-wide text-teal-900 bg-white md:text-xl xl:text-2xl 2xl:text-3x xl:leading-12 2xl:leading-12 box-decoration-clone -left-8">
                    {{ quiz?.questions?.[0]?.title }}
                </p>
                <div class="flex gap-2 italic font-thin text-slate-100">
                    <p>{{$t('Hint')}}:</p>
                    <div v-html="quiz?.questions?.[0]?.content"></div>
                </div>
            </div>
            <ul class="w-full h-full max-w-lg mt-4 space-y-2 ">
                <template v-for="answer in quiz?.questions?.[0]?.answers" :key="answer.id">
                    <li class="mt-2">
                        <label class="w-full cursor-pointer">
                            <input type="radio" class="sr-only peer" name="answer" :value="answer?.id"
                                v-model="userSelectionId" />
                            <div class="w-full p-2 text-gray-500 transition-all border-slate-200 bg-slate-100/80 " :class="{
                                'hover:shadow peer-checked:text-labs-black peer-checked:bg-white peer-checked:ring-blue-light-900 peer-checked:ring-4 peer-checked:border-transparent': !epochAnswer.question_answer_id,
                                'bg-white': epochAnswer?.question_answer_id == answer?.id
                            }">
                                <div class="flex items-center justify-between">
                                    <p class="pr-8 text-sm font-semibold "
                                        :class="{
                                            'text-green-500': epochAnswer?.question_answer_id == answer?.id && epochAnswer.correct,
                                            'text-pink-500': epochAnswer?.question_answer_id == answer?.id && !epochAnswer.correct
                                        }">
                                        {{ answer?.content }}
                                    </p>

                                    <div v-if="!epochAnswer" class="w-4 h-4">
                                        <svg fill='currentColor' id="Layer_1_1_" style="enable-background:new 0 0 16 16;"
                                            version="1.1" viewBox="0 0 16 16" xml:space="preserve"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <circle cx="8" cy="8" r="8" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </li>
                </template>
            </ul>
        </form>
        <footer class="mt-4">
            <div class="flex gap-8 " :class="{
                'justify-between': epochAnswer?.question_answer_id,
                'justify-end': !epochAnswer?.question_answer_id
                }">
                <div v-if="epochAnswer" class="text-sm text-slate-200">
                    <div  class="font-bold">
                        {{epochAnswer.correct ? 'Quiz Completed' : 'Quiz attempted'}}
                        <UseTimeAgo v-slot="{ timeAgo }" :time="epochAnswer?.created_at">
                            {{ timeAgo }}
                        </UseTimeAgo>
                        !
                    </div>
                    <p class="text-xs">
                        {{$t('Come back next epoch for another chance to play')}}.
                    </p>

                </div>
                <button @click.prevent="submit" type="submit" :disabled="epochAnswer?.question_answer_id"
                    class="inline-flex items-center gap-2 px-3 py-2 text-lg font-medium leading-5 bg-white border rounded-sm shadow-sm border-slate-300 text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    <span>{{$t('Submit')}}</span>
                    <span v-if="epochAnswer" class="text-sm text-slate-400">
                        {{ !!epochAnswer.correct ? ' - completed' : ' - attempted' }}
                    </span>
                </button>
            </div>
        </footer>
    </div>
</template>

<script lang="ts" setup>
import { useEveryEpochStore } from '../../stores/every-epoch-store';
import { storeToRefs } from 'pinia';
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import User from '@/global/models/user';
import { UseTimeAgo } from '@vueuse/components';
import { useWalletStore } from '@/global/stores/wallet-store';


const epochStore = useEveryEpochStore();
const walletStore = useWalletStore();
const { answerResponse } = storeToRefs(epochStore);
const { walletData: wallet } = storeToRefs(walletStore);
const { quiz } = storeToRefs(epochStore);
const { epochAnswer } = storeToRefs(epochStore);

let userSelectionId = ref(null);
const user = computed(() => usePage().props.user as User)


const emit = defineEmits<{
    (e: 'questionForm', form): void,
}>();

let questionForm = ref(null);

let submit = async () => {

    questionForm.value = {
        answer: userSelectionId.value,
        user_id: user?.value?.id,
        quiz: quiz.value?.id,
        question: quiz.value?.questions?.[0]?.id,
        stake_address: wallet?.value?.stakeAddress,
        wallet_address: wallet?.value?.address,
    }
    emit('questionForm', questionForm.value)
}


</script>
