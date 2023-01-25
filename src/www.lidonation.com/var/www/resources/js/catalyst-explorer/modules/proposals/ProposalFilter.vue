<template>
    <div class="bg-white w-[260px] relative" v-if="showFilter">
        <h2 class="font-medium flex flex-nowrap justify-between gap-8 border-b p-4">
            <span>
                Filters
            </span>
            <button
                @mouseenter="showClearAll = true"
                @mouseleave="showClearAll = false"
                class="text-gray-300 hover:text-yellow-500 focus:outline-none flex items-center gap-2">
                <span class="text-xs" v-if="showClearAll">Clear All</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </h2>
        <div>
            <ul class="divide-y">
                <li class=" p-4"></li>
                <li class=" p-4"></li>
                <li class=" p-4"></li>
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {ref, watch, defineEmits} from "vue";

/// props and class properties
const props = withDefaults(
    defineProps<{
        showFilter?: false,
    }>(), {});
let showClearAll = ref(false);

/// events
const emit = defineEmits({
    inFocus: null,
    clearSearch: null,
    search: (term?: string) => {
        if (term) {
            return true
        } else {
            console.warn('Invalid search event payload!');
            return false
        }
    }
});

/// lifecycle hooks
// watch(search, debounce((term) => {
//     if (term.length > 2) {
//         emit('search', term);
//     }
// }, 500));

// functions
function clearSearch() {
    emit('clearSearch');
}

</script>
