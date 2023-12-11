<template>
    <div :style="{ backgroundColor: draftBallot?.color }"
        class="relative flex flex-col justify-center object-cover w-full h-full text-white shadow-md hover:shadow-xl rounded-l-xl rounded-r-xs">
        <div class="relative flex justify-end my-auto">
            <div class="box-border inline w-4/5 px-3 py-4 my-auto bg-white rounded-l-lg box-decoration-clone -right-6">
                <div class="flex flex-col items-start text-xl font-bold tracking-tight sm:text-2xl text-slate-800">
                    <small class="inline-flex items-center rounded-sm py-0.5 pr-1 text-xs font-medium">
                        {{ $t("Items") }}
                        <span
                            class="ml-0.5 inline-flex flex-shrink-0 items-center justify-center rounded-full font-bold focus:outline-none">
                            {{ draftBallot?.items_count }}
                        </span>
                    </small>
                    <span class="inline-flex line-clamp-3">{{ draftBallot?.title }}</span>
                </div>

                <div class="flex gap-2 mt-2">
                    <Link as="button" type="button"
                        :href="route('catalyst-explorer.draftBallot.edit', { draftBallot: draftBallot?.hash })"
                        class="text-xs font-semibold text-teal-600 hover:text-slate-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-800">
                    {{ $t("Edit") }}
                    </Link>
                    <Link as="button" type="button"
                        :href="route('catalyst-explorer.draftBallot.view', { draftBallot: draftBallot?.hash })"
                        class="text-xs font-semibold text-teal-600 hover:text-slate-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-800">
                    {{ $t("View") }}
                    </Link>
                    <TrashIcon @click.prevent="deleteDraftBallot()" aria-hidden="true"
                        class="w-5 h-5 text-gray-500 hover:text-teal-600 hover:cursor-pointer" />
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import route from "ziggy-js";
import Proposal from "../../models/proposal";
import DraftBallot from "../../models/draft-ballot";
import axios from "axios";
import { useBookmarksStore } from "@apps/catalyst-explorer/stores/bookmarks-store";
import { TrashIcon } from "@heroicons/vue/20/solid";

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
    bookmarksStore.deleteCollection(props.draftBallot.hash);
    router.get(route('catalyst-explorer.myDraftBallots'));
}
</script>
