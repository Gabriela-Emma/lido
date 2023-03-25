<template>
    <a :href="collection?.link"
       :class="[textColor$]"
       :style="{backgroundColor: collection?.color}"
       class="h-56 w-full object-cover shadow-md hover:shadow-xl rounded-l-xl rounded-r-xs flex flex-col justify-center relative">
        <div class="flex w-full justify-end absolute top-3 right-3">
            <button type="button"
                    :class="[textColor$, borderColor$]"
                    class="inline-flex items-center gap-x-0.5 rounded-sm border py-1 px-1.5 hover:text-slate-400 text-xs font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                {{ $t("View") }}
                <LinkIcon class="-mr-0.5 h-3 w-3" aria-hidden="true"/>
            </button>
        </div>
        <div class="relative flex justify-end my-auto">
            <h2 class="text-xl w-4/5 font-bold tracking-tight text-slate-100 sm:text-2xl inline box-border box-decoration-cloe bg-white py-4 px-3 rounded-l-lg text-slate-800 my-auto -right-6">
                {{ collection?.title }}
            </h2>
        </div>
        <div class="w-full flex gap-2 justify-end divide-x divide-slate-800 px-3 absolute bottom-3" v-if="collection?.items_count > 0">
<!--            <div-->
<!--                class="inline-flex items-center items-center rounded-sm py-0.5 pl-2.5 pr-1 text-sm font-medium text-black">-->
<!--                {{ $t("Items") }}-->
<!--                <span-->
<!--                    class="ml-0.5 inline-flex flex-shrink-0 items-center justify-center rounded-full text-black font-bold focus:outline-none">-->
<!--                    {{ collection?.items_count }}-->
<!--                </span>-->
<!--            </div>-->
            <div
                class="inline-flex items-center items-center rounded-sm py-0.5 pl-2.5 pr-1 text-sm font-medium">
                {{ $t("Items") }}
                <span
                    class="ml-0.5 inline-flex flex-shrink-0 items-center justify-center rounded-full font-bold focus:outline-none">
                    {{ collection?.items_count }}
                </span>
            </div>
        </div>
    </a>
</template>

<script lang="ts" setup>
import {computed, inject} from "vue";
import {usePage} from "@inertiajs/vue3";
import {LinkIcon} from '@heroicons/vue/20/solid';

import User from "../../models/user";
import BookmarkCollection from "../../models/bookmark-collection";


const props = withDefaults(
    defineProps<{
        collection?: BookmarkCollection
    }>(),
    {},
);
const $utils: any = inject('$utils');
const user = computed(() => usePage().props?.user as User);
const textColor$ = computed<string>(() =>
    $utils?.contrastColor(props.collection?.color) === 'light' ? 'text-white' : 'text-black'
);
const borderColor$ = computed<string>(() =>
    $utils?.contrastColor(props.collection?.color) === 'light' ? 'border-white' : 'border-black'
);
</script>
