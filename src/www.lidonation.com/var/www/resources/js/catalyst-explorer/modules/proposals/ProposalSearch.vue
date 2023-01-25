<template>
    <div class="flex items-center w-full h-16">
        <div class="flex w-full h-full rounded-l-sm">
            <div class="relative flex-grow w-full h-full focus-within:z-10">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor"
                         fill="none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <input name="searchProposals" id="searchProposals" placeholder="Search title, proposal detail, or (co)authors" v-model="search"
                       class="block w-full h-full pl-10 transition duration-150 ease-in-out bg-white border border-r-0 rounded-l-sm form-input focus:bg-white focus:border-slate-600 sm:text-sm sm:leading-5"/>

                <div class="absolute inset-y-0 right-0 flex items-center px-3 border-l">
                    <button @click="clearSearch()"
                            class="text-gray-300 hover:text-yellow-500 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="bg-teal-500 h-full">
            <button @click=""
                    class="h-full text-gray-100 hover:text-yellow-500 focus:outline-none flex flex-nowrap gap-1 items-center px-2 border border-teal-600 border-l-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5"/>
                </svg>
                <span>Filters</span>
            </button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {ref, watch, defineEmits} from "vue";
import {debounce} from "lodash";

const props = withDefaults(
    defineProps<{
        search?: string,
    }>(), {});

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
let search = ref(props.search);
watch(search, debounce((term) => {
    if (term.length > 2) {
        emit('search', term);
    }
}, 500));
function clearSearch() {
    search.value = '';
    emit('search', search.value);
    emit('clearSearch');
}

</script>
