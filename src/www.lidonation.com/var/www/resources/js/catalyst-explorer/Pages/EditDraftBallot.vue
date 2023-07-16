<template>
    <header-component titleName0="Draft Ballot" :titleName1="draftBallot?.title"
                      :subTitle="`Created ${$filters.timeAgo(draftBallot.created_at)}. Has ${draftBallot?.items_count} item${draftBallot?.items_count > 1 ? 's' : ''}.`"/>

    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section class="">
                <div v-for="group in draftBallot.groups" class="py-8 mb-8 bg-white border-t rounded-sm shadow-md">
                    <div class="px-5">
                        <h2>{{ group.title }}</h2>
                    </div>

                    <div class="lg:grid lg:grid-cols-7">
                        <div class="col-span-4">
                            <ul role="list" class="overflow-hidden divide-y divide-gray-200">
                                <li class="ml-4" v-for="item in group.items" :key="item.id">
                                    <div class="flex justify-start gap-0 px-4 py-4 hover:bg-gray-50">
                                        <div class="flex flex-col flex-none w-16 gap-2 px-1 py-2 bg-slate-100" :class="{
                                            'bg-teal-light-100/50': item.vote?.vote === VOTEACTIONS.UPVOTE,
                                            'bg-red-100/80': item.vote?.vote === VOTEACTIONS.DOWNVOTE
                                        }">
                                            <div class="flex gap-2 flex-nowrap">
                                                <div class="flex-1 w-1/2" @click="vote(VOTEACTIONS.UPVOTE, item)">
                                                    <HandThumbUpIcon :class="[item.vote?.vote === VOTEACTIONS.UPVOTE ? 'text-teal-700' : 'text-gray-500']"
                                                    aria-hidden="true" class="w-6 h-6 text-gray-500 hover:text-yellow-700 hover:cursor-pointer" />
                                                </div>
                                                <div class="flex-1 w-1/2" @click="vote(VOTEACTIONS.DOWNVOTE, item)">
                                                    <HandThumbDownIcon aria-hidden="true"
                                                    :class="[item.vote?.vote === VOTEACTIONS.DOWNVOTE ? 'text-pink-800' : 'text-gray-500']"
                                                    class="w-6 h-6 hover:text-yellow-700 hover:cursor-pointer" />
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <TrashIcon @click.prevent="removeItem(item.id)" aria-hidden="true"
                                                class="w-5 h-5 text-gray-500 hover:text-teal-600 hover:cursor-pointer" />
                                            </div>
                                        </div>
                                        <div class="flex items-center flex-1 sm:px-6">
                                            <div class="flex-1 min-w-0 sm:flex sm:items-center sm:justify-between">
                                                <div class="truncate">
                                                    <div class="flex flex-col text-md">
                                                        <h4 class="text-lg font-medium truncate xl:text-xl">
                                                            {{ item.title }}
                                                        </h4>
                                                    </div>
                                                    <div class="mt-1">
                                                        <div class="flex flex-row items-center gap-5 text-sm text-slate-500">
                                                            <div class="flex items-center gap-1">
                                                                <div>{{ $t("Budget") }}</div>
                                                                <div class="font-semibold text-slate-700">
                                                                    {{ $filters.currency(item?.amount_requested, item.currency) }}
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
import BookmarkCollection from "../models/bookmark-collection";
import DraftBallot from '../models/draft-ballot';
import {ChevronRightIcon, ArrowUturnLeftIcon, ArrowDownTrayIcon, TrashIcon, BookOpenIcon, HandThumbUpIcon, HandThumbDownIcon} from '@heroicons/vue/20/solid';
import {computed, inject, Ref, ref, watch} from "vue";
import axios from 'axios';
import {useBookmarksStore} from "../stores/bookmarks-store";
import { storeToRefs } from 'pinia';
import moment from "moment-timezone";
import { BookmarkItemModel } from '../models/bookmark-item-model';
import Proposal from '../models/proposal';
import { useUserStore } from '../../global/Shared/store/user-store';
import route from 'ziggy-js';
import { VOTEACTIONS } from '../models/vote-actions';

const userStore = useUserStore();
const {user$} = storeToRefs(userStore);

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        draftBallot: DraftBallot
    }>(), {});

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
watch([onLocal,inLastTenMins],()=> {
    canDelete.value = (onLocal.value && inLastTenMins.value) || user$.value?.id === props.draftBallot.user_id;
})

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
            route('catalystExplorer.votes.store'),
            {vote, proposal: proposal.id},
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


    // .then((res) => {
    //     router.get(route('catalystExplorer.proposal', {proposal: id}))
    // })
    // .catch((error) => {
    //     if (error.response && error.response.status === 403) {
    //         console.error(error);
    //     }
    // });

}
</script>
