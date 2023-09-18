<template>
    <div class="p-3 bg-white lg:w-1/2 " v-if="proposals?.length > 0">
        <div>
            <h2 class="mb-0 xl:text-3xl">
                Top Funded Teams
            </h2>
            <p>
                Across {{ proposals?.[0]?.fund?.parent?.label }}
            </p>
        </div>
        <div class="relative m-2">
            <ul role="list" class="divide-y divide-gray-200 max-h-[28rem] overflow-y-auto">
                <li v-for="proposerData in proposalOwners" v-if="proposals">
                    <a :href="proposerData?.team ? proposerData?.team.link : $utils.localizeRoute(`project-catalyst/users/${proposerData?.owner?.id}`)"
                        class="block hover:bg-gray-50" target="_blank">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <img class="relative inline-block w-10 h-10 rounded-full ring-2 ring-white"
                                        :src="proposerData?.team ? (proposerData?.team.thumbnail_url ?? proposerData?.team.gravatar) : proposerData?.owner.profile_photo_url"
                                        :alt="proposerData.owner.name" />
                                </div>
                                <div class="flex-1 min-w-0 px-4 md:grid md:grid-cols-2 md:gap-4">
                                    <div class="flex items-center justify-start">
                                        <p class="text-xl font-medium text-gray-600 truncate ">
                                            {{ proposerData?.team ? proposerData?.team.name : proposerData.owner.name }}
                                        </p>
                                    </div>
                                    <div class="hidden md:block">
                                        <div>
                                            <p class="text-lg text-gray-900 md:text-xl 2xl:text-2xl">
                                                {{ $filters.currency(proposerData?.amount_requested, proposerData?.currency)
                                                }}
                                            </p>
                                            <p class="flex items-center mt-2 text-sm text-gray-500">
                                                {{ proposerData?.fund_Label }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <!-- Heroicon name: solid/chevron-right -->
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- loading animation -->
                <!-- <li v-else v-for="index in numberRange">
                    <div class="flex items-center px-4 py-4 sm:px-6 animate-pulse">
                        <div class="flex items-center flex-1 min-w-0">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-slate-400"></div>
                            </div>
                            <div class="flex-1 min-w-0 px-4 md:grid md:grid-cols-2 md:gap-4">
                                <div>
                                    <div class="w-2/3 h-2 rounded bg-slate-400"></div>
                                </div>
                                <div class="hidden md:block">
                                    <div>
                                        <div class="w-2/3  h-2 mb-1.5 rounded bg-slate-400"></div>
                                        <div class="w-2/3 h-2 rounded bg-slate-400 "></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </li> -->
            </ul>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Ref, computed, ref, watch } from 'vue';
import Proposal from '../../models/proposal';
import axios from 'axios';
import route from 'ziggy-js';
import { inject } from "vue";
import {VARIABLES} from "../../models/variables";

const $utils: any = inject('$utils');

const props = defineProps<{
    fund: number
}>()

const proposals: Ref<Proposal[]> = ref(null);
let numberRange = computed(() => Array.from({ length: 5 }, (_, index) => index + 1));

const proposalOwners = computed(() => {
    return proposals.value?.map((proposal) => {
        let user = proposal.users.find((user) => {
            return user.id == proposal.user_id
        })
        return { owner: { ...user }, amount_requested: proposal?.amount_requested, fund_Label: proposal?.fund?.label, currency: proposal?.fund?.currency, team: proposal.groups[0] }
    });
});

const getTopProposals = async () => {
    proposals.value = (
        await axios.get(
            route(
                'catalystExplorer.topFundedProposals'),
            { params: {[VARIABLES.FUNDS]: props.fund} }
        )
    ).data;
}

watch(() => props.fund, () => {
    getTopProposals();
})

getTopProposals();

</script>
