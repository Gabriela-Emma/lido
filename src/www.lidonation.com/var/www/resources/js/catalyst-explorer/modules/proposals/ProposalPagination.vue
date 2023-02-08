<template>
    <nav class="flex items-center justify-between border-t px-4 sm:px-0">
        <div class="-mt-px flex w-0 flex-1" v-if="prev">
            <a href="#" v-if="prev?.url" @click.prevent="paginate(prev.page)"
               class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-slate-500 hover:border-yellow-500 hover:text-yellow-500">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z"
                          clip-rule="evenodd"/>
                </svg>
                Previous
            </a>
            <span v-else
                  class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-slate-400">
                <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z"
                          clip-rule="evenodd"/>
                </svg>
                Previous
            </span>
        </div>

        <div class="hidden md:-mt-px md:flex">
            <template v-for="link in pages">
                <span
                    class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium border-teal-500 text-teal-600"
                    v-if="!!link.active">{{ link.label }}</span>
                <span href="#" v-else-if="link?.label === '...'"
                      class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-slate-500">
                    {{ link.label }}
                </span>
                <a href="#" v-else @click.prevent="paginate(link.page)"
                   class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-slate-500 hover:border-yellow-500 hover:text-yellow-500">
                    {{ link.label }}
                </a>
            </template>
        </div>

        <div class="-mt-px flex w-0 flex-1 justify-end" v-if="next">
            <a href="#" v-if="next?.url" @click.prevent="paginate(next.page)"
               class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-slate-500 hover:border-yellow-500 hover:text-yellow-500">
                Next
                <!-- Heroicon name: mini/arrow-long-right -->
                <svg class="ml-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                          clip-rule="evenodd"/>
                </svg>
            </a>
            <span v-else
                  class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-slate-400">
                Next
                <!-- Heroicon name: mini/arrow-long-right -->
                <svg class="ml-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                          clip-rule="evenodd"/>
                </svg>
            </span>
        </div>
    </nav>
</template>

<script lang="ts" setup>
import {defineEmits, computed} from "vue";
import PaginationLink from "../../models/pagination-link";

const props = withDefaults(
    defineProps<{
        links?: PaginationLink[],
    }>(), {});

const emit = defineEmits<{
    (e: 'paginated', page: number): void
}>();

function paginate(page: number) {
    emit('paginated', page)
}

function parsePageNumber(val): number {
    if (!val) {
        return  val;
    }
    return parseInt(val.replace(/[^0-9]/g, ''));
}

// computer properties
const prev = computed(() => {
    const link = props.links[0];
    return {
        ...link,
        page: parsePageNumber(link.url)
    };
});
const next = computed(() => {
    const link = props.links[props.links?.length - 1];
    return {
        ...link,
        page: parsePageNumber(link.url)
    };
});
const pages = computed(() => {
    const links = [...props.links];
    links.pop();
    links.shift();
    return links.map((link) => ({
        ...link,
        page: parsePageNumber(link.url)
    }));
});
</script>
