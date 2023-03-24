<template>
    <header-component titleName0="My" titleName1="Bookmarks" subTitle=""/>
    <main class="flex flex-col gap-2 bg-primary-20 py-8">
        <div class="container">
            <section>
                Bookmarks
            </section>
        </div>
    </main>
</template>

<script lang="ts" setup>
import BookmarkCollection from "../models/bookmark-collection";
import {ArrowTopRightOnSquareIcon} from '@heroicons/vue/20/solid';
import {useBookmarksStore} from "../stores/bookmarks-store";
import {storeToRefs} from "pinia";

const props = withDefaults(
    defineProps<{
        bookmarkCollections: BookmarkCollection[]
    }>(), {});

const bookmarksStore = useBookmarksStore();
const {collections$} = storeToRefs(bookmarksStore);
</script>
