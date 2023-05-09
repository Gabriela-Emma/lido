<template>
    <div class="flex w-full h-full rounded-l-sm">
        <div class="relative flex-grow w-full h-full overflow-hidden focus-within:z-10">
            <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none lg:pl-3">
                <!-- <svg class="w-4 h-4 text-gray-400 lg:w-5 lg:h-5" viewBox="0 0 20 20" stroke="currentColor"
                     fill="none">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg> -->
                <MagnifyingGlassIcon class="w-4 h-4 text-gray-400 lg:w-7 lg:h-7"/>
            </div>

            <input name="search" id="search" v-focus
                   :placeholder='$t("News, Insights, Reviews")' v-model="search"
                   :class="{
                        'border-teal-500': (search?.length > 0),
                        'bg-white border-white': !(search?.length <= 0)
                   }"
                   class="block w-full h-full transition duration-150 ease-in-out border-4 border-r-0 border-white rounded-l-sm sm:text-sm sm:leading-5 placeholder:text-xs placeholder:text-slate-400 focus:placeholder:text-slate-300 placeholder:lg:text-base pl-7 lg:pl-10 form-input focus:outline-none"/>

            <div class="absolute inset-y-0 right-0 flex items-center px-1 bg-teal-700 lg:px-3 border-x">
                <button @click="clearSearch()"
                        class="h-full text-gray-300 border-0 hover:text-yellow-500 focus:outline-none">
                    <XMarkIcon class="w-4 h-4 text-gray-200 hover:text-yellow-500 lg:w-7 lg:h-7"/>
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {ref, watch, defineEmits} from "vue";
import {debounce} from "lodash";
import { XMarkIcon } from "@heroicons/vue/20/solid";
import {MagnifyingGlassIcon} from "@heroicons/vue/20/solid";

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
    if (term.length > 1) {
        emit('search', term);
    }
}, 500));
function clearSearch() {
    search.value = '';
    emit('search', search.value);
    emit('clearSearch');
}

</script>
