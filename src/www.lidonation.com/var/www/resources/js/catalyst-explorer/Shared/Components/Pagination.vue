<template>
    <nav class="flex flex-col w-full gap-16 xl:flex-row sm:px-0" :class="{ 'px-4 border-t-2 items-center justify-between ': !custom,'justify-end items-end':custom }">
        <div class="flex flex-1 w-full xl:w-auto"  :class="[custom ? 'justify-end' : 'justify-between items-center ' ]">
            <div class="relative flex flex-col gap-2 mt-3 w-28 top-3" v-if="!custom">
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
                <p class="text-sm text-slate-400">{{ $t('Per Page') }}</p>
            </div>

            <div class="flex " :class="{ 'gap-8 -mt-9 ': !custom }" >
                <div class="flex" v-if="prev">
                    <a href="#" v-if="prev?.url" @click.prevent="paginate(prev.page)"
                       class="inline-flex items-center pt-10 pr-1 text-sm font-medium border-t-2 border-transparent hover:border-yellow-500 hover:text-yellow-500" :class="[textColorWhite ? 'text-white' : 'text-slate-500 ']" >
                        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z"
                                  clip-rule="evenodd"/>
                        </svg>
                        {{ $t('Previous') }}
                    </a>
                    <span v-else
                              class="inline-flex items-center pt-10 pr-1 text-sm font-medium border-t-2 border-transparent " :class="[textColorWhite ? 'text-white' : 'text-slate-500 ']">
                        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
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
                            class="inline-flex items-center px-4 pt-10 text-sm font-medium border-t-2 border-transparent border-teal-500" :class="[textColorWhite ? 'text-yellow-500' : 'text-teal-600 ']"
                            v-if="!!link.active">{{ link.label }}</span>
                                <span href="#" v-else-if="link?.label === '...'"
                                      class="inline-flex items-center px-4 pt-10 text-sm font-medium border-t-2 border-transparent " :class="[textColorWhite ? 'text-white' : 'text-slate-500 ']">
                            {{ link.label }}
                        </span>
                        <a href="#" v-else @click.prevent="paginate(link.page)" :class="[textColorWhite ? 'text-white' : 'text-slate-500 ']"
                           class="inline-flex items-center px-4 pt-10 text-sm font-medium border-t-2 border-transparent hover:border-yellow-500 hover:text-yellow-500">
                            {{ link.label }}
                        </a>
                    </template>
                </div>

                <div class="flex" v-if="next">
                    <a href="#" v-if="next?.url" @click.prevent="paginate(next.page)"
                       class="inline-flex items-center pt-10 pl-1 text-sm font-medium border-t-2 border-transparent hover:border-yellow-500 hover:text-yellow-500" :class="[textColorWhite ? 'text-white' : 'text-slate-500 ']">
                        {{ $t('Next') }}
                        <!-- Heroicon name: mini/arrow-long-right -->
                        <svg class="w-5 h-5 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <span v-else
                          class="inline-flex items-center pt-10 pl-1 text-sm font-medium border-t-2 border-transparent " :class="[textColorWhite ? 'text-white' : 'text-slate-400 ']">
                        {{ $t('Next') }}
                                <!-- Heroicon name: mini/arrow-long-right -->
                        <svg class="w-5 h-5 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <div class="text-xs lg:text-sm" :class="[textColorWhite ? 'text-white':'text-slate-400 ']">
            {{ $t('Showing') }} {{ $filters.shortNumber(from, 2) }} {{ $t('to') }} {{ $filters.shortNumber(to, 2) }} {{ $t('of') }} {{ $filters.shortNumber(total, 2) }}
        </div>
    </nav>
</template>

<script lang="ts" setup>
import { computed, ref, watch, ComputedRef} from "vue";
import Multiselect from '@vueform/multiselect';
import PaginationLink from "../../models/pagination-link";
import { useFiltersStore } from "../../../global/Shared/store/filters-stores";
import { storeToRefs } from "pinia";

const props = withDefaults(
    defineProps<{
        perPage?: number,
        from?: number,
        to?: number,
        total?: number,
        links?: PaginationLink[],
        custom?:boolean
        textColorWhite?:boolean
    }>(), {
        perPage: 24,
        custom:false,
        textColor:false
    });
let perPageRef = ref(props.perPage);

const emit = defineEmits<{
    (e: 'paginated', page: number): void
    (e: 'per-page-updated', perPage: number): void
}>();

const filterStore = useFiltersStore();
const {currentModel} = storeToRefs(filterStore);
const {canFetch} = storeToRefs(filterStore);

watch(perPageRef, () => {
    emit('per-page-updated', perPageRef.value);
    currentModel.value.filters?.length ? '' : currentModel.value.filters = []
    currentModel.value.filters['perPage'] = perPageRef.value;
});

function paginate(page: number) {
    emit('paginated', page);
    canFetch.value = true;
    currentModel.value.filters?.length ? '' : currentModel.value.filters = []
    currentModel.value.filters['currentPage'] = page;
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
