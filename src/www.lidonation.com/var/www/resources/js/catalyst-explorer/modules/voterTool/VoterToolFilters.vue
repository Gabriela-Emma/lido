<template>
    <TransitionGroup tag="div" name="slide-fade" leave-to-class=" opacity-o" :duration='50'
        class="flex flex-row justify-end mt-2 overflow-x-scroll gap-x-2 gap-y-4">
        <div class="flex flex-shrink-0 cursor-pointer border rounded-sm p-4 lg:w-[initial]"
            :class="[filter.param == _filter ? 'bg-teal-100 hover:bg-teal-300' : 'bg-white hover:bg-slate-200']"
            v-for="filter in filters" :key="filter.title" @click="emit('filter', filter.param)">
            <span class="ml-3 text-gray-600">
                <p>{{ filter.title }}</p>

                <div class="flex flex-col">
                    <span class="mt-2 text-sm">
                        {{ filter.description }}
                    </span>
                    <div v-if="waiting" class="h-2.5 bg-slate-300 rounded-full  w-24 my-2.5 animate-pulse m"></div>
                    <span class="text-sm italic" v-else>
                        Has {{ filter.count }} proposals
                    </span>
                </div>
            </span>
        </div>
    </TransitionGroup>
</template>

<script lang="ts" setup>
import { computed, onMounted, reactive, ref, watch } from "vue";
import FilterGroups from "../../models/filter-groups"
import axios from "axios";
import route from "ziggy-js";
import { Ref } from "vue";
import { filter } from "lodash";

const props = defineProps<{
    filterGroups: FilterGroups[];
    _filter: string
}>();

let filters = ref(props.filterGroups)
let waiting = ref(false);


const emit = defineEmits<{
    (e: 'filter', filter: string): void;
}>();

const params = computed(() => {
    return Object.values(filters.value).map((filter) => filter.param);
});



let getCounts = async () => {
    waiting.value = true;
    try {
        const res = await axios.get(route('catalystExplorer.voterTool.counts'), { params: params.value });
        const responseData = res.data;

        filters.value = Object.values(filters.value).map((filter) => {
            let updatedFilter = { ...filter };
            Object.keys(responseData).forEach((key) => {
                if (key === filter.param) {
                    updatedFilter.count = responseData[key];
                }
            });
            console.log({ jj: filters.value });
            
            return updatedFilter;
        });

    } catch (e) {
        console.error(e);
    } finally {
        waiting.value = false;
    }
};

watch(
    () => props.filterGroups,
    (newFilterGroups, oldFilterGroups) => {
        filters.value = newFilterGroups; 
        getCounts();
    },
    { deep: true, immediate: true }
);


getCounts();


</script>
