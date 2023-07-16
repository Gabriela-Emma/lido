<template>
    <header-component titleName0="Draft Ballot" :titleName1="draftBallot?.title"
                      :subTitle="`Created ${$filters.timeAgo(draftBallot.created_at)}. Has ${draftBallot?.items_count} item${draftBallot?.items_count > 1 ? 's' : ''}.`"/>

    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section class="">
                <div v-for="group in draftGroups" class="py-8 mb-8 bg-white border-t rounded-sm shadow-md">
                    <div class="px-5">
                        <h2 class="mb-2">{{ group.title }}</h2>
                        <div class="relative border rounded-md border-slate-200 bg-slate-50">
                            <small class="absolute bg-slate-50 rounded-sm -top-2 border border-slate-200 left-3 px-1 py-0.5 text-sm z-10">Rationale for this group</small>
                            <textarea rows="4" name="rationale" id="rationale" v-model="group.rationale"
                            class="block w-full py-1.5 text-gray-900 pt-4 custom-input border-0 border-transparent round-sm bg-slate-50 ring-0 placeholder:text-gray-400 focus:ring-2 transition-all focus:ring-inset focus:ring-teal-600 sm:text-sm sm:leading-6 mt-0" />
                        </div>
                    </div>

                    <div class="lg:grid lg:grid-cols-7">
                        <div class="col-span-4">
                            <ul role="list" class="overflow-hidden divide-y divide-gray-200">
                                <li class="ml-4" v-for="item in group.items" :key="item?.model?.id">
                                    <div class="flex justify-start gap-0 px-4 py-4 hover:bg-gray-50">
                                        <div class="flex flex-col flex-none w-16 gap-2 px-1 py-2 rounded-sm" :class="{
                                            'bg-teal-light-100/50': item.model.vote?.vote === VOTEACTIONS.UPVOTE,
                                            'bg-red-100/80': item.model.vote?.vote === VOTEACTIONS.DOWNVOTE,
                                            'bg-slate-100': !item.model.vote?.vote
                                        }">
                                            <div class="flex gap-1 flex-nowrap">
                                                <div class="flex-1 w-1/2" @click="vote(VOTEACTIONS.UPVOTE, item.model)">
                                                    <HandThumbUpIcon :class="[item.model.vote?.vote === VOTEACTIONS.UPVOTE ? 'text-teal-700' : 'text-gray-500']"
                                                    aria-hidden="true" class="w-6 h-6 text-gray-500 hover:text-yellow-700 hover:cursor-pointer" />
                                                </div>
                                                <div class="flex-1 w-1/2" @click="vote(VOTEACTIONS.DOWNVOTE, item.model)">
                                                    <HandThumbDownIcon aria-hidden="true"
                                                    :class="[item?.model?.vote?.vote === VOTEACTIONS.DOWNVOTE ? 'text-pink-800' : 'text-gray-500']"
                                                    class="w-6 h-6 hover:text-yellow-700 hover:cursor-pointer" />
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <TrashIcon @click.prevent="removeItem(item?.model?.id)" aria-hidden="true"
                                                class="w-5 h-5 text-gray-500 hover:text-teal-600 hover:cursor-pointer" />
                                            </div>
                                        </div>
                                        <div class="flex items-center flex-1 sm:px-6">
                                            <div class="flex-1 min-w-0 sm:flex sm:items-center sm:justify-between">
                                                <div class="truncate">
                                                    <div class="flex flex-col text-md">
                                                        <h4 class="text-lg font-medium truncate xl:text-xl">
                                                            {{ item?.model?.title }}
                                                        </h4>
                                                    </div>
                                                    <div class="mt-1">
                                                        <div class="flex flex-row items-center gap-5 text-sm text-slate-500">
                                                            <div class="flex items-center gap-1">
                                                                <div>{{ $t("Budget") }}</div>
                                                                <div class="font-semibold text-slate-700">
                                                                    {{ $filters.currency(item?.model?.amount_requested, item?.model?.currency) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-span-3 hideen lg:block"></div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>

<script lang="ts" setup>
import {Link, router, usePage} from '@inertiajs/vue3';
import DraftBallot from '../models/draft-ballot';
import {DraftBallotGroup} from '../models/draft-ballot';
import {ChevronRightIcon, ArrowUturnLeftIcon, ArrowDownTrayIcon, TrashIcon, BookOpenIcon, HandThumbUpIcon, HandThumbDownIcon} from '@heroicons/vue/20/solid';
import {computed, inject, Ref, ref, watch} from "vue";
import axios from 'axios';
import {useBookmarksStore} from "../stores/bookmarks-store";
import { storeToRefs } from 'pinia';
import moment from "moment-timezone";
import Proposal from '../models/proposal';
import { useUserStore } from '../../global/Shared/store/user-store';
import route from 'ziggy-js';
import { VOTEACTIONS } from '../models/vote-actions';

const userStore = useUserStore();
const {user$} = storeToRefs(userStore);

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        draftBallot: DraftBallot<Proposal>
    }>(), {});

let draftGroups: Ref<DraftBallotGroup<Proposal>[]> = ref(props.draftBallot.groups);
const onLocal:Ref<boolean> = ref(false);
const inLastTenMins:Ref<boolean>= ref(false);
const collectionHash = ref(props.draftBallot.hash);
const createdAt = ref(props.draftBallot.created_at);
let remove = ref(false)

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

watch([draftGroups], (newValue, oldValue) => {
    console.log({newValue})
}, { deep: true })

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

function removeItem (id: number) {
    if (canDelete) {
        axios.delete(route('catalystExplorer.bookmarkItem.delete', {bookmarkItem: id}))
        .then((res) => {
            bookmarksStore.deleteItem( id, collectionHash.value)
            router.get(route('catalystExplorer.bookmark', {bookmarkCollection: collectionHash.value}))
        })
        .catch((error) => {
            if (error.response && error.response.status === 403) {
                console.error(error);
            }
        });
    }
}

function vote(vote: VOTEACTIONS, proposal: Proposal) {
    if (proposal.vote){
        router.patch(
            route('catalystExplorer.votes.update', {vote: proposal.vote.id}),
            {vote},
            {
                preserveScroll: true,
                preserveState: true
            }
        );
    } else {
        router.post(
            route('catalystExplorer.votes.store'),
            {vote, proposal: proposal.id},
            {
                preserveScroll: true,
                preserveState: true
            }
        );
    }
}

function saveRationale() {

}

</script>
