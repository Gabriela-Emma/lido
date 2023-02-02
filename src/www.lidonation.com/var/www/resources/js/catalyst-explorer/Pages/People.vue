<template>
    <header-component titleName0="Catalyst" titleName1="Proposers"
                      subTitle="Diverse, independent, and together inspiring the highest level of human collaboration."/>
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

        <section class="relative py-8 mb-8" aria-labelledby="quick-links-title">
            <div class="container">
                <div class="text-center">
                    <ul role="list"
                        class="grid grid-cols-2 mx-auto gap-4 sm:grid-cols-4 xl:grid-cols-5 3xl:grid-cols-6">
                        <li v-for="catalystUser in props.users.data" class="bg-white round-sm p-8">
                            <div class="space-y-4">
                                <a class="block" :href="catalystUser.link" target="_blank">
                                    <img class="w-20 h-20 mx-auto rounded-full lg:w-24 lg:h-24"
                                         :src="catalystUser.profile_photo_url"
                                         :alt="catalystUser.name"/>
                                </a>

                                <div class="space-y-2">
                                    <div class="text-xs font-medium lg:text-sm">
                                        <h3>
                                            <a class="block" :href="catalystUser.link">
                                                {{ catalystUser.name }}
                                            </a>
                                        </h3>
                                        <p class=""
                                           x-data="{ tooltip: 'Member of {{catalystUser.proposals_count}} proposal team(s).' }">
                                                <span>
                                                    {{
                                                        catalystUser.proposals_count
                                                    }} {{ catalystUser.proposals_count > 1 ? 'Proposals' : 'Proposal' }}
                                                </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>


    </main>
</template>

<script lang="ts" setup>
import Search from "../Shared/Components/Search.vue";
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import {VARIABLES} from "../models/variables";
import User from "../models/user"

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
