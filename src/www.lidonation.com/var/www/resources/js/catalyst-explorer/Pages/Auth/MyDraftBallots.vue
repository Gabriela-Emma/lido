<template>
    <header-component titleName0="Draft" titleName1="Ballots" subTitle="" />
    <div class="py-16 bg-primary-20">
        <main class="container">
            <div class="gap-2 py-8 bg-primary-20 lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="px-2 py-6 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav />
                </aside>
                <div class="flex flex-col p-6 space-y-6 bg-white sm:px-6 lg:col-span-9 xl:col-span-10 lg:px-0">
                    <section class="p-16 text-center align-middle" v-if="!draftBallots$ || draftBallots$?.length == 0">
                        <ProgressSpinner />
                    </section>
                    <section class="p-6" v-if="user$?.id && draftBallots$?.length > 0">
                        <h2 class="text-lg lg:text-xl xl:text-3xl">
                            My Draft Ballots
                        </h2>
                        <div
                            class="grid grid-cols-1 gap-6 lg:col-span-9 xl:col-span-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 3xl:grid-cols-5">
                            <DraftBallotCard v-for="ballot in draftBallots$" :draftBallot="ballot" />
                            <div
                                class="relative flex flex-col items-center justify-center object-cover w-full h-56 text-black border-2 border-teal-800 border-dashed item rounded-l-xl rounded-r-xs">
                                <Link class="text-teal-800" method="post" :href="route('catalystExplorer.createBallot')">
                                Create Draft Ballot
                                </Link>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { useBookmarksStore } from '../../stores/bookmarks-store';
import DraftBallotCard from '../../modules/bookmarks/DraftBallotCard.vue';
import ProgressSpinner from '../../Shared/Components/ProgressSpinner.vue';
import route from 'ziggy-js';
import { inject } from 'vue'
import { Link } from '@inertiajs/vue3';
import { useUserStore } from '../../../global/Shared/store/user-store';
import UserNav from "./UserNav.vue";


const bookmarksStore = useBookmarksStore();
const { draftBallots$ } = storeToRefs(bookmarksStore);
bookmarksStore.loadDraftBallots();
const userStore = useUserStore();
const { user$ } = storeToRefs(userStore);
const $utils: any = inject('$utils');
</script>
