<template>
    <section class="relative py-16 bg-teal-600 ">
        <div class="container">
            <h2 class="mb-4 text-2xl font-extrabold xl:text-4xl 2xl:text-6xl text-slate-50">
                Browse by {{ taxonomy }}
            </h2>
            <div>
                <div class="flex flex-row flex-wrap justify-start gap-6">
                    <div v-if="!!taxonomies" v-for="tax in taxonomies" :key="tax.id" class="flex flex-auto bg-white rounded-md">
                        <div class="flex flex-row items-center justify-between w-full p-4">
                            <div class="font-medium text-slate-700">
                                {{ tax.title }}
                            </div>
                            <div class="ml-5 rounded-sm bg-slate-100">
                                <div class="px-4 py-3 font-semibold rounded-sm bg-slate-300 aspect-square">
                                    {{ tax.posts_count }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else v-for="index in numberRange"
                        class="flex flex-auto h-20 rounded-md animate-pulse bg-slate-300 w-80"></div>
                </div>
            </div>
        </div>
    </section>
</template>
<script lang="ts" setup>
import { computed } from 'vue';
import axios from '../../../lib/utils/axios';
import route from 'ziggy-js';
import { ref } from 'vue';

const props = defineProps<{
    taxonomy: string,
}>()

let taxonomies = ref(null);

const setTaxonomies = async () => {
    taxonomies.value = (await axios.get(route('catalystExplorer.voterTool.taxomomy'), { params: props.taxonomy })).data
};
setTaxonomies();

let numberRange = computed(() => Array.from({ length: 10 }, (_, index) => index + 1));
</script>