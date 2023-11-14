<template>
    <div class="bg-white p-6" v-if="search && registrations?.data?.length === 0">
        <p>
            Could not find any registration transactions for the stake address <span class="font-bold">{{ search }}</span>.
        </p>
    </div>
    <ul v-if="isLoading" role="list" class="bg-white/90 p-4">
        <li v-for="index in 4" :key="index">
            <div class="rounded-sm p-4 w-full mx-auto">
                <div class="animate-pulse">
                    <div class="flex-1 space-y-6 py-1">
                        <div class="h-2 bg-primary-50 rounded"></div>
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-2 bg-primary-50 rounded col-span-2"></div>
                                <div class="h-2 bg-primary-50 rounded col-span-1"></div>
                            </div>
                            <div class="h-2 bg-primary-50 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <div class="bg-white/90 p-4" v-if="search && registrations?.data?.length > 0">
        <div class="flex items-center gap-4 rounded-sm">
            <div class="sm:flex-auto">
                <div class="max-w-2xl">
                    <h1 class="text-lg font-semibold leading-6 text-gray-900">
                        My Registrations
                    </h1>
                    <p class="block mt-2 text-gray-700">
                        Here are the onchain transactions of registrations for the stake address <span class="font-bold">{{ search }}</span>
                    </p>
                </div>
                <div class="max-w-xl p-3 mt-2 text-white bg-teal-600 rounded-sm text-md">
                    <p class="block mt-2 text-white">
                        This tool shows your historical registrations only. It does not validate your registration.
                        If you have your qr code you can use this IO tool to validate your registrations:
                        <a href="https://verify.testnet.projectcatalyst.io/" target="_blank"
                           class="text-yellow-500 hover:text-black">
                            https://verify.testnet.projectcatalyst.io/
                        </a>
                    </p>
                    <p class="block mt-2 text-white">
                        To learn how to registration as a voter, please visit:
                        <a href="https://docs.projectcatalyst.io/catalyst-basics/how-to-register-as-a-voter"
                           target="_blank" class="text-yellow-500 hover:text-black">
                            https://docs.projectcatalyst.io/catalyst-basics/how-to-register-as-a-voter
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="flow-root mt-8">
            <div class="-my-2 overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-sm">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Tx</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="registration in registrations.data" :key="registration.tx">
                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                    {{
                                        new Date(
                                            registration.created_at
                                        ).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"})
                                    }}
                                </td>
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
</template>

<script lang="ts" setup>
import CatalystRegistrationData = App.DataTransferObjects.CatalystRegistrationData;
import { Ref, ref } from 'vue';
import { VARIABLES } from '../../models/variables';
import axios from 'axios';
import route from 'ziggy-js';
import { watch } from 'vue';
import { useRegistrationsSearchStore } from '../../stores/registrations-search-store';
import { storeToRefs } from "pinia";

const props = withDefaults(
    defineProps<{
        currPage?: number,
        perPage?: number,
    }>(), {
});

let registrations = ref<{
    links: [],
    total: number,
    to: number,
    from: number,
    data: CatalystRegistrationData[]
}>(null);
const registrationsStore = useRegistrationsSearchStore();
const {search} =storeToRefs(registrationsStore);

let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);
let isLoading = ref(false);

function getQueryData() {
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
    return data;
}

let query = () => {
    let params = getQueryData();
    isLoading.value = true
    axios.get(route('catalyst-explorer.registrationsData'), { params }).then((res) => {
        registrations.value = res.data
        isLoading.value = false
    }).catch((e) => {
        isLoading.value = false
    });
}

watch([() => search], () => {
    query();
})
query();
</script>
