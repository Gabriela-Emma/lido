<template>
    <header class="py-10 container">
        <h1 class="text-2xl lg:text-3xl 2xl:text-5xl font-semibold text-slate-700">
            Catalyst <span class="text-teal-600">Proposals</span>
        </h1>
        <p class="text-slate-600">
            Search proposals and challenges by title, content, or author and co-authors.
        </p>
    </header>

    <div class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-16">
                    <div class="flex w-full h-full rounded-l-sm">
                        <div class="relative flex-grow w-full h-full focus-within:z-10">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor"
                                     fill="none">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <input name="searchProposals" id="searchProposals" placeholder="Search"
                                   class="block w-full h-full pl-10 transition duration-150 ease-in-out bg-white border border-r-0 rounded-l-sm form-input focus:bg-white sm:text-sm sm:leading-5"/>

                            <div class="absolute inset-y-0 right-0 flex items-center px-3 border-l">
                                <button @click="proposals.search()"
                                        class="text-gray-300 hover:text-yellow-500 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-teal-500 h-full">
                        <button @click="proposals.search()"
                                class="h-full text-gray-100 hover:text-yellow-500 focus:outline-none flex flex-nowrap gap-1 items-center px-2 border border-teal-600 border-l-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5"/>
                            </svg>
                            <span>Filters</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-8 w-full">
            <div class="flex flex-row gap-5 relative w-full">
                <div class="p-4 bg-white w-[260px] relative">
                    <h2 class="font-medium flex flex-nowrap justify-between gap-8">
                        <span>
                            Filters
                        </span>

                        <button
                                @mouseenter="showClearAll = true"
                                @mouseleave="showClearAll = false"
                                class="text-gray-300 hover:text-yellow-500 focus:outline-none flex items-center gap-2">
                            <span class="text-xs" v-if="showClearAll">Clear All</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </h2>
                </div>

                <div class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-3 max-w-7xl 2xl:max-w-full pr-16">
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                        <div class="w-full h-40 p-4 bg-white"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>
import {proposalsStore} from "../stores/proposals-store";
import {computed, onMounted, ref} from "vue";

// const console = computed(() => console);

let showClearAll = ref(false);
const proposals = proposalsStore();

onMounted(() => {
    console.log('mounted');
});

</script>
