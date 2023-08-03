<template>
    <header-component titleName0="Draft Ballot" :titleName1="draftBallot$?.title"
        :subTitle="`Created ${$filters.timeAgo(draftBallot$.created_at)}. Has ${draftBallot$?.items_count} item${draftBallot$?.items_count > 1 ? 's' : ''}.`" />

    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section class="sticky mb-4 overflow-visible bg-white border-t rounded-sm shadow-md top-9"
                :class="{ 'z-30': searchResults && searchResults?.length > 0 }">
                <div class="relative overflow-visible">
                    <div class="flex items-center w-full h-10 lg:h-16">
                        <Search :search="search" @search="(term) => search = term" />
                    </div>
                    <div class="absolute left-0 z-30 w-full bg-white shadow-lg top-12"
                        v-if="searchResults && searchResults?.length > 0">
                        <div class="relative z-30 overflow-auto divide-y divide-gray-200 max-h-96">
                            <div v-for="(proposal,index) in searchResults" @click="bookmarkProposal(proposal, index)"
                                class="py-2 hover:bg-primary-20 " 
                                :class="{'text-slate-500 cursor-not-allowed': proposal.disabled,
                                            'text-teal-800':proposal.selected, 
                                            'hover:cursor-pointer hover:text-teal-800': !proposal.disabled}">
                                <div class="flex w-full ">
                                    <div class="ml-3">
                                        <h4 class="px-3" :class="{ 'line-through': proposal.disabled}">{{ proposal.title }}</h4>
                                    </div>
                                    <div v-if="proposal.disabled || proposal.selected" class="flex flex-row justify-self-end ">
                                        <span class="text-slate-300 mr-1.5 italic text-lg"> {{ proposal.disabled?'Already added':'Proposal Added'}}</span>
                                        <CheckIcon class="-mr-0.5 h-3 w-3 " aria-hidden="true" />
                                    </div>
                                </div>

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
                        <button class="bg-white rounded-sm px-3 py-2.5 text-gray-400 flex-wrap hover:text-yellow-500">
                            Share
                        </button>
                    </a>
                    <Link :href="route('catalystExplorer.draftBallotUpdate.view', { draftBallot: draftBallot?.hash })"
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
import { Ref, computed, ref, watch } from "vue";
import axios from 'axios';
import { useBookmarksStore } from "../stores/bookmarks-store";
import { storeToRefs } from 'pinia';
import moment from "moment-timezone";
import Proposal from '../models/proposal';
import { useUserStore } from '../../global/Shared/store/user-store';
import route from 'ziggy-js';
import { Link } from '@inertiajs/vue3';
import { CheckIcon } from '@heroicons/vue/20/solid'

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
let proposalsInDraft = props.draftBallot.groups.reduce((acc, obj) => {
    let modelIds = obj.items.map(item => item.model.id);
    return acc.concat(modelIds);
}, []);

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


function searchProposals() {
    const params = {
        search: search.value,
        fund_id: 97,
    }
    axios.get(
        route('catalystExplorerApi.proposals', params)
    ).then((res) => {
        searchResults.value = res.data.data;
        searchResults.value.map(obj => {
            obj.disabled = proposalsInDraft.includes(obj.id);
        });
    }).catch((error) => {
        console.error(error);
    });
}

async function bookmarkProposal(proposal: Proposal, index) {
    if(!proposalsInDraft.includes(proposal.id) && !searchResults.value[index].selected){
        searchResults.value[index].selected = true,
        bookmarksStore.bookmarkProposal(proposal);
    }

}
</script>
