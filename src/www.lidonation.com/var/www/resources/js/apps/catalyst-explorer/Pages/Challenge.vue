<template>
    <div class="bg-primary-20">
        <header class="text-white bg-teal-600">
            <header-component :titleName0="fund.data.label" titleName1=" "
                subTitle="Browse through the proposals of a specific challenge." color="teal-600" />
            <div class="container">
                <section class="overflow-visible relative z-0 py-10 min-h-[28rem]">
                    <h1 class="flex flex-row flex-wrap items-end gap-2 mb-6 text-3xl font-bold 2xl:text-5xl decorate"></h1>

                    <div class="my-4 summary">
                        <div class="max-w-4xl font-semibold">
                            {{ fund.data.excerpt }}
                        </div>
                    </div>

                    <div class="relative mt-6" :class="{
                        'max-h-52 overflow-clip': !expanded,
                        'max-h-[40vh] overflow-auto': expanded,
                    }">
                        <div v-html="fundContent"></div>

                        <div v-if="!expanded" class="absolute w-full h-20 text-center bg-teal-600 -bottom-8 bg-opacity-90">
                            <div class="flex items-center justify-center w-full h-full">
                                <div class="py-3 text-xl font-bold text-white hover:cursor-pointer hover:text-yellow-400"
                                    @click="expandContent">
                                    <span>Expand</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
        <section class="container py-10 overflow-visible lg:py-20">
            <div class="flex w-full justify-end">
                <div class="text-xs w-[240px] lg:w-[330px] lg:text-base space-x-0.5 mb-3 gap-2">
                    <Multiselect placeholder="Sort" value-prop="value" label="label" v-model="selectedSortRef"
                        :options="sorts" :classes="{
                            container: 'multiselect border-0 p-0.5 flex-wrap',
                            containerActive: 'shadow-none shadow-transparent box-shadow-none',
                        }" />
                </div>
            </div>
            <div
                class="grid grid-cols-1 gap-3 mx-auto md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 max-w-7xl 2xl:max-w-full">
                <template v-for="proposal in proposals.data">
                    <ProposalCard v-if="proposal?.id" :key="proposal.id" :proposal="proposal" :showRankedCard=false>
                    </ProposalCard>
                </template>
            </div>
            <div class="flex items-start justify-between w-full gap-16 my-16 xl:gap-24">
                <div class="flex-1">
                    <Pagination :links="props.proposals.links" :per-page="props.perPage" :total="props.proposals?.total"
                        :from="props.proposals?.from" :to="props.proposals?.to"
                        @perPageUpdated="(payload) => (perPageRef = payload)"
                        @paginated="(payload) => (currPageRef = payload)" />
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>
import Multiselect from '@vueform/multiselect';
import { ref, watch } from "vue";
import { marked } from "marked";
import { computed } from "vue";
import Proposal from "@apps/catalyst-explorer/models/proposal";
import { router } from "@inertiajs/vue3";
import { VARIABLES } from "@apps/catalyst-explorer/models/variables";
import Fund from "@apps/catalyst-explorer/models/fund";
import ProposalCard from "@apps/catalyst-explorer/modules/proposals/ProposalCard.vue";
import Filters from "@apps/catalyst-explorer/models/filters";
import { usePeopleStore } from '@apps/catalyst-explorer/stores/people-store';
import { storeToRefs } from 'pinia';
import Sort from "@apps/catalyst-explorer/models/sort";
import Pagination from "@apps/catalyst-explorer/Components/Global/Pagination.vue";

const props = withDefaults(
    defineProps<{
        fund: {
            data: Fund;
        };
        sorts?: Sort[];
        sort?: string;
        fundedProposalsCount: number;
        completedProposalsCount: number;
        totalAmountRequested: string;
        totalAmountAwarded: string;
        currPage?: number;
        perPage?: number;
        filters?: Filters,
        proposals: {
            links: [];
            total: number;
            to: number;
            from: number;
            data: Proposal[];
        };
    }>(),
    {
        sorts: () => [
            {
                label: 'Votes Cast: Low to High',
                value: 'votes_cast:asc',
            },
            {
                label: 'Votes Cast: High to Low',
                value: 'votes_cast:desc',
            },
            {
                label: 'Budget: High to Low',
                value: 'amount_requested:desc',
            },
            {
                label: 'Budget: Low to High',
                value: 'amount_requested:asc',
            },
            {
                label: 'Community Ranking: High to Low',
                value: 'ranking_total:desc',
            },
            {
                label: 'Community Ranking: Low to High',
                value: 'ranking_total:asc',
            },
            {
                label: 'Payments Received: High to Low',
                value: 'amount_received:desc',
            },
            {
                label: 'Project Length: High to Low',
                value: 'project_length:desc',
            },
            {
                label: 'Project Length: Low to High',
                value: 'project_length:asc',
            },
            {
                label: 'Payments Received: Low to High',
                value: 'amount_received:asc',
            },
            {
                label: 'Yes Votes: High to Low',
                value: 'yes_votes_count:desc',
            },
            {
                label: 'Yes Votes: Low to High',
                value: 'yes_votes_count:asc',
            },
            {
                label: 'No Votes: Low to High',
                value: 'no_votes_count:asc',
            },
            {
                label: 'No Votes: High to Low',
                value: 'no_votes_count:desc',
            },
            {
                label: 'Rating: High to Low',
                value: 'ca_rating:desc',
            },
            {
                label: 'Rating: Low to High',
                value: 'ca_rating:asc',
            },
        ]
    }
);

let expanded = ref(false);
let selectedSortRef = ref(props.sort);

function expandContent() {
    expanded.value = !expanded.value;
}

const fundContent = computed(() => {
    return marked(props.fund.data.content);
});

let currPageRef = ref<number|null>(props.currPage||null);
let perPageRef = ref<number|null>(props.perPage||null);
let filtersRef = ref<Filters>(props.filters);

const peopleStore = usePeopleStore();
peopleStore.load(props?.filters?.people);
const { selectedPeople } = storeToRefs(peopleStore);

watch([currPageRef, perPageRef], () => {
    query();
});

watch([filtersRef], () => {
    currPageRef.value = null;
    query();
}, { deep: true });


watch(() => selectedSortRef, () => {
    currPageRef.value = null;
    query();
}, { deep: true });


watch([selectedPeople], () => {
    filtersRef.value.people = [...filtersRef.value.people, ...selectedPeople.value]
});

function query() {
    const data = {} as any;
    if (currPageRef.value) {
        data[VARIABLES.PAGE] = currPageRef.value;
    }

    if (perPageRef.value) {
        data[VARIABLES.PER_PAGE] = perPageRef.value;
    }

    if (!!selectedSortRef.value && selectedSortRef.value.length > 3) {
        data[VARIABLES.SORTS] = selectedSortRef.value;
    }

    if (filtersRef.value?.people) {
        data[VARIABLES.PEOPLE] = Array.from(filtersRef.value?.people);
    }

    router.get(`/catalyst-explorer/challenges/${props.fund.data.slug}`, data, {
        preserveScroll: true,
    });
}

</script>
