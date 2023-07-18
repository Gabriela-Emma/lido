<template>
    <header-component titleName0="catalyst" titleName1="Voter Tool" subTitle=""/>
    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section class="space-y-6">
                <h2 class="text-lg lg:text-xl xl:text-3xl">
                    My Draft Ballots
                </h2>
                <div class="grid grid-cols-1 gap-6 lg:col-span-9 xl:col-span-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 3xl:grid-cols-5">
                    <DraftBallotCard  v-for="ballot in draftBallots$" :draftBallot="ballot" />
                    <div class="relative flex flex-col items-center justify-center object-cover w-full h-56 text-black border-2 border-teal-800 border-dashed item rounded-l-xl rounded-r-xs">
                        <Link class="text-teal-800" method="post" :href="route('catalystExplorer.createBallot')">
                            Create Draft Ballot
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    </main>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { useBookmarksStore } from '../stores/bookmarks-store';
import DraftBallotCard from '../modules/bookmarks/DraftBallotCard.vue';
import route  from 'ziggy-js';
import { Link } from '@inertiajs/vue3';

const bookmarksStore = useBookmarksStore();
const {draftBallots$} = storeToRefs(bookmarksStore);
bookmarksStore.loadDraftBallots();
</script>
