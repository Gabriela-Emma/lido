<template>
    <div class="bg-white p-6" v-if="(search && !voterData?.data) || voterData?.data?.length === 0">
        <p v-if="!isLoading">
            Could not find any registration transactions for the stake address <span class="font-bold">{{
                search
            }}</span>.
        </p>

        <div class="flex flex-col justify-center items-center text-lg gap-3" v-if="isLoading">
            <p>
                If we haven’t pre-generated your voting results we may need to retrieve your
                voting history and metadata via offline fragment and jormungandr sidechain analysis
                <a href="https://github.com/input-output-hk/catalyst-core/blob/main/src/audit/src/find/README.md "
                    target="_blank">replay</a>. <b>This can take up to 90 seconds.</b>
            </p>
            <svg aria-hidden="true" class="w-16 h-16 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-teal-600"
                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor" />
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentFill" />
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <ul v-if="isLoading" role="list" class="bg-white/90 p-4">
        <li v-for="index in 12" :key="index">
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

    <div class="bg-white/90 p-4" v-if="search && voterData?.data?.length > 0 && !isLoading">
        <div class="flex items-center gap-4 rounded-sm">
            <div class="sm:flex-auto">
                <div class="flex flex-col gap-2 text-gray-700">
                    <div class="flex flex-row items-center p-1">
                        <span class="text-lg font-semibold leading-6 text-gray-900">
                            My Voting History
                        </span>
                        <button @click="setDownload()"
                            class="flex text-sm bg-teal-400 hover:bg-teal-600 text-white p-0.5 ml-2 rounded">Download
                        </button>
                    </div>
                    <p class="">
                        Here are the onchain (jormungandr) transactions of votes cast for the stake address <span
                            class="font-bold">{{ search }}</span>
                    </p>
                    <p>
                        Voting history data was generated from jormungandr sidechain
                        <a href="https://docs.projectcatalyst.io/catalyst-basics/voting/how-to-audit-the-vote/voting-ledger-snapshots"
                            target="_blank">
                            snapshots
                        </a> provided by the iog catalyst team.

                        To produce this list we, then we run your voting key through this
                        <a href="https://github.com/input-output-hk/catalyst-core/blob/main/src/audit/src/find/README.md"
                            target="_blank">tool</a>.
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
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        fragment_id
                                    </th>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        caster
                                    </th>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        proposal
                                    </th>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        time
                                    </th>

                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        choice
                                    </th>

                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        raw_fragment
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="data in voterData?.data">
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        {{ data?.fragment_id }}
                                    </td>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        {{ data?.caster }}
                                    </td>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        {{ data?.proposal }}
                                    </td>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        {{ data?.time }}
                                    </td>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        {{ data?.choice }}
                                    </td>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                        {{ data?.raw_fragment }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex-1 mb-9">
                    <Pagination :links="voterData?.links" :per-page="perPageRef" :total="voterData?.total"
                        :from="voterData?.from" :to="voterData?.to" @perPageUpdated="(payload) => perPageRef = payload"
                        @paginated="(payload) => currPageRef = payload" />
                </div>
            </div>
        </div>
    </div>
</template>


<script setup lang="ts">
import { Ref, ref } from 'vue';
import axios from 'axios';
import route from 'ziggy-js';
import { watch } from 'vue';
import { storeToRefs } from "pinia";
import VoteData from "@apps/catalyst-explorer/models/vote-data";
import {useRegistrationsSearchStore} from "@apps/catalyst-explorer/stores/registrations-search-store";
import {VARIABLES} from "@apps/catalyst-explorer/models/variables";
import Pagination from "@apps/catalyst-explorer/Components/Global/Pagination.vue";

const props = defineProps<{
    currPage: number,
    perPage: number,
}>()

let voterData = ref<{
    links: [],
    total: number,
    to: number,
    from: number,
    data: VoteData[]
}>(null);

const registrationsStore = useRegistrationsSearchStore();
const {search} =storeToRefs(registrationsStore);

let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);

let isLoading = ref(false);

function getQueryData() {
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

    return data;
}

let query = () => {
    let params = getQueryData();
    isLoading.value = true
    axios.get(route('catalyst-explorer.voter-data'), { params }).then((res) => {
        voterData.value = res.data
        isLoading.value = false
    }).catch((e) => {
        isLoading.value = false
    });
}

let setDownload = () => {
    const jsonString = JSON.stringify(voterData.value.data);
    const blob = new Blob([jsonString], { type: "application/json" });
    const blobUrl = URL.createObjectURL(blob);
    const downloadLink = document.createElement("a");
    downloadLink.href = blobUrl;
    downloadLink.download = `${search.value}.json`;
    downloadLink.click();
    URL.revokeObjectURL(blobUrl);
}

watch([() => search, currPageRef, perPageRef], () => {
    query();
})
query();

</script>
