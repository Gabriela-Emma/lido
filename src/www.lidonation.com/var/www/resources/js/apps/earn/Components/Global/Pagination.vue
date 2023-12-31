<template>
    <nav class="flex items-center flex-col xl:flex-row w-full justify-between border-t-2 px-4 sm:px-0 gap-16">
        <div class="flex w-full xl:w-auto flex-1 items-center justify-between">
            <div class="w-28 mt-3 relative top-3 flex flex-col gap-2">
                <Multiselect
                    placeholder="Per Page"
                    v-model="perPageRef"
                    :can-clear="false"
                    :options="[8, 12, 24, 36, 64, 128]"
                    :classes="{
                container: 'multiselect border-0 px-1 py-2 flex-wrap rounded-sm bg-slate-50',
                containerActive: 'shadow-none shadow-transparent box-shadow-none',
            }"
                />
                <p class="text-slate-400 text-sm">{{ $t('Per Page') }}</p>
            </div>

            <div class="-mt-9 flex gap-8">
                <div class="flex" v-if="prev">
                    <a href="#" v-if="prev?.url" @click.prevent="paginate(prev.page)"
                       class="inline-flex items-center border-t-2 border-transparent pt-10 pr-1 text-sm font-medium text-slate-500 hover:border-yellow-500 hover:text-yellow-500">
                        <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z"
                                  clip-rule="evenodd"/>
                        </svg>
                        {{ $t('Previous') }}
                    </a>
                    <span v-else
                              class="inline-flex items-center border-t-2 border-transparent pt-10 pr-1 text-sm font-medium text-slate-400">
                        <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z"
                                  clip-rule="evenodd"/>
                        </svg>
                        {{ $t('Previous') }}
                    </span>
                </div>

                <div class="hidden md:flex" v-if="pages">
                    <template v-for="link in pages">
                        <span
                            class="inline-flex items-center border-t-2 border-transparent px-4 pt-10 text-sm font-medium border-teal-500 text-teal-600"
                            v-if="!!link.active">{{ link.label }}</span>
                                <span href="#" v-else-if="link?.label === '...'"
                                      class="inline-flex items-center border-t-2 border-transparent px-4 pt-10 text-sm font-medium text-slate-500">
                            {{ link.label }}
                        </span>
                        <a href="#" v-else @click.prevent="paginate(link.page)"
                           class="inline-flex items-center border-t-2 border-transparent px-4 pt-10 text-sm font-medium text-slate-500 hover:border-yellow-500 hover:text-yellow-500">
                            {{ link.label }}
                        </a>
                    </template>
                </div>

                <div class="flex" v-if="next">
                    <a href="#" v-if="next?.url" @click.prevent="paginate(next.page)"
                       class="inline-flex items-center border-t-2 border-transparent pt-10 pl-1 text-sm font-medium text-slate-500 hover:border-yellow-500 hover:text-yellow-500">
                        {{ $t('Next') }}
                        <!-- Heroicon name: mini/arrow-long-right -->
                        <svg class="ml-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <span v-else
                          class="inline-flex items-center border-t-2 border-transparent pt-10 pl-1 text-sm font-medium text-slate-400">
                        {{ $t('Next') }}
                                <!-- Heroicon name: mini/arrow-long-right -->
                        <svg class="ml-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <div class="text-slate-400 text-xs lg:text-sm">
            {{ $t('Showing') }} {{ $filters.shortNumber(from, 2) }} {{ $t('of') }} {{ $filters.shortNumber(to, 2) }} {{ $t('of') }} {{ $filters.shortNumber(total, 2) }}
        </div>
    </nav>
</template>

<script lang="ts" setup>
import {defineEmits, computed, ref, watch, ComputedRef} from "vue";
import Multiselect from '@vueform/multiselect';
import PaginationLink from "@apps/catalyst-explorer/models/pagination-link";

const props = withDefaults(
    defineProps<{
        perPage?: number,
        from?: number,
        to?: number,
        total?: number,
        links?: PaginationLink[],
    }>(), {perPage: 24});
let perPageRef = ref(props.perPage);

const emit = defineEmits<{
    (e: 'paginated', page: number): void
    (e: 'per-page-updated', perPage: number): void
}>();

watch(perPageRef, () => {
    emit('per-page-updated', perPageRef.value);
});

function paginate(page: number) {
    emit('paginated', page);
}

function parsePageNumber(val): number {
    if (!val) {
        return val;
    }
    let valArr = val.split('?').pop();
    return parseInt(valArr.replace(/[^0-9]/g, ''));
}

// computer properties
const prev: ComputedRef<PaginationLink>  = computed(() => {
    const link = props.links[0];
    return {
        ...link,
        page: parsePageNumber(link?.url)
    };
});
const next: ComputedRef<PaginationLink> = computed(() => {
    const link = props.links[props.links?.length - 1];
    return {
        ...link,
        page: parsePageNumber(link?.url)
    };
});
const pages: ComputedRef<PaginationLink[]> = computed(() => {
    const links = [...props.links];
    links.pop();
    links.shift();
    return links.map((link) => ({
        ...link,
        page: parsePageNumber(link?.url)
    }));
});
</script>
