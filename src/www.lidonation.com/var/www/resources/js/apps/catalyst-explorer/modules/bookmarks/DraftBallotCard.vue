<template>
    <div :style="{ backgroundColor: draftBallot?.color }"
        class="relative flex flex-col justify-center object-cover w-full h-full text-white shadow-md hover:shadow-xl rounded-l-xl rounded-r-xs">
        <div class="relative flex justify-end my-auto">
            <div class="box-border inline w-4/5 px-3 py-4 my-auto bg-white rounded-l-lg  box-decoration-cloe  -right-6">
                <div class="text-xl sm:text-2xl font-bold tracking-tight text-slate-800 flex flex-col items-start">
                    <small
                        class="inline-flex items-center rounded-sm py-0.5 pr-1 text-xs font-medium">
                        {{ $t("Items") }}
                        <span
                            class="ml-0.5 inline-flex flex-shrink-0 items-center justify-center rounded-full font-bold focus:outline-none">
                            {{ draftBallot?.items_count }}
                        </span>
                    </small>
                    <span class="inline-flex line-clamp-3">{{ draftBallot?.title }}</span>
                </div>

                <div class="flex gap-2 mt-2">
                    <Link as="button" type="button" :href="route('catalyst-explorer.draftBallot.edit', {draftBallot: draftBallot?.hash})"
                          class="hover:text-slate-400 text-xs font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-800">
                        {{ $t("Edit") }}
                    </Link>
                    <Link as="button" type="button" :href="route('catalyst-explorer.draftBallot.view', {draftBallot: draftBallot?.hash})"
                          class="hover:text-slate-400 text-xs font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-800">
                        {{ $t("View") }}
                    </Link>
                </div>
            </div>
<!--            <div class="absolute flex justify-end w-full gap-2 px-3 divide-x divide-slate-800 bottom-3"-->
<!--                v-if="draftBallot?.items_count > 0">-->
<!--                <div class="inline-flex items-center rounded-sm py-0.5 pl-2.5 pr-1 text-sm font-medium text-black">-->
<!--                    {{ $t("Items") }}-->
<!--                    <span-->
<!--                        class="ml-0.5 inline-flex flex-shrink-0 items-center justify-center rounded-full font-bold text-black focus:outline-none">-->
<!--                        {{ draftBallot?.items_count }}-->
<!--                    </span>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import { LinkIcon, PencilIcon, TrashIcon } from '@heroicons/vue/20/solid';
import route from "ziggy-js";
import Proposal from "../../models/proposal";
import DraftBallot from "../../models/draft-ballot";
import axios from "axios";
import {useBookmarksStore} from "@apps/catalyst-explorer/stores/bookmarks-store";

const props = withDefaults(
    defineProps<{
        draftBallot?: DraftBallot<Proposal>
    }>(),
    {},
);

const bookmarksStore = useBookmarksStore();
let preparingDownload = ref<boolean>(false);

function download() {
    preparingDownload.value = true;
    let data = {
        ballot: props.draftBallot?.hash,
        d: true,
        d_t: 'csv'
    }

    const fileName = 'proposals.csv';
    const res = axios.get(route('catalyst-explorer.download.proposals'), {
        responseType: 'blob',
        params: data,
    });
    res.then(function (res) {
        const url = window.URL.createObjectURL(new Blob([res.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', fileName);
        document.body.appendChild(link);
        link.click();
        preparingDownload.value = false;
    });
}

let form = useForm({
    ballot: props.draftBallot?.hash,
})

function deleteDraftBallot() {
    form.delete(route('catalyst-explorer.draftBallot.delete', { draftBallot: props.draftBallot?.hash }), {
        preserveScroll: true,
        onSuccess: () => {
            bookmarksStore.deleteCollection(props.draftBallot?.hash);
            bookmarksStore.loadDraftBallots();
        }
    });
}
</script>
