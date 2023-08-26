<template>
    <TransitionGroup tag="div" name="slide-fade" leave-to-class=" opacity-o" :duration='50'
        class="flex flex-row justify-end mt-2 overflow-x-hidden gap-x-2 gap-y-4">
        <div class="flex flex-shrink-0 cursor-pointer border rounded-sm p-4 lg:w-[initial]"
            :class="[filter.param == _filter ? 'bg-teal-100 hover:bg-teal-300' : 'bg-white hover:bg-slate-200']"
            v-for="filter in filterGroups" @click="emit('filter', filter.param)">
            <!-- <span :class="{ 'bg-teal-600': 1 }"
                class="inline-flex items-center justify-center w-4 h-4 mt-1 border-2 border-white rounded-full ring-1 ring-black"
                aria-hidden="true"></span> -->
            <span class="ml-3 text-gray-600">
                <p>{{ filter.title }}</p>

                <div class="flex flex-col">
                    <span class="mt-2 text-sm">
                        {{ filter.description }}
                    </span>
                    <span class="text-sm italic">
                        Has {{ filter.count }} proposals
                    </span>
                </div>
            </span>
        </div>
    </TransitionGroup>
</template>

<script lang="ts" setup>
import FilterGroups from "../../models/filter-groups"

const props = defineProps<{
    filterGroups: FilterGroups[];
    _filter: string
}>();

let setFilter = (param) => {
    emit('filter', param)
}

const emit = defineEmits<{
    (e: 'filter', filter: string): void;
}>();


</script>
