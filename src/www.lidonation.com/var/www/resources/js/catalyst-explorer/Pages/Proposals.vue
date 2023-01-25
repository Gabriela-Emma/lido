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
                <ProposalSearch></ProposalSearch>
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
                    <Proposals :proposals="props.proposals.data"></Proposals>
                </div>
            </div>
        </section>
    </div>

</template>

<script lang="ts" setup>
import {proposalsStore} from "../stores/proposals-store";
import {computed, onMounted, ref, watch} from "vue";
import Proposal from "../models/proposal";
import Proposals from "../modules/proposals/Proposals.vue";
import ProposalSearch from "../modules/proposals/ProposalSearch.vue";
import { router } from '@inertiajs/vue3'

const props = withDefaults(
    defineProps<{
        proposals: {
            links: [],
            data: Proposal[]
        };
    }>(), {});

// const console = computed(() => console);

let showClearAll = ref(false);
let search = ref('');
watch(search, (value) => {
    router.get(
        "/users",
        { search: search.value },
        { preserveState: true }
    );
});

const proposals = proposalsStore();

onMounted(() => {
    console.log('mounted');
});

</script>
