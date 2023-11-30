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
import { computed, inject, ref, } from "vue";
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
    const filters = appFilters.currentModel.filters;

    const currentFundProposals = () => {
        let filteredProposals = userProposals.value;
        if (filters.funds.length) {
            filteredProposals = filteredProposals.filter((proposal) => filters.funds.includes(proposal.fund.parent.id));
        }
        if (filters.tags.length) {
            filteredProposals = filteredProposals.filter((proposal) => filters.tags.some((tag)=>proposal.tags.includes(tag)));
        }
        if (filters.funded) {
            filteredProposals = filteredProposals.filter((proposal) => proposal.funding_status = 'funded');
        }

        if (filters.budgets?.length) {
            filteredProposals = filteredProposals.filter((proposal) => proposal.amount_requested >= parseInt(filters.budgets[0]) && proposal.amount_requested <= parseInt(filters.budgets[1]));
        }

        return filteredProposals;
    }
    
    return {
        co_proposals: currentFundProposals().filter((proposal) => proposal.is_co_proposer).length,
        primary_proposal: currentFundProposals().filter((proposal) => proposal.is_primary_proposer).length
    }
})
</script>
