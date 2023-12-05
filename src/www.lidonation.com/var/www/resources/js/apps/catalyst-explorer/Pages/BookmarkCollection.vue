<template>
    <Head title="Project Catalyst Bookmark" />

    <header-component titleName0="Bookmark" :titleName1="bookmarkCollection?.title"
                      :subTitle="`Created ${$filters.timeAgo(bookmarkCollection.created_at)}. Has ${bookmarkCollection?.items_count} item${bookmarkCollection?.items_count > 1 ? 's' : ''}.`"/>

    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section
                class="relative flex flex-col justify-center items-start object-cover py-10 px-6 shadow-xs rounded-tl-2xl rounded-r-xs"
                :style="{backgroundColor: bookmarkCollection?.color}">

                <div class="relative inline-flex flex-col -left-6 z-0 px-4 py-2 justify-start bg-white rounded-r-lg">
                    <div class="text-xl sm:text-2xl font-bold tracking-tight text-slate-800 flex flex-col items-start">
                        <small
                            class="inline-flex items-center rounded-sm py-0.5 pr-1 text-xs font-medium">
                            {{ $t("Items") }}
                            <span
                                class="ml-0.5 inline-flex flex-shrink-0 items-center justify-center rounded-full font-bold focus:outline-none">
                            {{ bookmarkCollection?.items_count }}
                        </span>
                        </small>
                        <span class="inline-flex line-clamp-3">{{ bookmarkCollection?.title }}</span>
                    </div>

                    <div class="flex gap-2 mt-2">
                        <Link :href="route('catalyst-explorer.myBookmarks')"
                              class="inline-flex items-center gap-x-0.5 rounded-sm text-xs font-semibold text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                            <ArrowUturnLeftIcon class="mr-0.5 h-3 w-3" aria-hidden="true"/>
                            {{ $t("All Bookmarks") }}
                        </Link>

                        <button @click="download"
                                type="button"
                                class="inline-flex items-center gap-x-0.5 hover:text-teal-600 px-1.5 text-xs font-semibold text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                            <ArrowDownTrayIcon class="mr-0.5 h-3 w-3" aria-hidden="true"/>
                            {{ $t("Export") }}
                        </button>
                        <button @click="openIdeascaleLinks"
                                type="button"
                                class="inline-flex items-center gap-x-0.5 hover:text-teal-600 px-1.5 text-xs font-semibold text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                            <BookOpenIcon class="mr-0.5 h-3 w-3" aria-hidden="true"/>
                            {{ $t("Open All items") }}
                        </button>

                        <button @click="createDraftBallot"
                                type="button" v-if="user$?.id === bookmarkCollection?.user_id"
                                :disabled="!user$?.id"
                                :title="!user$?.id ? $t('You must be logged in to create a draft ballot') : 'Convert to draft ballot'"
                                :class="[user$?.id ? 'hover:text-teal-light-400' : 'cursor-not-allowed']"
                                class="inline-flex items-center gap-x-0.5 rounded-sm border py-1 px-1.5 text-xs bg-black font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                            <ArchiveBoxArrowDownIcon class="mr-0.5 h-3 w-3" aria-hidden="true"/>
                            {{ $t("Create Draft Ballot") }}
                        </button>
                        <button @click="remove = !remove"
                                type="button"
                                :disabled="canDelete===false"
                                :class="[(remove ? 'bg-stone-100' : '' ),(canDelete===false?'bg-slate-400  cursor-not-allowed':'')]"
                                class="inline-flex items-center gap-x-0.5 rounded-sm border py-1 px-1.5 text-xs font-semibold text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                            <div class="flex flex-row" v-show="!remove">
                                <TrashIcon class="mr-0.5 h-3 w-3" :class="{'hover:text-teal-600':canDelete===true}" aria-hidden="true"/>
                            </div>
                            <div class="flex flex-row gap-1 text-slate-800" v-show="remove">
                                <span class="mr-1">{{ $t("Are you sure? ") }} </span>
                                <span type="button" class="hover:bg-pink-500 bg-pink-400 py-0.5 px-1 rounded-sm" @click="removeCollection" >{{ $t("Yes") }}</span>
                                <span type="button" class="hover:text-teal-600 bg-slate-200 py-0.5 px-1 rounded-sm">{{ $t("No") }}</span>
                            </div>
                        </button>
                    </div>

                </div>
            </section>

            <section class="py-16 bg-white border-t shadow-md rounded-bl-2xl rounded-r-xs">
                <div class="">
                    <h2 class="px-4 text-xl lg:text-2xl xl:text-3xl sm:px-6">
                        Proposals
                    </h2>
                    <ul role="list" class="divide-y divide-gray-200">
                        <li v-for="item in bookmarkCollection.items" :key="item.id">
                            <div class="block hover:bg-gray-50">
                                <div class="flex items-center px-4 py-4 sm:px-6">
                                    <div class="flex-1 min-w-0 sm:flex sm:items-center sm:justify-between">
                                        <div class="truncate">
                                            <div class="flex flex-col text-lg">
                                                <h3 class="text-xl font-medium truncate xl:text-2xl">
                                                    <a :href="item?.model?.link" target="_blank" class="text-sm font-medium xl:font-semibold xl:text-lg text-slate-700">
                                                        {{ item.title || item.model?.title }}
                                                    </a>
                                                </h3>
                                                <div class="flex flex-row">
                                                    <p v-if="item?.content" class="mr-3 italic">
                                                        {{item?.content}}
                                                    </p>

                                                </div>

                                            </div>
                                            <div class="mt-1">
                                                <div class="flex flex-row items-center gap-5 text-sm text-slate-500">
                                                    <div class="flex items-center gap-1">
                                                        <div>{{ $t("Budget") }}</div>
                                                        <div class="font-semibold text-slate-700">
                                                            {{ $filters.currency(item?.model?.amount_requested, item?.model?.currency) }}
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <div>{{ $t("Fund") }}</div>
                                                        <div class="font-semibold text-slate-700">
                                                            {{ item?.model?.fund_name }}
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <div>{{ $t("Challenge") }}</div>
                                                        <div class="font-semibold text-slate-700">
                                                            {{ item?.model?.challenge_name }}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end flex-shrink-0 gap-2 ml-5">
                                        <TrashIcon @click.prevent="removeItem(item.id)" class="mr-0.5 h-5 w-5"
                                        :class="[canDelete===true?'hover:text-teal-600 hover:cursor-pointer':'cursor-not-allowed']" aria-hidden="true"/>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </main>
</template>

<script lang="ts" setup>
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import BookmarkCollection from "@apps/catalyst-explorer/models/bookmark-collection";
import {ArrowUturnLeftIcon, ArrowDownTrayIcon, TrashIcon, BookOpenIcon, ArchiveBoxArrowDownIcon} from '@heroicons/vue/20/solid';
import {computed, inject, Ref, ref, watch} from "vue";
import {useBookmarksStore} from "@apps/catalyst-explorer/stores/bookmarks-store";
import { storeToRefs } from 'pinia';
import moment from "moment-timezone";
import { BookmarkItemModel } from '../models/bookmark-item-model';
import Proposal from '@apps/catalyst-explorer/models/proposal';
import route from 'ziggy-js';
import {useUserStore} from "@/global/stores/user-store";
import axios from "@/global/utils/axios";

const userStore = useUserStore();
const {user$} = storeToRefs(userStore);

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        bookmarkCollection: BookmarkCollection<Proposal>
    }>(), {});

const download = () => {
    const data = {} as any;
    data['locale'] = usePage().props.locale;
    data['hash'] = props.bookmarkCollection.hash;
    const fileName = `${props.bookmarkCollection.title}-proposals.csv`;

    const res = axios.get(`/${usePage().props.locale}/catalyst-explorer/export/bookmarked-proposals`, {
        responseType: 'blob',
        params: data,
    });
    res.then(function(res) {
        const url = window.URL.createObjectURL(new Blob([res.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', fileName);
        document.body.appendChild(link);
        link.click();
    });
}

const onLocal:Ref<boolean> = ref(false);
const inLastTenMins:Ref<boolean>= ref(false);
const collectionHash = ref(props.bookmarkCollection.hash);
const createdAt = ref(props.bookmarkCollection.created_at);
let remove = ref(false)

// check if collection is on local
const bookmarksStore = useBookmarksStore();
const {collections$: storeCollections$} = storeToRefs(bookmarksStore);

watch([storeCollections$], (newValue, oldValue) => {
    onLocal.value =  storeCollections$.value?.some(collection => collection.hash === collectionHash.value);
});

// if from last 10mins
inLastTenMins.value = (moment().diff(moment(createdAt.value),'minutes')) < 10;

let canDelete: Ref<boolean> =  ref(false);
watch([onLocal,inLastTenMins],()=> {
    canDelete.value = (onLocal.value && inLastTenMins.value) || user$.value?.id === props.bookmarkCollection.user_id;
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
    if(canDelete.value){
        axios.delete(route('catalyst-explorer.bookmarkItem.delete', {bookmarkItem: id}))
        .then((res) =>{
            bookmarksStore.deleteItem(id,collectionHash.value)
            router.get(route('catalyst-explorer.bookmark', {bookmarkCollection: collectionHash.value}))
        })
        .catch((error) => {
            if (error.response && error.response.status === 403) {
                console.error(error);
            }
        });
    }
}

function isProposal(item: BookmarkItemModel): item is Proposal {
  return (item as Proposal).ideascale_link !== undefined;
}

function openIdeascaleLinks() {
  const items = props.bookmarkCollection.items;
  let index = 0;

  function openNextTab() {
    if (index < items.length) {
      const item = items[index];
      if (isProposal(item.model) && item.model?.ideascale_link && item.model?.ideascale_link.trim() !== "") {
        window.open(item.model?.ideascale_link, "_blank");
      }
      index++;
      setTimeout(openNextTab, 300);
    }
  }

  openNextTab();
}

function createDraftBallot() {
    router.post(
        route(
            'catalyst-explorer.bookmark.createBallot',
            {bookmarkCollection: collectionHash.value}
        )
    );
}
</script>
