<template>
    <header-component titleName0="My" titleName1="Bookmarks" subTitle=""/>
    <main class="flex flex-col gap-2 bg-primary-20 py-8">
        <div class="container">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="px-2 py-6 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav  crumbs="[]"/>
                </aside>

                <section class="space-y-6 sm:px-6 lg:col-span-9 xl:col-span-10">
                    <a v-for="collection in collections$" :href="collection?.link"
                       :style="{backgroundColor: collection?.color}"
                       class="h-56 w-72 lg:max-w-xs p-3 object-cover shadow-md hover:shadow-xl rounded-l-xl rounded-r-xs flex flex-col justify-center relative">
                        <div class="flex w-full justify-end absolute top-1 right-1">
                            <button type="button"
                                    class="inline-flex items-center gap-x-0.5 rounded-sm bg-slate-600 py-1 px-1.5 hover:text-white text-xs font-semibold text-white shadow-sm hover:bg-slate-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                                {{ $t("View") }}
                                <LinkIcon class="-mr-0.5 h-3 w-3" aria-hidden="true"/>
                            </button>
                        </div>
                        <div class="relative isolate h-16 mb-2">
                            <h2 class="text-xl w-4/5 font-bold tracking-tight text-slate-100 sm:text-2xl inline box-border box-decoration-cloe bg-white py-4 px-3 mb-3 rounded-l-lg text-slate-800 absolute -right-3">
                                {{ collection?.title }}
                            </h2>
                        </div>
                        <div class="w-full flex gap-2 justify-end" v-if="collection?.items_count > 0">
                            <div
                                class="inline-flex items-center items-center rounded-sm py-0.5 pl-2.5 pr-1 text-sm font-medium text-black border border-black">
                                {{ $t("Items") }}
                                <span
                                    class="ml-0.5 inline-flex flex-shrink-0 items-center justify-center rounded-full text-black font-bold focus:outline-none">
                                {{ collection?.items_count }}
                            </span>
                            </div>
                        </div>
                    </a>
                </section>
            </div>
        </div>
    </main>
</template>

<script lang="ts" setup>
import {LinkIcon} from '@heroicons/vue/20/solid';
import {storeToRefs} from "pinia";
import {useBookmarksStore} from "../../stores/bookmarks-store";
import BookmarkCollection from "../../models/bookmark-collection";
import UserNav from "./UserNav.vue";

const props = withDefaults(
    defineProps<{
        bookmarkCollections: BookmarkCollection[]
    }>(), {});


const bookmarksStore = useBookmarksStore();
const {collections$} = storeToRefs(bookmarksStore);
</script>
