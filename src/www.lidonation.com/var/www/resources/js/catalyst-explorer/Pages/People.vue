<template>
    <header-component titleName0="catalyst" titleName1="proposers"
                      subTitle="Diverse, independent, and together inspiring the highest level of human collaboration" />

    <main class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search
                        :search="search"
                        @search="(term) => search=term"></Search>
                </div>
            </div>
        </section>

        <People :users="props.users.data">  </People>

        <div class="flex-1 pb-16 container">
            <Pagination :links="props.users.links"
                        :per-page="props.perPage"
                        :total="props.users?.total"
                        :from="props.users?.from"
                        :to="props.users?.to"
                        @perPageUpdated="(payload) => perPageRef = payload"
                        @paginated="(payload) => currPageRef = payload"/>
        </div>
    </main>
</template>

<script lang="ts" setup>
import Search from "../Shared/Components/Search.vue";
import Pagination from "../Shared/Components/Pagination.vue";
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import {VARIABLES} from "../models/variables";
import User from "../../global/Shared/Models/user"
import People from "../modules/people/People.vue"
const props = withDefaults(
    defineProps<{
        search?: string,
        currPage?: number,
        perPage?: number,
        locale: string,
        users: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: User[]
        }
    }>(), {});

// Define a reactive variable for the search value
let search = ref(props.search);
let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);

// Watch the search value for changes and trigger the query function
watch([search], () => {
    currPageRef.value = null;
    return query();
}, {deep: true});

watch([currPageRef, perPageRef], () => {
    query();
});

// Function to update the data with the new search value
function query() {
    // Create an empty data object
    const data = {};

    if (currPageRef.value) {
        data[VARIABLES.PAGE] = currPageRef.value;
    }

    if (perPageRef.value) {
        data[VARIABLES.PER_PAGE] = perPageRef.value;
    }

    // If the search value is set and its length is greater than 0
    if (search.value?.length > 0) {
        // Add the search value to the data object with the key specified in VARIABLES.SEARCH
        data[VARIABLES.SEARCH] = search.value;
    }

    router.get(
        `/${props.locale}/catalyst-explorer/people`,
        data,
        {preserveState: true, preserveScroll: true}
    );

    // @ts-ignore
    if (typeof window?.fathom !== 'undefined') {
        // @ts-ignore
        window?.fathom?.trackGoal(VARIABLES.TRACKER_ID_PEOPLE, 0);
    }
}
</script>
