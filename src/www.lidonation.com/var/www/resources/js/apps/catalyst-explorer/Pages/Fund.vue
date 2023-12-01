<template>
    <Head :title="fund?.data?.title" />

    <div class="bg-primary-20">
        <header class="text-white bg-teal-600">
            <header-component titleName0="Catalyst" titleName1="Fund"
                subTitle="Browse through the challenges of a specific Fund." color="teal-600" />
            <div class="container">
                <section>
                    <h1 class="flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate"></h1>
                </section>
                <section class="relative py-8 text-white bg-teal-600 text-md">
                    <div class="flex flex-row flex-wrap justify-start">
                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                                <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                    <span class="font-semibold">
                                        {{ fund.data.proposals_count ?? "-" }}
                                    </span>
                                </div>
                                <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                    <span>
                                        {{ $t("Total Proposals") }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                                <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                    <span class="font-semibold">
                                        {{ fundedProposalsCount }}
                                    </span>
                                </div>
                                <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                    <span>
                                        {{ $t("Funded Proposals") }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                                <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                    <span class="font-semibold">
                                        {{ completedProposalsCount }}
                                    </span>
                                </div>
                                <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                    <span>
                                        {{ $t("Completed Proposals") }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                                <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                    <span class="font-semibold">
                                        {{
                                            $filters.currency(
                                                fund.data.amount,
                                                fund?.data.currency
                                            )
                                        }}
                                    </span>
                                </div>
                                <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                    <span>
                                        {{ $t("Available") }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                                <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                    <span class="font-semibold">
                                        {{
                                            $filters.currency(
                                                parseInt(totalAmountRequested),
                                                fund?.data.currency
                                            )
                                        }}
                                    </span>
                                </div>
                                <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                    <span>
                                        {{ $t("Requested") }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]">
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start">
                                <div class="flex text-xl font-semibold flex-nowrap xl:text-3xl">
                                    <span class="font-semibold">
                                        {{
                                            $filters.currency(
                                                parseInt(totalAmountAwarded),
                                                fund?.data.currency
                                            )
                                        }}
                                    </span>
                                </div>
                                <div class="flex gap-1 text-base font-normal flex-nowrap leading-2">
                                    <span>
                                        {{ $t("Awarded") }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </header>
        <section class="relative py-10 overflow-visible bg-teal-10 lg:py-20">
            <div class="container">
                <h2 class='flex flex-col flex-wrap items-start gap-3 mb-6 text-3xl 2xl:text-5xl dark'>
                    <span class="text-gray-800 font-bold"> Browse By Challenges in {{ fund.data.label }} </span>
                    <span class="text-gray-800 text-lg font-normal">The community was asked to povide solutions to these challenges</span>
                </h2>
                <div
                    class="grid grid-cols-1 gap-3 mt-5 sm:grid-cols-2 sm:gap-4 lg:grid-cols-3 lg:gap-6 ">
                    <template v-for="(fund, index) in challenges">
                        <FundChallenge v-if="fund" :key="fund?.id" :fund="fund"></FundChallenge>
                    </template>
                </div>
            </div>
        </section>
    </div>
</template>
<script lang="ts" setup>
import Fund from '../models/fund';
import FundChallenge from '../modules/funds/FundChallenge.vue';
import {Head} from "@inertiajs/vue3";
const props = withDefaults(
    defineProps<{
        fund: {
            data: Fund;
        };
        challenges: Fund[];
        fundedProposalsCount: number;
        completedProposalsCount: number;
        totalAmountRequested: string;
        totalAmountAwarded: string;
        challengesCount: number;
    }>(),
    {}
);
</script>
