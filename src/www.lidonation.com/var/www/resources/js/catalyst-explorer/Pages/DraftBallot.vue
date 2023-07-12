<template>
    <header-component titleName0="Draft Ballot" :titleName1="draftBallot?.title"
                      :subTitle="`Created ${$filters.timeAgo(draftBallot.created_at)}. Has ${draftBallot?.items_count} item${draftBallot?.items_count > 1 ? 's' : ''}.`"/>

    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section>
                <masonry-wall :items="draftBallot.groups" :ssr-columns="1" :column-width="600" :gap="16" :max-columns="2">
                    <template #default="{ item, index }">
                    <div class="px-3 py-8 bg-white">
                        <div>
                            <small class="px-4 text-xs text-slate-500">Challenge</small>
                            <h1 class="px-4">{{ item.title }}</h1>
                            <span>{{ item.excerpt }}</span>
                        </div>
                        <div>
                            <ul role="list" class="divide-y divide-gray-200">
                                <li v-for="proposal in item.items" :key="proposal.id">
                                    <div class="block hover:bg-gray-50">
                                        <div class="flex items-center px-4 py-4 sm:px-5">
                                            <div class="flex-1 min-w-0 sm:flex sm:items-center sm:justify-between">
                                                <div class="truncate">
                                                    <div class="flex flex-col text-lg">
                                                        <h3 class="text-xl font-medium truncate xl:text-2xl">
                                                            {{ proposal.title }}
                                                        </h3>
                                                    </div>
                                                    <div class="mt-1">
                                                        <div class="flex flex-row items-center gap-5 text-sm text-slate-500">
                                                            <div class="flex items-center gap-1">
                                                                <div>{{ $t("Budget") }}</div>
                                                                <div class="font-semibold text-slate-700">
                                                                    {{ $filters.currency(proposal?.amount_requested) }}
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
                    </div>
                    </template>
                </masonry-wall>
            </section>
        </div>
    </main>
</template>

<script lang="ts" setup>
import {Link, router, usePage} from '@inertiajs/vue3';
import BookmarkCollection from "../models/bookmark-collection";
import DraftBallot from '../models/draft-ballot';
import {ChevronRightIcon, ArrowUturnLeftIcon, ArrowDownTrayIcon, TrashIcon, BookOpenIcon, ArchiveBoxArrowDownIcon} from '@heroicons/vue/20/solid';
import {computed, inject, Ref, ref, watch} from "vue";
import axios from 'axios';
import {useBookmarksStore} from "../stores/bookmarks-store";
import { storeToRefs } from 'pinia';
import moment from "moment-timezone";
import { BookmarkItemModel } from '../models/bookmark-item-model';
import Proposal from '../models/proposal';
import { useUserStore } from '../../global/Shared/store/user-store';
import route from 'ziggy-js';

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

let canDelete:Ref<boolean> =  ref();
watch([onLocal,inLastTenMins],()=> {
    canDelete.value = onLocal.value && inLastTenMins.value;
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

const removeItem = (id:number) => {
    if(onLocal.value && inLastTenMins.value){
        axios.delete(route('catalystExplorer.bookmarkItem.delete', {bookmarkItem: id}))
        .then((res) =>{
            bookmarksStore.deleteItem(id,collectionHash.value)
            router.get(route('catalystExplorer.bookmark', {bookmarkCollection: collectionHash.value}))
        })
        .catch((error) => {
            if (error.response && error.response.status === 403) {
                console.error(error);
            }
        });
    }
}

function createDraftBallot() {
    axios.post(route('catalystExplorer.bookmark.createBallot', {bookmarkCollection: collectionHash.value}))
        .then((res) => {
            console.log(res);
        })
        .catch((error) => {
            if (error.response && error.response.status === 403) {
                console.error(error);
            }
        });
}
</script>
