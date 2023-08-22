<template>
    <TransitionGroup tag="div" name="slide-fade" leave-to-class=" opacity-o" :duration='50' class="flex flex-row mt-2 gap-x-8 gap-y-4">
        <div class="flex cursor-pointer border rounded-sm shadow p-4  lg:w-[initial]" :class="[filter.title == _filter ? 'bg-teal-100 hover:bg-teal-300':'bg-white'  ]" v-for="filter in filterGroups"
            @click="setFilter(filter.title, filter.param)">
            <!-- <span :class="{ 'bg-teal-600': 1 }"
                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                aria-hidden="true"></span> -->
            <span class="ml-3 text-gray-600">
                <p>{{ filter.title }}</p>
                <span class="mt-2 text-sm">
                    {{ filter.description }}
                </span>
            </span>
        </div>

    </TransitionGroup>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import FilterGroups from "../../models/filter-groups"

const props = defineProps<{
    filterGroups: FilterGroups[];
}>();

let _filter = ref(null)
 let setFilter = (filter,param) => {
    _filter.value = filter
    emit('filter', param)
 }

const emit = defineEmits<{
    (e: 'filter', filter: string): void;
}>();


</script>