<template>
    <header-component titleName0="Draft Ballot" :titleName1="draftBallot$?.title"
        :subTitle="`Created ${$filters.timeAgo(draftBallot$.created_at)}. Has ${draftBallot$?.items_count} item${draftBallot$?.items_count > 1 ? 's' : ''}.`" />

    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section class="sticky z-30 mb-4 overflow-visible bg-white border-t rounded-sm shadow-md top-9">
                <div class="relative overflow-visible">
                    <div class="flex items-center w-full h-10 lg:h-16">
                        <Search :search="search" @search="(term) => search = term" />
                    </div>
                    <div class="absolute left-0 z-30 w-full bg-white shadow-lg top-12"
                        v-if="searchResults && searchResults?.length > 0">
                        <div class="relative z-30 overflow-auto divide-y divide-gray-200 max-h-96">
                            <div v-for="proposal in searchResults" @click="bookmarkProposal(proposal)"
                                class="py-2 hover:bg-primary-20 hover:cursor-pointer hover:text-teal-800">
                                <h4 class="px-3">{{ proposal.title }}</h4>

                                <div class="flex gap-1 px-3 py-1">
                                    <div>
                                        <span>Budget: </span>
                                        <span>{{ proposal.amount_requested }}</span>
                                    </div>
                                    <div>
                                        <span>Challenge: </span>
                                        <span>{{ proposal.challenge_name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="">
                <div class="flex w-full items-center justify-end space-x-0.5 mb-3 gap-2">
                    <a :href="draftBallot?.link" target="_blank">
                        <button  class="bg-white rounded-sm px-3 py-2.5 text-gray-400 flex-wrap hover:text-yellow-500">
                            Share
                        </button>
                    </a>
                    <Link :href="route('catalystExplorer.draftBallotupdate.view', { draftBallot: draftBallot?.hash })"
                        class="bg-white rounded-sm px-3 py-2.5 text-gray-400 flex-wrap hover:text-yellow-500">
                        Edit
                    </Link>
                </div>
                <DraftBallotGroupCard v-for="group in draftBallot$.groups" :key="group.id" :group="group"
                    class="py-8 mb-8 bg-white border-t rounded-sm shadow-sm" />
            </section>
        </div>
    </main>
</template>

<script lang="ts" setup>
import DraftBallot from '../models/draft-ballot';
import DraftBallotGroupCard from '../modules/bookmarks/DraftBallotGroupCard.vue';
import Search from '../../earn/Shared/Components/Search.vue';
import { Ref, ref, watch } from "vue";
import axios from 'axios';
import { useBookmarksStore } from "../stores/bookmarks-store";
import { storeToRefs } from 'pinia';
import moment from "moment-timezone";
import Proposal from '../models/proposal';
import { useUserStore } from '../../global/Shared/store/user-store';
import route from 'ziggy-js';
import { Link } from '@inertiajs/vue3';

const userStore = useUserStore();
const { user$ } = storeToRefs(userStore);

const props = withDefaults(
    defineProps<{
        draftBallot: DraftBallot<Proposal>
    }>(), {});


// check if collection is on local
const bookmarksStore = useBookmarksStore();
const { collections$: storeCollections$, draftBallot$ } = storeToRefs(bookmarksStore);
bookmarksStore.loadDraftBallot(props.draftBallot);

let search = ref('');
let searchResults: Ref<Proposal[]> = ref([]);
let canDelete: Ref<boolean> = ref();
const onLocal: Ref<boolean> = ref(false);
const inLastTenMins: Ref<boolean> = ref(false);
const collectionHash = ref(draftBallot$.value?.hash);
const createdAt = ref(draftBallot$.value?.created_at);


watch([storeCollections$], (newValue, oldValue) => {
    onLocal.value = storeCollections$.value?.some(collection => collection.hash === collectionHash.value);
});

watch(search, () => {
    if (search.value.length > 1) {
        searchProposals();
    } else {
        searchResults.value = [];
    }
});

// if from last 10mins
inLastTenMins.value = (moment().diff(moment(createdAt.value), 'minutes')) < 10;
watch([onLocal, inLastTenMins], () => {
    canDelete.value = (onLocal.value && inLastTenMins.value) || user$.value?.id === draftBallot$.value?.user_id;
});

function searchProposals()
{
    const params = {
        search: search.value,
        fund_id: 113,
    }
    axios.get(
        route('catalystExplorerApi.proposals', params)
    ).then((res) => {
        searchResults.value = res.data.data;
    }).catch((error) => {
        console.error(error);
    });
}

async function bookmarkProposal(proposal: Proposal) {
    bookmarksStore.bookmarkProposal(proposal);
}

</script>
