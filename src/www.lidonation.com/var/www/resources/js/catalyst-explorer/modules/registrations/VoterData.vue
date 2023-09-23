<template>
    <div class="flow-root mt-8" v-if="voterData?.data">
        <h1 class="text-lg font-semibold leading-6 text-gray-900">
            My Vote History
        </h1>
        <div class="-my-2 overflow-x-auto">
            <div class="inline-block min-w-full py-2 align-middle">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-sm">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    fragment_id</th>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    caster</th>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    proposal</th>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    time</th>

                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    choice</th>

                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    raw_fragment</th>
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
                <Pagination :links="voterData.links" :per-page="perPageRef" :total="voterData?.total"
                    :from="voterData?.from" :to="voterData?.to" @perPageUpdated="(payload) => perPageRef = payload"
                    @paginated="(payload) => currPageRef = payload" />
            </div>
        </div>
    </div>
    <div v-else class="flow-root p-2 font-semibold leading-6 text-gray-900 bg-white" >
        <p>Vote History not found</p>
    </div>
</template>


<script setup lang="ts">
import { Ref, ref } from 'vue';
import Pagination from '../../Shared/Components/Pagination.vue';
import VoteData from '../../models/vote-data';
import { VARIABLES } from '../../models/variables'
import axios from 'axios';
import route from 'ziggy-js';
import { watch } from 'vue';


const props = defineProps<{
    search: string
}>()

let voterData = ref<{
    links: [],
    total: number,
    to: number,
    from: number,
    data: VoteData[]
}>(null)


let search = ref(props.search);
let currPageRef = ref<number>(1);
let perPageRef = ref<number>(24);

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
    let params = getQueryData()
    axios.get(route('catalystExplorer.voterData'), { params }).
        then((res) => {
            voterData.value = res.data
        })
}

watch([() => props.search, currPageRef, perPageRef], () => {
    query();
})
query();

</script>