<template>
    <div>
        <header-component
            titleName0="catalyst"
            titleName1="Challenge"
            subTitle="Browse through the proposals of a specific challenge."
        />
        <header class="text-white bg-teal-600">
            <div class="container">
                <section
                    class="overflow-visible relative z-0 py-10 min-h-[28rem]"
                >
                    <h1
                        class="flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate"
                    >
                        <img
                            class="w-10 h-10 rounded-sm lg:w-16 lg:h-16"
                            v-bind:src="fund.thumbnail_url ?? fund.gravatar"
                            alt="{{fund.label}} gravatar"
                        />

                        <span class="font-semibold">
                            {{ fund.label }}
                        </span>
                    </h1>

                    <div class="my-4 summary">
                        <div class="max-w-4xl font-semibold">
                            {{ fund.excerpt }}
                        </div>
                    </div>

                    <div
                        class="relative mt-6"
                        :class="{
                            'max-h-52 overflow-clip': !expanded,
                            'max-h-[40vh] overflow-auto': expanded,
                        }"
                    >
                        <div v-html="fundContent"></div>

                        <div
                            v-if="!expanded"
                            class="absolute w-full h-20 text-center bg-teal-600 -bottom-8 bg-opacity-90"
                        >
                            <div
                                class="flex items-center justify-center w-full h-full"
                            >
                                <div
                                    class="py-3 text-xl font-bold text-white hover:cursor-pointer hover:text-yellow-400"
                                    @click="expandContent"
                                >
                                    <span>Expand</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="relative py-8 text-white bg-teal-600 text-md">
                    <div class="flex flex-row flex-wrap justify-start">
                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]"
                        >
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start"
                            >
                                <div
                                    class="flex text-xl font-semibold flex-nowrap xl:text-3xl"
                                >
                                    <span class="font-semibold">
                                        {{ fund.proposals_count ?? "-" }}
                                    </span>
                                </div>
                                <div
                                    class="flex gap-1 text-base font-normal flex-nowrap leading-2"
                                >
                                    <span>
                                        {{ $t("Total Proposals") }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]"
                        >
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start"
                            >
                                <div
                                    class="flex text-xl font-semibold flex-nowrap xl:text-3xl"
                                >
                                    <span class="font-semibold">
                                        {{ fundedProposalsCount }}
                                    </span>
                                </div>
                                <div
                                    class="flex gap-1 text-base font-normal flex-nowrap leading-2"
                                >
                                    <span>
                                        {{ $t("Funded Proposals") }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]"
                        >
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start"
                            >
                                <div
                                    class="flex text-xl font-semibold flex-nowrap xl:text-3xl"
                                >
                                    <span class="font-semibold">
                                        {{ completedProposalsCount }}
                                    </span>
                                </div>
                                <div
                                    class="flex gap-1 text-base font-normal flex-nowrap leading-2"
                                >
                                    <span>
                                        {{ $t("Completed Proposals") }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]"
                        >
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start"
                            >
                                <div
                                    class="flex text-xl font-semibold flex-nowrap xl:text-3xl"
                                >
                                    <span class="font-semibold">
                                        {{
                                            $filters.currency(
                                                fund.amount,
                                                fund?.currency
                                            )
                                        }}
                                    </span>
                                </div>
                                <div
                                    class="flex gap-1 text-base font-normal flex-nowrap leading-2"
                                >
                                    <span>
                                        {{ $t("Available") }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]"
                        >
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start"
                            >
                                <div
                                    class="flex text-xl font-semibold flex-nowrap xl:text-3xl"
                                >
                                    <span class="font-semibold">
                                        {{
                                            $filters.currency(
                                                parseInt(totalAmountRequested),
                                                fund?.currency
                                            )
                                        }}
                                    </span>
                                </div>
                                <div
                                    class="flex gap-1 text-base font-normal flex-nowrap leading-2"
                                >
                                    <span>
                                        {{ $t("Requested") }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="border border-gray-300 -mt-px -ml-px inline-flex flex-col gap-6 justify-between border-opacity-50 p-4 pr-8pl-8first-of-type:pl-0 min-w-20 xl:min-w-[initial]"
                        >
                            <div
                                class="flex flex-row flex-no-wrap items-center justify-between gap-5 text-gray-200 md:justify-start"
                            >
                                <div
                                    class="flex text-xl font-semibold flex-nowrap xl:text-3xl"
                                >
                                    <span class="font-semibold">
                                        {{
                                            $filters.currency(
                                                parseInt(totalAmountAwarded),
                                                fund?.currency
                                            )
                                        }}
                                    </span>
                                </div>
                                <div
                                    class="flex gap-1 text-base font-normal flex-nowrap leading-2"
                                >
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
        <section
            class="container py-10 overflow-visible bg-white bg-left-bottom bg-repeat-y bg-contain bg-opacity-90 bg-blend-color-burn lg:py-20 bg-pool-bw-light"
        >
            <div class="grid grid-cols-1 gap-3 mx-auto md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 max-w-7xl 2xl:max-w-full">
                <template v-for="proposal in proposals.data">
                    <ProposalCard
                        v-if="proposal?.id"
                        :key="proposal.id"
                        :proposal="proposal"
                    ></ProposalCard>
                </template>
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { marked } from "marked";
import { computed } from "vue";
import Proposal from "../models/proposal";
import ProposalCard from "../modules/proposals/ProposalCard.vue";

const props = withDefaults(
    defineProps<{
        fund: any;
        fundedProposalsCount: number;
        completedProposalsCount: number;
        totalAmountRequested: string;
        totalAmountAwarded: string;
        proposals: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Proposal[]
        }
    }>(),
    {}
);

let expanded = ref(false);

function expandContent() {
    expanded.value = !expanded.value;
}

const fundContent = computed(() => {
    return marked(props.fund.content);
});
</script>
