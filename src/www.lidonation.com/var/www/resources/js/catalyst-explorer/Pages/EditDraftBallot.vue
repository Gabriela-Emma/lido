<template>
    <header-component titleName0="Draft Ballot" :titleName1="draftBallot?.title"
                      :subTitle="`Created ${$filters.timeAgo(draftBallot.created_at)}. Has ${draftBallot?.items_count} item${draftBallot?.items_count > 1 ? 's' : ''}.`"/>

    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section class="">
                <DraftBallotGroupCard v-for="group in draftGroups" :key="group.id" :group="group" :draftBallot="draftBallot" class="py-8 mb-8 bg-white border-t rounded-sm shadow-md" />
            </section>
        </div>
    </main>
</template>

<script lang="ts" setup>
import {router, usePage} from '@inertiajs/vue3';
import DraftBallot from '../models/draft-ballot';
import DraftBallotGroupCard from '../modules/bookmarks/DraftBallotGroupCard.vue';
import {DraftBallotGroup} from '../models/draft-ballot';
import {Ref, ref, watch} from "vue";
import axios from 'axios';
import {useBookmarksStore} from "../stores/bookmarks-store";
import { storeToRefs } from 'pinia';
import moment from "moment-timezone";
import Proposal from '../models/proposal';
import { useUserStore } from '../../global/Shared/store/user-store';
import { cloneDeep } from 'lodash';

const userStore = useUserStore();
const {user$} = storeToRefs(userStore);

const props = withDefaults(
    defineProps<{
        draftBallot: DraftBallot<Proposal>
    }>(), {});

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

// if from last 10mins
inLastTenMins.value = (moment().diff(moment(createdAt.value),'minutes')) < 10;

let canDelete: Ref<boolean> =  ref();
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

</script>
