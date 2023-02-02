<template >
    <header-component titleName0="Catalyst" titleName1="Proposers" subTitle=""/>
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
        <section class="relative py-8 text-white bg-teal-600 text-md">
        <div class="container">
            <div class="flex flex-row items-center gap-4">
                <!-- <x-catalyst.users.stats
                    :usersCount="$catalystUsersCount"></x-catalyst.users.stats> -->
            </div>
        </div>
    </section>

        <section class="relative py-8 bg-scroll bg-gray-100 bg-center bg-cover bg-pool-bw-light bg-blend-hard-light"
                aria-labelledby="quick-links-title">
            <div class="container">
                <div class="bg-white shadow-sm">
                    <div class="px-4 py-12 mx-auto text-center max-w-7xl sm:px-6 lg:px-8 lg:py-24">
                        <div class="space-y-8 sm:space-y-12">
                            <div class="space-y-5 sm:mx-auto sm:max-w-xl sm:space-y-4 lg:max-w-5xl">
                                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                                    Proposers
                                </h2>
                                <p class="text-xl text-gray-500">
                                    Diverse, independent, and together inspiring the highest level of human collaboration.
                                </p>
                            </div>
                            <ul role="list"
                                class="grid grid-cols-2 mx-auto gap-x-4 gap-y-8 sm:grid-cols-4 md:gap-x-6 lg:max-w-5xl lg:gap-x-8 lg:gap-y-12 xl:grid-cols-6">
                                    <li v-for="catalystUser in props.users">
                                        <div class="space-y-4">
                                            <a class="block" :href=catalystUser.link>
                                                <img class="w-20 h-20 mx-auto rounded-full lg:w-24 lg:h-24"
                                                    :src="catalystUser.profile_photo_url"
                                                    :alt="catalystUser.name" />
                                            </a>

                                            <div class="space-y-2">
                                                <div class="text-xs font-medium lg:text-sm">
                                                    <h3>
                                                        <a class="block" :href="catalystUser.link">
                                                            {{catalystUser.name}}
                                                        </a>
                                                    </h3>
                                                    <p class="" x-data="{ tooltip: 'Member of {{catalystUser.proposals_count}} proposal team(s).' }">
                                                        <span x-tooltip.theme.primary="tooltip">
                                                            {{catalystUser.proposals_count}} {{ catalystUser.proposals_count > 1 ? 'Proposals': 'Proposal'}}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                            </ul>
                        </div>
                    </div>
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
            data:User[]
        }
    }>(), {});

// Define a reactive variable for the search value
let search = ref(props.search);

// Watch the search value for changes and trigger the query function
watch([search],() => {
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
