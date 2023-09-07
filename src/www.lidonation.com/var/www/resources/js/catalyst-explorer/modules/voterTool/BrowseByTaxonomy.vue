<template>
    <section class="relative py-16 bg-teal-600" v-if="loaded && taxonomies.length > 0">
        <div class="container">
            <h2 class="mb-4 text-2xl font-extrabold xl:text-4xl 2xl:text-6xl text-slate-50">
                Browse by {{ taxonomy }}
            </h2>
            <div>
                <div class="flex flex-row flex-wrap justify-start gap-6">
                    <div v-if="!!taxonomies" v-for="tax in taxonomies.data" :key="tax.id"
                        class="flex flex-auto bg-white rounded-md cursor-pointer hover:bg-slate-200"
                        :class="[selected == tax.id ? 'bg-teal-100 hover:bg-teal-300' : 'bg-white hover:bg-slate-200']"
                        @click='emitData(tax.id)'>
                        <div class="flex flex-row items-center justify-between w-full p-4">
                            <div class="font-medium text-slate-700">
                                {{ tax.title }}
                            </div>
                            <div class="ml-5 rounded-sm bg-slate-100">
                                <div class="px-4 py-3 font-semibold rounded-sm bg-slate-300 aspect-square">
                                    {{ tax.current_fund_proposals }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else v-for="index in numberRange"
                        class="flex flex-auto h-[84px] rounded-md animate-pulse bg-slate-300 w-80"></div>
                </div>
                <div class="flex-1 mt-6" v-if="taxonomy == 'Tag' && !!taxonomies">
                    <Pagination :links="taxonomies?.links" :per-page="perPage" :total="taxonomies?.total"
                        :from="taxonomies?.from" :to="taxonomies?.to" @paginated="(payload) => currTagGroupRef = payload"
                        :custom="true" :text-color-white="true" />
                </div>
            </div>

        </div>
    </section>
</template>
<script lang="ts" setup>
import { Ref, computed, watch } from 'vue';
import axios from '../../../lib/utils/axios';
import route from 'ziggy-js';
import { ref } from 'vue';
import TaxonomyData = App.DataTransferObjects.TaxonomyData;
import Pagination from '../../Shared/Components/Pagination.vue';
import { VARIABLES } from '../../models/variables';

const props = defineProps<{
    taxonomy: string,
}>()

const emit = defineEmits<{
    (e: 'taxon', id: number): void
    (e: 'taxonomy', name: string): void
}>()

let selected = ref(null);

let emitData = (tax) => {
    selected.value = tax
    emit("taxon", tax);
    emit("taxonomy", props.taxonomy);
}

let taxonomies: Ref<{
    links: [],
    total: number,
    to: number,
    from: number,
    data: TaxonomyData[]
}> = ref(null);

let currTagGroupRef = ref(null);
let perPage = ref(24);

const setTaxonomies = async () => {
    let data = {}
    if (currTagGroupRef.value) {
        data[VARIABLES.PAGE] = currTagGroupRef.value;
    }
    if (perPage.value) {
        data[VARIABLES.PER_PAGE] = perPage.value;
    }

    data['tax'] = props.taxonomy
    taxonomies.value = (await axios.get(route('catalystExplorer.voterTool.taxomomy'), { params: data })).data;
};
setTaxonomies();

watch(currTagGroupRef, () => {
    setTaxonomies();
})

let numberRange = computed(() => Array.from({ length: 10 }, (_, index) => index + 1));
</script>
