<template>
    <div class="p-3 bg-white lg:w-1/2" v-if="proposals?.length > 0">
        <div>
            <h2 class="mb-0 xl:text-3xl">Top Funded Proposals</h2>
            <p>Across {{ proposals?.[0]?.fund?.parent?.label }}</p>
        </div>
        <div class="relative m-2">
            <ul
                role="list"
                class="divide-y divide-gray-200 max-h-[28rem] overflow-y-auto"
            >
                <li v-for="proposal in proposals" v-if="proposals">
                    <a
                        :href="proposal.link"
                        class="block hover:bg-gray-50"
                        target="_blank"
                    >
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div
                                    class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4"
                                >
                                    <div class="flex flex-col">
                                        <p
                                            class="text-xl font-medium truncate text-gray-600"
                                        >
                                            {{ proposal.title }}
                                        </p>
                                        <ProposalAuthors :proposal="proposal"/>
                                    </div>
                                    <div class="hidden md:block">
                                        <div>
                                            <p
                                                class="text-lg md:text-xl 2xl:text-2xl text-gray-900"
                                            >
                                                {{
                                                    $filters.currency(
                                                        proposal.amount_requested,
                                                        proposal.currency
                                                    )
                                                }}
                                            </p>
                                            <p
                                                class="mt-2 flex items-center text-sm text-gray-500"
                                            >
                                                {{ proposal.fund?.label }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { Ref, ref, watch } from "vue";
import Proposal from "../../models/proposal";
import axios from "axios";
import route from "ziggy-js";
import { VARIABLES } from "../../models/variables";
import ProposalAuthors from "../proposals/partials/ProposalAuthors.vue";

const props = withDefaults(
    defineProps<{
        fund: number;
    }>(),
    {}
);

const proposals: Ref<Proposal[]> = ref(null);

const getTopProposals = async () => {
    proposals.value = (
        await axios.get(route("catalystExplorer.topFundedProposals"), {
            params: { [VARIABLES.FUNDS]: props.fund },
        })
    ).data;
};

watch(
    () => props.fund,
    () => {
        getTopProposals();
    }
);

getTopProposals();
</script>
