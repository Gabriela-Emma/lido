<template>
    <div class="p-8 bg-white round-sm">
        <div class="space-y-4">
            <a class="block" target="_blank" :href="$utils.localizeRoute(`project-catalyst/users/${user.id}`)">
                <img class="w-20 h-20 mx-auto rounded-full lg:w-24 lg:h-24"
                    :src="user.media?.length > 0 ? user?.media[0]?.original_url : user.profile_photo_url"
                    :alt="user.name" />
            </a>

            <div class="space-y-2">
                <div class="flex-col justify-between text-xs font-medium lg:text-sm flx">
                    <h3>
                        <a class="block" target="_blank" :href="$utils.localizeRoute(`project-catalyst/users/${user.id}`)">
                            {{ user.name }}
                        </a>
                    </h3>
                    <div class="flex flex-col mt-2 divide-y">
                        <div class="py-2">
                            <span>
                                {{ proposalCount.primary_proposal }} {{ proposalCount.primary_proposal > 1 ?
                                    $t('OwnProposals') :
                                    $t('OwnProposal') }}
                            </span>
                        </div>
                        <div class="py-2">
                            <span>
                                {{ proposalCount.co_proposals }} {{ proposalCount.co_proposals ? $t('Co Proposals') :
                                    $t('CoProposal') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { computed, inject, ref } from "vue";
import User from "@/global/models/user";
import { useFiltersStore } from "@/global/stores/filters-stores";

const $utils: any = inject('$utils');
const props = withDefaults(
    defineProps<{
        user: User
    }>(),
    {
        user: () => {
            return {} as User;
        }
    },
);

let appFilters = useFiltersStore();
let userProposals = ref(props.user.proposals);

const proposalCount = computed(() => {
    const fundFilter = appFilters.currentModel.filters?.funds;
    const tagsFilter = appFilters.currentModel.filters?.tags;
    const fundingStatusFilter = appFilters.currentModel.filters?.funded
    const budgetFilter = appFilters.currentModel.filters?.budgets

    const currentFundProposals = () => {
        let filteredProposals = userProposals.value;
        if (fundFilter.length) {
            filteredProposals = filteredProposals.filter((proposal) => fundFilter.includes(proposal.fund.parent.id));
        }
        if (tagsFilter.length) {
            filteredProposals = filteredProposals.filter((proposal) => tagsFilter.includes(proposal.fund.parent.id));
        }
        if (fundingStatusFilter) {
            filteredProposals = filteredProposals.filter((proposal) => proposal.funding_status = 'funded');
        }

        if (budgetFilter?.length) {
            filteredProposals = filteredProposals.filter((proposal) => proposal.amount_requested >= parseInt(budgetFilter[0]) && proposal.amount_requested <= parseInt(budgetFilter[1]));
        }

        return filteredProposals;
    }
    
    return {
        co_proposals: currentFundProposals().filter((proposal) => proposal.is_co_proposer).length,
        primary_proposal: currentFundProposals().filter((proposal) => proposal.is_primary_proposer).length
    }
})
</script>
