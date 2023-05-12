<template>
    <div>
        <div class="top-0 bottom-0 right-0 z-40 w-full bg-white shadow ">
            <header class="relative h-20 border-b border-gray-300">
                <div class="w-full h-full">
                    <Search :search="search"
                            @clearSearch="() => searchStore.clearSearch() "
                            @search="(term) => search = term"/>
                </div>
            </header>

            <nav class="h-full overflow-y-auto" aria-label="Directory" v-if="results">
                <div v-for="group in results" :key="group?.type">
                    <div class="relative">
                        <div
                            class="sticky top-0 z-10 px-6 py-1 text-sm font-medium text-gray-500 border-t border-b border-gray-200 bg-gray-50">
                            <h3 class="capitalize" v-text="group?.type"></h3>
                        </div>
                        <ul role="list" class="relative z-0 divide-y divide-gray-200">
                            <div v-for="item in group.items" :key="item?.id">
                                <li class="bg-white" >
                                    <div
                                        class="relative flex items-center px-6 py-5 space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-primary-500">
                                        <div class="flex-shrink-0">
                                            <img class="w-10 h-10 bg-teal-800 rounded-full" :src="getThumbnail(item)" alt="" />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <a :href="item?.link" class="focus:outline-none hover:text-teal-700">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <div class="text-sm font-semibold text-gray-900"
                                                    v-text="item?.title + (group?.type === 'reviews' ? ' Review' : '')"></div>
                                                <div class="flex items-center gap-1 text-xs rounded-sm post-meta">
                                                    <div class="text-gray-500 bg-gray-100 px-1 py-0.5"
                                                        v-text="item?.published_at"></div>
                                                    <div v-show="group?.type != 'reviews'"
                                                        class="rounded-sm bg-gray-100 px-1 py-0.5" v-html="item?.read_time">
                                                    </div>
                                                    <div class="inline-flex items-center rounded-sm gap-1 author bg-gray-100 px-1 py-0.5"
                                                        v-show="group?.type != 'reviews'">
                                                        <div class="inline-block bio-pic">
                                                            <img class="w-4 h-4 rounded-full" :src="item?.author_gravatar"
                                                                :title="item?.author_name"
                                                                :alt="item?.author_name + ' Bio Pic'" />
                                                        </div>
                                                        <div class="author-name" v-text="item?.author_name"></div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="absolute w-full p-8 top-20 h-50"  v-if="working">
                <div class="flex items-center justify-center h-full p-16 mx-auto">
                    <svg class="relative w-10 h-10 mx-auto border-t-2 border-b-2 rounded-full animate-spin border-primary-600 -top-4"
                        viewBox="0 0 24 24"></svg>
                </div>
            </div>

            <div class="p-6" v-if ="noResults">
                <div
                    class="relative flex flex-col items-center justify-center w-full p-12 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    <span class="block mt-2 text-sm font-medium text-gray-900">
                        Nothing came up for
                        <span class="font-semibold" v-text="search"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Search from '../../global/Shared/Components/SearchBar.vue';
import { ref, watch } from 'vue';
import { useGlobalSearchStore } from '../store/lido-search-store';
import { storeToRefs } from 'pinia';

let search = ref('');
const searchStore = useGlobalSearchStore();
const { results } = storeToRefs(searchStore);
const { noResults } = storeToRefs(searchStore);
const {working} = storeToRefs(searchStore);

const query = new URLSearchParams(window.location.search);
const term = query.get('q');
if (term) {
    search.value = term;
    searchStore.search(term);
}


watch(search, (newValue) => {
    searchStore.search(search.value);
});

let getThumbnail = (item) => {
    return item?.thumbnail || '/img/bleu.png';
}
</script>
