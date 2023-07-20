<template>
    <header-component titleName0="Catalyst" titleName1="Bookmarks" subTitle=""/>
    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section class="space-y-6">
                <h2 class="text-lg lg:text-xl xl:text-3xl">
                    My Bookmarks
                </h2>
                <div class="grid grid-cols-1 gap-6 lg:col-span-9 xl:col-span-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 3xl:grid-cols-5">
                    <BookmarkCollectionCard  v-for="collection in collections$" :collection="collection" />
                </div>
            </section>
        </div>
    </main>
</template>

<script lang="ts" setup>
import BookmarkCollection from "../models/bookmark-collection";
import {useBookmarksStore} from "../stores/bookmarks-store";
import {storeToRefs} from "pinia";
import BookmarkCollectionCard from "../modules/bookmarks/BookmarkCollectionCard.vue";
import Proposal from "../models/proposal";

withDefaults(
    defineProps<{
        bookmarkCollections?: BookmarkCollection<Proposal>[]
    }>(), {});

const bookmarksStore = useBookmarksStore();
const {collections$} = storeToRefs(bookmarksStore);
bookmarksStore.loadCollections();
</script>
