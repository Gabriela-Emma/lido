<template>
    <div v-if="tallies$?.data?.length > 0" class="w-full col-span-1 p-3 overflow-y-visible bg-white md:col-span-5 xl:col-span-8 xl:row-span-12 round-sm">
        <div class="flex items-center justify-between">
            <div class="text-blue-dark-500">
                <h2 class="flex items-end gap-2 mb-0 xl:text-3xl">
                    <span>Proposal Live Tally</span>
                    <span v-if="tallyUpdatedAt$" class="text-xl font-bold text-teal-500">
                        Last updated:
                        <timeago :datetime="tallyUpdatedAt$" />
                    </span>
                </h2>
                <p>
                    This shows how many wallets have expressed an opinion for a proposal.
                    We won't know the yes or no vote until after the voting period ends.
                </p>
                <div v-if="attachmentLink" class="pt-4">
                    <Attachment :attachementLink="attachmentLink" :title="'Download raw tallies'"/>
                </div>
            </div>
            <div class="p-1.5 text-center bg-teal-600 text-slate-100 shadow-accent-900 shadow-sm rounded-sm"
                v-if="talliesSum$">
                <div class="text-xl text-white md:text-2xl xl:text-3xl 2xl:text-4xl">
                    {{ talliesSum$.toLocaleString() }}
                </div>
                <small class="text-sm">Total Votes Cast</small>
            </div>
        </div>

        <div class="py-4">
            <div class="h-16 my-4 border border-r-0 rounded-sm">
                <div class="flex flex-col flex-wrap w-full gap-2 md:flex-row">
                    <div class="flex flex-1 max-w-[24rem] border-r">
                        <ChallengePicker v-model="challengesRef" />
                    </div>
                    <div class="flex flex-1 w-full">
                        <Search :search="search$" @search="(term) => search$ = term"></Search>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative w-full my-8" v-if="tallies$">
            <div
                class="pb-10 my-8 -mx-4 overflow-y-visible ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-sm">
                <table class="min-w-full divide-y divide-slate-300">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900 sm:pl-4">
                                <div class="flex gap-0.5 items-center flex-nowrap hover:cursor-pointer w-16 justify-start text-left"
                                    @click="toggleOrder()">
                                    <span>{{ $t("Tally") }}</span>
                                    <span class="flex items-center gap-1 text-teal-600 flex-nowrap">
                                        <span>
                                            <ChevronUpDownIcon class="w-4 h-4" />
                                        </span>
                                        <span>{{ order$ }}</span>
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-4">
                                {{ $t("Proposal") }}
                            </th>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:w-32 text-slate-900 sm:pl-4">
                                {{ $t("Budget") }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200 text-slate-900">
                        <tr v-for="tally in tallies$?.data">
                            <td class="w-16 py-4 pl-4 text-sm text-left max-w-0 sm:w-auto sm:max-w-none sm:pl-4">
                                {{ tally.tally }}
                            </td>

                            <td class="w-full py-4 pl-4 pr-3 text-sm max-w-0 sm:w-auto sm:max-w-none sm:pl-4">
                                <a target="_blank" :href="tally?.model?.link">{{ tally?.model?.title }}</a>
                            </td>

                            <td class="w-full py-4 pl-4 pr-3 text-sm max-w-0 sm:w-32 sm:max-w-none sm:pl-4">
                                <span class="block">
                                    {{
                                        $filters.currency(tally?.model?.amount_requested,
                                            tally?.model?.fund?.currency, 'en-US', 2)
                                    }}
                                </span>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class="flex items-center justify-between w-full gap-16 my-16 xl:gap-24">
                    <div class="flex-1 w-full px-6">
                        <Pagination :links="tallies$?.links" :per-page="perPage$" :total="tallies$?.total"
                            :from="tallies$?.from" :to="tallies$?.to"
                            @perPageUpdated="(payload) => (perPage$ = payload) && getTallies()"
                            @paginated="(payload) => (currPage$ = payload) && getTallies()" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { VARIABLES } from '../../models/variables';
import axios from 'axios';
import Pagination from '../../Shared/Components/Pagination.vue';
import route from 'ziggy-js';
import Challenge from '../../models/challenge';
import ChallengePicker from '../funds/ChallengePicker.vue';
import Search from '../../Shared/Components/Search.vue';
import { ChevronUpDownIcon } from '@heroicons/vue/20/solid';
import Attachment from './Attachment.vue';

const props = defineProps<{
    fundId: number
    challenges: Challenge[]
}>()



let tallies$ = ref<{
    links: [],
    total: number,
    to: number,
    from: number,
    data: any[]
}>(null);

let currPage$ = ref<number>(1);
let perPage$ = ref<number>(36);
let order$ = ref<string>('asc');
let search$ = ref<string>(null);
let challengesRef = ref<Challenge[]>(props.challenges);
let talliesSum$ = ref<number>(null);
let tallyUpdatedAt$ = ref<string>(null);
let attachmentLink = ref<string>(null);

getTallies();
getUpdatedDate();
getAttachmentLink();

function getQueryData() {
    const data = {};
    if (props.fundId) {
        data[VARIABLES.FUNDS] = props.fundId;
    }

    return data;
}

function toggleOrder() {
    if (order$.value === 'asc') {
        order$.value = 'desc';
    } else {
        order$.value = 'asc';
    }

    getTallies();
}

function getUpdatedDate() {
    axios.get(route('catalystExplorerApi.talliesUpdatedAt'))
        .then((res) => {
            tallyUpdatedAt$.value = res?.data?.updated_at;
        });
}

let query = () => {
    let params = getQueryData();
        axios.get(route('catalystExplorerApi.talliesSum'), { params })
        .then((res) => {
            talliesSum$.value = res?.data;
        })
        .catch((error) => {
            console.error(error);
        });
}

function getTallies() {
    axios.get(
        route('catalystExplorerApi.tallies'),
        {
            params: {
                p: currPage$.value,
                pp: perPage$.value,
                o: order$.value,
                s: search$.value,
                c: challengesRef.value?.map((challenge) => (challenge.id || challenge)),
                fs:props.fundId
            }
        })
        .then((res) => {
            tallies$.value = res?.data;
            perPage$.value = res?.data?.per_page;
            currPage$.value = res?.data?.page;
        })
        .catch((error) => {
            console.error(error);
        });
}

function getAttachmentLink() {
    axios.get(route('catalystExplorerApi.tallies.attachementLink'),
        {
            params: {
                fs: props.fundId,
            }
        }
    )
    .then((res) => {
        attachmentLink.value = res?.data;
    });
}

watch([search$], () => {
    getTallies();
    query();
}, { deep: true });

watch(() => props.fundId, () => {
    query();
    getTallies();
}, { deep: true });

watch([challengesRef], () => {
    getTallies();
    query();
}, { deep: true });
query();

</script>
