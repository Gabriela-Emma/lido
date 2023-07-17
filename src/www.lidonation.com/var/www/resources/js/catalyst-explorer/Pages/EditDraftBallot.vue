<template>
    <header-component titleName0="Draft Ballot" :titleName1="draftBallot?.title"
                      :subTitle="`Created ${$filters.timeAgo(draftBallot.created_at)}. Has ${draftBallot?.items_count} item${draftBallot?.items_count > 1 ? 's' : ''}.`"/>

    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section class="mb-4 overflow-visible bg-white border-t rounded-sm shadow-sm">
                <div class="relative overflow-visible">
                    <div class="flex items-center w-full h-10 lg:h-16">
                        <Search
                            :search="search"
                            @search="(term) => search = term" />
                    </div>
                    <div class="absolute left-0 z-20 w-full bg-white shadow-lg top-12" v-if="searchResults && searchResults?.length > 0">
                        <div class="relative z-20 overflow-auto divide-y divide-gray-200 max-h-96">
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
                <DraftBallotGroupCard v-for="group in draftGroups" :key="group.id" :group="group" :draftBallot="draftBallot" class="py-8 mb-8 bg-white border-t rounded-sm shadow-sm" />
            </section>
        </div>
    </main>
</template>

<script lang="ts" setup>
import {router, usePage} from '@inertiajs/vue3';
import DraftBallot from '../models/draft-ballot';
import DraftBallotGroupCard from '../modules/bookmarks/DraftBallotGroupCard.vue';
import Search from '../../earn/Shared/Components/Search.vue';
import {DraftBallotGroup} from '../models/draft-ballot';
import {Ref, ref, watch} from "vue";
import axios from 'axios';
import {useBookmarksStore} from "../stores/bookmarks-store";
import { storeToRefs } from 'pinia';
import moment from "moment-timezone";
import Proposal from '../models/proposal';
import { useUserStore } from '../../global/Shared/store/user-store';
import { cloneDeep } from 'lodash';
import route from 'ziggy-js';

const userStore = useUserStore();
const {user$} = storeToRefs(userStore);

const props = withDefaults(
    defineProps<{
        draftBallot: DraftBallot<Proposal>
    }>(), {});

let search = ref('');
let searchResults: Ref<Proposal[]> = ref([]);
let canDelete: Ref<boolean> =  ref();
let draftGroups: Ref<DraftBallotGroup<Proposal>[]> = ref([...cloneDeep(props.draftBallot.groups)]);
const onLocal:Ref<boolean> = ref(false);
const inLastTenMins:Ref<boolean>= ref(false);
const collectionHash = ref(props.draftBallot.hash);
const createdAt = ref(props.draftBallot.created_at);

// check if collection is on local
const bookmarksStore = useBookmarksStore();
const {collections$: storeCollections$} = storeToRefs(bookmarksStore);

watch([storeCollections$], (newValue, oldValue) => {
    onLocal.value =  storeCollections$.value?.some(collection => collection.hash === collectionHash.value);
});

watch (search, () => {
    if (search.value.length > 1) {
        searchProposals();
    } else {
        searchResults.value = [];
    }
});

// if from last 10mins
inLastTenMins.value = (moment().diff(moment(createdAt.value),'minutes')) < 10;
watch([onLocal,inLastTenMins], () => {
    canDelete.value = (onLocal.value && inLastTenMins.value) || user$.value?.id === props.draftBallot.user_id;
});

const removeCollection = () => {
    if(onLocal.value && inLastTenMins.value){
        axios.delete(`${usePage().props.base_url}/catalyst-explorer/bookmark-collection?hash=${collectionHash.value}`)
        .then((res) =>{
            bookmarksStore.deleteCollection(collectionHash.value)
            router.get(`${usePage().props.base_url}/catalyst-explorer/bookmarks`)
        })
        .catch((error) => {
            if (error.response && error.response.status === 403) {
                console.error(error);
            }
        });
    }
}

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
    try {
        const item = {
            model_id: proposal?.id,
            model_type: 'proposals',
            collection: {hash: props.draftBallot.hash}
        };

        await axios.post(route('catalystExplorer.bookmarkItem.create'), item);
        router.reload({onSuccess: (component) => {
            draftGroups.value = component.props.draftGroups['groups'];
        }});
    } catch (e) {
        console.log(e);
    }
}

</script>
