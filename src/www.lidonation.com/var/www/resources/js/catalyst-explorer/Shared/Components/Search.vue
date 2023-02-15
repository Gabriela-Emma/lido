<template>
    <div class="flex w-full h-full rounded-l-sm">
        <div class="relative flex-grow w-full h-full focus-within:z-10 overflow-hidden">
            <div class="absolute inset-y-0 left-0 flex items-center pl-2 lg:pl-3 pointer-events-none">
                <svg class="w-4 lg:w-5 h-4 lg:h-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor"
                     fill="none">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <input name="searchProposals" id="searchProposals" v-focus.ignoreEmpty
                   placeholder="Search title, proposal detail, or (co)authors" v-model="search"
                   :class="{
                        'bg-teal-500 text-white border-teal-500': (search?.length > 0),
                        'bg-white border-white': !(search?.length <= 0)
                   }"
                   class="block sm:text-sm sm:leading-5 placeholder:text-xs placeholder:text-slate-400 focus:placeholder:text-slate-100 placeholder:lg:text-base w-full border-white h-full pl-7 lg:pl-10 transition duration-150 ease-in-out border-4 border-r-0 rounded-l-sm form-input focus:bg-teal-500 focus:text-white focus:border-teal-500 focus:outline-none"/>

            <div class="absolute inset-y-0 right-0 flex items-center px-1 bg-white lg:px-3 border-x">
                <button @click="clearSearch()"
                        class="text-gray-300 hover:text-yellow-500 focus:outline-none border-0 h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
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
