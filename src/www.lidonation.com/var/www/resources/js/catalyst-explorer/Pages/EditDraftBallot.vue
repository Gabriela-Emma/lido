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
                            <ul role="list" class="divide-y divide-gray-200">
                                <li v-for="item in group.items" :key="item.id">
                                    <div class="block hover:bg-gray-50">
                                        <div class="flex items-center px-4 py-4 sm:px-6">
                                            <div class="flex-1 min-w-0 sm:flex sm:items-center sm:justify-between">
                                                <div class="truncate">
                                                    <div class="flex flex-col text-lg">
                                                        <h3 class="text-xl font-medium truncate xl:text-2xl">
                                                            {{ item.title }}
                                                        </h3>
                                                    </div>
                                                    <div class="mt-1">
                                                        <div class="flex flex-row items-center gap-5 text-sm text-slate-500">
                                                            <div class="flex items-center gap-1">
                                                                <div>{{ $t("Budget") }}</div>
                                                                <div class="font-semibold text-slate-700">
                                                                    {{ $filters.currency(item?.amount_requested, item.currency) }}
                                                                </div>
                                                            </div>
                                                            <div class="flex items-center gap-1">
                                                                <TrashIcon @click.prevent="removeItem(item.id)" aria-hidden="true"
                                                                class="mr-0.5 h-5 w-5 hover:text-teal-600 hover:cursor-pointer" />
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex justify-end flex-shrink-0 gap-2 ml-5">

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
