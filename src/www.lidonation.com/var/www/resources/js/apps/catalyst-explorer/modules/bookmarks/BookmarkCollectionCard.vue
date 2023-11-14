<template>
    <a :href="collection?.link"
       :class="[textColor$]"
       :style="{backgroundColor: collection?.color}"
       class="relative flex flex-col justify-center object-cover w-full h-full shadow-md hover:shadow-xl rounded-l-xl rounded-r-xs">
        <div class="absolute flex justify-end w-full gap-2 top-3 right-3">
            <Link as="button" type="button" :href="route('catalyst-explorer.draftBallot.edit', {draftBallot: collection?.hash})"
                    :class="[textColor$, borderColor$]"
                    class="inline-flex items-center gap-x-0.5 rounded-sm border py-1 px-1.5 hover:text-slate-400 text-xs font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                {{ $t("Edit") }}
                <PencilIcon class="-mr-0.5 h-3 w-3" aria-hidden="true"/>
            </Link>
            <button type="button"
                    :class="[textColor$, borderColor$]"
                    class="inline-flex items-center gap-x-0.5 rounded-sm border py-1 px-1.5 hover:text-slate-400 text-xs font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                {{ $t("View") }}
                <LinkIcon class="-mr-0.5 h-3 w-3" aria-hidden="true"/>
            </button>
        </div>
        <div class="relative flex justify-end my-auto">
            <h2 class="box-border inline w-4/5 px-3 py-4 my-auto text-xl font-bold tracking-tight bg-white rounded-l-lg text-slate-100 sm:text-2xl box-decoration-cloe text-slate-800 -right-6">
                {{ collection?.title }}
            </h2>
        </div>
        <div class="absolute flex justify-end w-full gap-2 px-3 divide-x divide-slate-800 bottom-3" v-if="collection?.items_count > 0">
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
import {Link} from "@inertiajs/vue3";
import {LinkIcon, PencilIcon} from '@heroicons/vue/20/solid';

import BookmarkCollection from "../../models/bookmark-collection";
import route from "ziggy-js";
import Proposal from "../../models/proposal";

const props = withDefaults(
    defineProps<{
        collection?: BookmarkCollection<Proposal>
    }>(),
    {},
);
const $utils: any = inject('$utils');
const textColor$ = computed<string>(() =>
    $utils?.contrastColor(props.collection?.color) === 'light' ? 'text-white' : 'text-black'
);
const borderColor$ = computed<string>(() =>
    $utils?.contrastColor(props.collection?.color) === 'light' ? 'border-white' : 'border-black'
);
</script>
