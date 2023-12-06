<template>
    <Head title="My Bookmarks" />

    <header-component titleName0="Catalyst" titleName1="My Bookmarks" subTitle=""/>

    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <div class="gap-2 py-8 bg-primary-20 lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="px-2 py-6 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav />
                </aside>

                <div class="flex flex-col p-6 space-y-6 bg-white sm:px-6 lg:col-span-9 xl:col-span-10">
                    <section class="space-y-6">
                        <h2 class="text-lg lg:text-xl xl:text-3xl">
                            My Bookmarks
                        </h2>
                        <div class="grid grid-cols-1 gap-6 lg:col-span-9 xl:col-span-10 sm:grid-cols-2 lg:grid-cols-3 3xl:grid-cols-4">
                            <div class="h-72" v-for="collection in collections$">
                                <BookmarkCollectionCard  :collection="collection" />
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
</template>

<script lang="ts" setup>
import {storeToRefs} from "pinia";
import UserNav from "./UserNav.vue";
import {useBookmarksStore} from "@apps/catalyst-explorer/stores/bookmarks-store";
import BookmarkCollectionCard from "../../modules/bookmarks/BookmarkCollectionCard.vue";
import {Head} from "@inertiajs/vue3";

withDefaults(
    defineProps<{}>(), {});

const bookmarksStore = useBookmarksStore();
const {collections$} = storeToRefs(bookmarksStore);
bookmarksStore.loadCollections();
</script>
