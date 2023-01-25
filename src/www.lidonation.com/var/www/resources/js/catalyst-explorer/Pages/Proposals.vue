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
                <ProposalSearch
                    :search="search"
                    @search="(term) => search=term"></ProposalSearch>
            </div>
        </section>
        <section class="py-8 w-full">
            <div class="flex flex-row gap-5 relative w-full">
                <ProposalFilter></ProposalFilter>

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
import {router} from '@inertiajs/vue3';
import ProposalFilter from "../modules/proposals/ProposalFilter.vue";

const props = withDefaults(
    defineProps<{
        search?: string,
        proposals: {
            links: [],
            data: Proposal[]
        };
    }>(), {});

// const console = computed(() => console);

let showClearAll = ref(false);
let search = ref(props.search);

watch(search, (value) => {
    query();
});

const proposals = proposalsStore();

onMounted(() => {
    console.log('mounted');
});

function query() {
    const data = {};
    if (search.value?.length > 0) {
        data['search'] = search.value;
    }

    router.get(
        "/catalyst-explorer/proposals",
        data,
        {preserveState: true, preserveScroll: true}
    );
}
</script>
