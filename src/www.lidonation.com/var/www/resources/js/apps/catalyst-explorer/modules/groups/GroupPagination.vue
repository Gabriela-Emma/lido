<template>
    <nav class="flex items-center justify-between border-t px-4 sm:px-0">
        <div class="-mt-px flex w-0 flex-1">
            <a href="#"
               class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-slate-500 hover:border-yellow-500 hover:text-yellow-500">
                <!-- Heroicon name: mini/arrow-long-left -->
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z"
                          clip-rule="evenodd"/>
                </svg>
                {{ $t('Previous') }}
            </a>
        </div>
        <div class="hidden md:-mt-px md:flex">
            <a href="#"
               class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-slate-500 hover:border-yellow-500 hover:text-yellow-500">1</a>
            <!-- Current: "border-teal-500 text-teal-600", Default: "border-transparent text-slate-500 hover:text-yellow-500 hover:border-yellow-500" -->
            <a href="#"
               class="inline-flex items-center border-t-2 border-teal-500 px-4 pt-4 text-sm font-medium text-teal-600"
               aria-current="page">2</a>
       
        </div>
        <div class="-mt-px flex w-0 flex-1 justify-end">
            <a href="#"
               class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-slate-500 hover:border-yellow-500 hover:text-yellow-500">
                {{ $t('Next') }}
                <!-- Heroicon name: mini/arrow-long-right -->
                <svg class="ml-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                          clip-rule="evenodd"/>
                </svg>
            </a>
        </div>
    </nav>
</template>

<script lang="ts" setup>
import {ref, defineEmits} from "vue";

const props = withDefaults(
    defineProps<{
        links?: [],
    }>(), {});

const emit = defineEmits({
    paginated: null,
});
// let search = ref(props.search);
</script>
