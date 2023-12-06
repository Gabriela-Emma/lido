<template>
    <div :style="{backgroundColor: collection?.color}"
       class="relative flex flex-col justify-center object-cover w-full h-full shadow-md hover:shadow-xl rounded-l-xl rounded-r-xs">
        <div class="relative flex justify-end my-auto">
            <div class="box-border inline w-4/5 px-3 py-4 my-auto bg-white rounded-l-lg  box-decoration-cloe  -right-6">
                <div class="text-xl sm:text-2xl font-bold tracking-tight text-slate-800 flex flex-col items-start">
                    <small
                        class="inline-flex items-center rounded-sm py-0.5 pr-1 text-xs font-medium">
                        {{ $t("Items") }}
                        <span
                            class="ml-0.5 inline-flex flex-shrink-0 items-center justify-center rounded-full font-bold focus:outline-none">
                            {{ collection?.items_count }}
                        </span>
                    </small>
                    <span class="inline-flex line-clamp-3">{{ collection?.title }}</span>
                </div>

                <div class="flex gap-2 mt-2">
                    <Link as="button" type="button" :href="route('catalyst-explorer.bookmark', {bookmarkCollection: collection?.hash})"
                          class="hover:text-slate-400 text-xs font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-800">
                        {{ $t("View") }}
                    </Link>
                </div>
            </div>

        </div>
    </div>
</template>

<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";
import BookmarkCollection from "../../models/bookmark-collection";
import route from "ziggy-js";
import Proposal from "../../models/proposal";

const props = withDefaults(
    defineProps<{
        collection?: BookmarkCollection<Proposal>
    }>(),
    {},
);
</script>
