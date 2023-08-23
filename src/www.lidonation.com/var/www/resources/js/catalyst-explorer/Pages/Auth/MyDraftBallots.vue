<template>
    <header-component titleName0="Draft" titleName1="Ballots" subTitle="" />
    <div class="py-16 bg-primary-20">
        <main class="container">
            <div class="gap-2 py-8 bg-primary-20 lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="px-2 py-6 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav />
                </aside>
                <div class="flex flex-col p-6 space-y-6 bg-white sm:px-6 lg:col-span-9 xl:col-span-10 lg:px-0">
                    <!-- <section class="flex flex-col items-center justify-center gap-4 py-8" v-if="!user$?.id">
                        <p class="text-teal-800">
                            Login or Create an Account to Create Draft Ballots
                        </p>
                        <div class="">
                            <Link :href="$utils.localizeRoute('catalyst-explorer/auth/login')"
                                class="inline-flex items-center justify-center gap-1 px-3 py-2 font-medium border rounded-sm border-slate-800 xl:text-xl 3xl:text-2xl text-slate-800 hover:bg-slate-200 focus:outline-none focus:ring-0 focus:ring-offset-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            <span>{{ $t('Sign in') }}</span>
                            </Link>
                        </div>
                    </section> -->
                    <section class="p-6 space-y-6 " v-if="user$?.id">
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
