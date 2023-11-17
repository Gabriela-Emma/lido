<template>
    <Head title="Project Catalyst Registrations & Voting History" />

    <header-component titleName0="Catalyst" titleName1="Registrations" subTitle=""/>

    <div class="relative z-10">
        <main class="flex flex-col gap-2 bg-primary-20">
            <section class="py-8">
                <div class="container">
                    <div class="flex items-center w-full h-10 lg:h-16">
                        <Search :search="search" placeholder="Paste in your stake address"
                                @search="(term) => setSearch(term)">
                        </Search>
                    </div>
                </div>
            </section>

            <section class="py-8">
                <div class="container">
                    <VoterRegistrations v-if="search?.length" :curr-page="currPageRef" :per-page="perPageRef"/>
                </div>
            </section>

            <section class="py-8">
                <div class="container">
                    <VoterVotesCast v-if="search?.length" :curr-page="currPageRef" :per-page="perPageRef"/>
                </div>
            </section>
        </main>
    </div>
</template>

<script lang="ts" setup>
import Search from "@apps/catalyst-explorer/Components/Global/Search.vue";
import {ref, watch} from "vue";
import VoterVotesCast from "@apps/catalyst-explorer/modules/registrations/VoterVotesCast.vue";
import VoterRegistrations from "@apps/catalyst-explorer/modules/registrations/VoterRegistrations.vue";
import {VARIABLES} from "@apps/catalyst-explorer/models/variables";
import {Head, router} from "@inertiajs/vue3";
import route from "ziggy-js";
import {storeToRefs} from "pinia";
import {onMounted} from "vue";
import {useRegistrationsSearchStore} from "@apps/catalyst-explorer/stores/registrations-search-store";

const props = withDefaults(
    defineProps<{
        searchTerm?: string,
        currPage?: number,
        perPage?: number
    }>(), {
        searchTerm: '',
        currPage: 1,
        perPage: 24
    });

const registrationsStore = useRegistrationsSearchStore();

let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);


onMounted(() => {
    registrationsStore.setSearchValue(props.searchTerm);
})

const {search} = storeToRefs(registrationsStore);

function setSearch(search: string) {
    registrationsStore.setSearchValue(search);
}

watch([search], () => {
    return query();
}, {deep: true});

watch([currPageRef, perPageRef], () => {
    query();
});

function query() {
    const data = {} as any;
    if (search.value?.length > 0) {
        data[VARIABLES.SEARCH] = search.value;
    }
    if (currPageRef.value) {
        data[VARIABLES.PAGE] = currPageRef.value;
    }
    if (perPageRef.value) {
        data[VARIABLES.PER_PAGE] = perPageRef.value;
    }
    router.get(
        route('catalyst-explorer.registrations'),
        data,
        {preserveState: false, preserveScroll: true}
    );
}
</script>
