<template>
    <header class="py-10 container">
        <h1 class="text-2xl lg:text-3xl 2xl:text-5xl font-semibold text-slate-700">
            Catalyst <span class="text-teal-600">Proposals</span>
        </h1>
        <p class="text-slate-600">
            Search proposals and challenges by title, content, or author and co-authors.
        </p>
    </header>

    <main class="p-8  bg-primary-20">
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
                               class="block w-full h-full pl-10 transition duration-150 ease-in-out bg-white border rounded-sm form-input focus:bg-white sm:text-sm sm:leading-5" />

                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button @click="proposals.search()" class="text-gray-300 hover:text-red-600 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script lang="ts">
import {proposalsStore} from "../stores/proposals-store";

export default {
    setup() {
        const proposals = proposalsStore()

        return {
            // you can return the whole store instance to use it in the template
            proposals,
        }
    },
}
</script>
