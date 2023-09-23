<template>
    <header-component titleName0="Catalyst" titleName1="Registrations" subTitle=""/>

    <div class="relative z-10">
        <main class="flex flex-col gap-2 bg-primary-20">
            <section class="py-8">
                <div class="container">
                    <div class="flex items-center w-full h-10 lg:h-16">
                        <Search :search="search" placeholder="Paste in your stake address"
                                @search="(term) => search = term">
                        </Search>
                    </div>
                </div>
            </section>

            <section class="py-8">
                <div class="container">
                    <VoterRegistrations v-if="search?.length" :search="search" :registrations="registrations"/>
                </div>
            </section>

            <section class="py-8">
                <div class="container">
                    <VoterVotesCast v-if="search?.length" :search="search" :curr-page="currPageRef" :per-page="perPageRef"/>
                </div>
            </section>
        </main>
    </div>
</template>

<script lang="ts" setup>
import Search from "../Shared/Components/Search.vue";
import {ref, watch} from "vue";
import VoterVotesCast from "../modules/registrations/VoterVotesCast.vue";
import VoterRegistrations from "@/catalyst-explorer/modules/registrations/VoterRegistrations.vue";
import CatalystRegistrationData = App.DataTransferObjects.CatalystRegistrationData;
import {VARIABLES} from "../models/variables";
import {router} from "@inertiajs/vue3";
import route from "ziggy-js";

const props = withDefaults(
    defineProps<{
        search?: string,
        currPage?: number,
        perPage?: number,
        registrations: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: CatalystRegistrationData[]
        }
    }>(), {
        search: '',
    });

let search = ref(props.search);
let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);

watch([search], () => {
    return query();
}, {deep: true});

watch([currPageRef, perPageRef], () => {
    query();
});

function query() {
    const data = {};
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
        route('catalystExplorer.registrations'),
        data,
        {preserveState: false, preserveScroll: true}
    );
}
</script>
