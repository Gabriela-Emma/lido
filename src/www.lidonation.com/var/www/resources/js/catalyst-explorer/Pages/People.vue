<template>
    <header-component titleName0="Catalyst" titleName1="Proposers"
                      subTitle="Diverse, independent, and together inspiring the highest level of human collaboration." />

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
    </main>
</template>

<script lang="ts" setup>
import Search from "../Shared/Components/Search.vue";
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import {VARIABLES} from "../models/variables";
import User from "../models/user"
import People from "../modules/people/People.vue"
const props = withDefaults(
    defineProps<{
        search?: string,
        users: {
            links: [],
            data: User[]
        }
    }>(), {});

// Define a reactive variable for the search value
let search = ref(props.search);

// Watch the search value for changes and trigger the query function
watch([search], () => {
    return query();
}, {deep: true});

// Function to update the data with the new search value
function query() {
    // Create an empty data object
    const data = {};
    // If the search value is set and its length is greater than 0
    if (search.value?.length > 0) {
        // Add the search value to the data object with the key specified in VARIABLES.SEARCH
        data[VARIABLES.SEARCH] = search.value;
    }

    // Perform a GET request to "/catalyst-explorer/people" with the updated data
    router.get(
        "/catalyst-explorer/people",
        data,
        {preserveState: true, preserveScroll: true}
    );
}
</script>
