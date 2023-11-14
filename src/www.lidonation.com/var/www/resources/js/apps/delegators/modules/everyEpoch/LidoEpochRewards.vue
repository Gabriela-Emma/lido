<template>
    <div>
        <p class="text-xl lg:text-2xl xl:text-4xl 2xl:text-6xl">
            <span v-show="answerResponse?.correct">You're Correct!</span>
            <span v-show="!answerResponse?.correct">Sorry, that's not quite it.</span>
        </p>
    </div>
    <div class="text-center">
        <svg v-show="answerResponse?.correct " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-16 h-16 mx-auto text-green-500">
            <path fill-rule="evenodd"
                d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                clip-rule="evenodd" />
        </svg>
        <svg v-show="!answerResponse?.correct" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
            class="w-16 h-16 mx-auto text-pink-600">
            <path fill-rule="evenodd"
                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.605.189-.866zm-4.34 7.964a.75.75 0 01-1.061-1.06 5.236 5.236 0 013.73-1.538 5.236 5.236 0 013.695 1.538.75.75 0 11-1.061 1.06 3.736 3.736 0 00-2.639-1.098 3.736 3.736 0 00-2.664 1.098z"
                clip-rule="evenodd" />
        </svg>
        <div class="my-4" v-show="!answerResponse?.correct">
            {{ quiz?.questions?.[0]?.content }}
        </div>
    </div>
    <div class="w-full border-b border-teal-900">
        <div v-show="answerResponse?.correct">
            <h2 v-show=" !claimed" class="text-center">Claim your reward</h2>
            <div class="flex justify-center w-full gap-4 my-4">
                <slot></slot>
            </div>
        </div>

        <div class="mt-2">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <p class="italic font-medium text-slate-100">
                        LIDO delegators gets a bonus!
                    </p>
                </div>
            </div>
            <div class="mt-4 -mx-4 overflow-hidden ring-1 ring-teal-800 sm:-mx-6 md:mx-0 md:rounded-sm">
                <table class="min-w-full divide-y divide-teal-800">
                    <thead class="">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-100 sm:pl-6">
                                Stake
                            </th>
                            <th scope="col"
                                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-slate-100 sm:table-cell">
                                Bonus
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-teal-800">
                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium whitespace-nowrap text-slate-100 sm:pl-6">
                                100 staked
                            </td>
                            <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-slate-50 sm:table-cell">
                                15%
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium whitespace-nowrap text-slate-100 sm:pl-6">
                                1,000 staked
                            </td>
                            <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-slate-50 sm:table-cell">
                                30%
                            </td>
                        </tr>

                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium whitespace-nowrap text-slate-100 sm:pl-6">
                                8,000 staked
                            </td>
                            <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-slate-50 sm:table-cell">
                                55%
                            </td>
                        </tr>

                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium whitespace-nowrap text-slate-100 sm:pl-6">
                                20,000 staked
                            </td>
                            <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-slate-50 sm:table-cell">
                                85%
                            </td>
                        </tr>

                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium whitespace-nowrap text-slate-100 sm:pl-6">
                                30,000 staked
                            </td>
                            <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-slate-50 sm:table-cell">
                                100%
                            </td>
                        </tr>

                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium whitespace-nowrap text-slate-100 sm:pl-6">
                                50,000 staked
                            </td>
                            <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-slate-50 sm:table-cell">
                                125%
                            </td>
                        </tr>

                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium whitespace-nowrap text-slate-100 sm:pl-6">
                                75,000 staked
                            </td>
                            <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-slate-50 sm:table-cell">
                                150%
                            </td>
                        </tr>

                        <tr>
                            <td class="py-4 pl-4 pr-3 text-sm font-medium whitespace-nowrap text-slate-100 sm:pl-6">
                                100,000 staked
                            </td>
                            <td class="hidden px-3 py-4 text-sm whitespace-nowrap text-slate-50 sm:table-cell">
                                200%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useEveryEpochStore } from '../../stores/every-epoch-store';
import { storeToRefs } from 'pinia';

const epochStore = useEveryEpochStore();
const { answerResponse } = storeToRefs(epochStore);
const {quiz} = storeToRefs(epochStore);
const {claimed} = storeToRefs(epochStore);
</script>