<template>
    <header-component titleName0="Catalyst" titleName1="Registrations" subTitle=""/>

    <div class="relative z-10">
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

            <section class="py-8">
                <div class="container">
                    <div v-if="search && registrations?.data?.length === 0">
                        <p>
                            Could not find any registration transactions for the stake address <span class="font-bold">{{ search }}</span>.
                        </p>
                    </div>
                    <div class="" v-if="search && registrations.data.length > 0">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <h1 class="text-base font-semibold leading-6 text-gray-900">
                                    My Registrations
                                </h1>
                                <p class="block mt-2 text-sm text-gray-700">
                                    Here are the onchain transactions of registrations for the stake address <span class="font-bold">{{ search }}</span>
                                </p>
                                <div class="p-2 text-white bg-teal-600 text-md">
                                    <p>
                                        All this tool does is show your historical registrations, not validate your.
                                        If you have your qr code you can use this iog tool validate your registrations:
                                        <a href="https://verify.testnet.projectcatalyst.io/" target="_blank" class="text-teal-500">
                                            https://verify.testnet.projectcatalyst.io/
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flow-root mt-8">
                            <div class="-my-2 overflow-x-auto sm:-mx-6">
                                <div class="inline-block min-w-full py-2 align-middle">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Tx</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="registration in registrations.data" :key="registration.tx">
                                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">{{ registration.created_at }}</td>
                                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                    <a class="inline-flex text-base font-medium text-teal-800 hover:text-yellow-500"
                                                    target="_blank" :href="`https://cexplorer.io/tx/${registration.tx}/metadata#data`">
                                                        {{ registration.tx }}
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script lang="ts" setup>
import Search from "../Shared/Components/Search.vue";
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import {VARIABLES} from "../models/variables";
import CatalystRegistrationData = App.DataTransferObjects.CatalystRegistrationData;
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
    }>(), {});

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
        {preserveState: true, preserveScroll: true}
    );
}
</script>
