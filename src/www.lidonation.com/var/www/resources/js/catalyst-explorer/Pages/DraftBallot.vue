<template>
    <header-component titleName0="Draft Ballot" :titleName1="draftBallot?.title"
        :subTitle="`Updated ${$filters.timeAgo(draftBallot.updated_at)}. Has ${draftBallot?.items_count} item${draftBallot?.items_count > 1 ? 's' : ''}.`" />

    <main class="flex flex-col gap-2 py-8 bg-primary-20">
        <div class="container">
            <section>
                <div v-if="userOwnDraftBallot" class="flex justify-center gap-2 mb-4">
                    <a type="button"
                        :href="$utils.localizeRoute(`catalyst-explorer/my/draft-ballots/${props.draftBallot.hash}/edit`)"
                        class="inline-flex items-center px-4 py-2 font-medium text-white bg-teal-700 border border-transparent rounded-sm shadow-sm hover:bg-white hover:text-slate-700">
                        Edit Draft
                    </a>
                </div>
                <masonry-wall :items="draftBallot.groups" :ssr-columns="1" :column-width="600" :gap="16" :max-columns="2">
                    <template #default="{ item: group, index }">
                        <div class="px-3 py-8 bg-white">
                            <div>
                                <small class="px-4 text-xs text-slate-500">Challenge</small>
                                <h1 class="px-4">{{ group.title }}</h1>
                                <span>{{ group.excerpt }}</span>
                            </div>
                            <div>
                                <ul role="list" class="divide-y divide-gray-200">
                                    <li v-for="item in group.items" :key="item.model?.id">
                                        <div class="block hover:bg-gray-50">
                                            <div class="flex items-center gap-3 px-4 py-4 sm:px-5">
                                                <div>
                                                    <div class="flex-1" v-if="item.model.vote?.vote === VOTEACTIONS.UPVOTE">
                                                        <HandThumbUpIcon aria-hidden="true"
                                                            class="w-10 h-10 text-teal-700" />
                                                    </div>
                                                    <div class="flex-1"
                                                        v-if="item?.model?.vote?.vote === VOTEACTIONS.DOWNVOTE">
                                                        <HandThumbDownIcon aria-hidden="true"
                                                            class="w-10 h-10 text-pink-800" />
                                                    </div>
                                                </div>
                                                <div class="w-full">
                                                    <div class="flex flex-col text-lg">
                                                        <a :href="item.model.link" target="_blank" rel="noopener noreferrer">
                                                            <div>
                                                                <h4 class="text-lg font-medium text-black xl:text-xl hover:text-teal-600">
                                                                    {{ item.model?.title }}
                                                                </h4>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="flex flex-row justify-between w-3/5 ">
                                                        <div class="flex items-center border rounded-sm border-slate-600">
                                                            <div class="py-0.5 px-1 text-xs">Funding Status</div>
                                                            <div class="inline-flex py-0.5 pr-0.5">
                                                                <ProposalFundingStatus :proposal="item.model" />
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center border rounded-sm border-slate-600">
                                                            <div class="px-1 py-0.5 text-xs">Project Status</div>
                                                            <div class="inline-flex py-0.5 pr-0.5">
                                                                <ProposalProjectStatus :proposal="item.model" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-1">
                                                        <div
                                                            class="flex flex-row items-center gap-5 text-sm text-slate-500">
                                                            <div class="flex items-center gap-1">
                                                                <div>{{ $t("Budget") }}</div>
                                                                <div class="font-semibold text-slate-700">
                                                                    {{ $filters.currency(item.model?.amount_requested) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </template>
                </masonry-wall>
            </section>
        </div>
    </main>
</template>

<script lang="ts" setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import DraftBallot from '../models/draft-ballot';
import { HandThumbUpIcon, HandThumbDownIcon } from '@heroicons/vue/20/solid';
import { computed, inject, Ref, ref, watch } from "vue";
import axios from 'axios';
import { useBookmarksStore } from "../stores/bookmarks-store";
import { storeToRefs } from 'pinia';
import moment from "moment-timezone";
import Proposal from '../models/proposal';
import { useUserStore } from '../../global/Shared/store/user-store';
import route from 'ziggy-js';
import { VOTEACTIONS } from '../models/vote-actions';
import ProposalFundingStatus from "../modules/proposals/partials/ProposalFundingStatus.vue"
import ProposalProjectStatus from "../modules/proposals/partials/ProposalProjectStatus.vue"


const userStore = useUserStore();
const { user$ } = storeToRefs(userStore);

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        draftBallot: DraftBallot<Proposal>
    }>(), {});

const onLocal: Ref<boolean> = ref(false);
const inLastTenMins: Ref<boolean> = ref(false);
const collectionHash = ref(props.draftBallot.hash);
const createdAt = ref(props.draftBallot.created_at);
let remove = ref(false)

// check if collection is on local
const bookmarksStore = useBookmarksStore();
const { collections$: storeCollections$ } = storeToRefs(bookmarksStore);

// check if user owns ballot
let userOwnDraftBallot = computed(() => user$.value?.id == props.draftBallot.user_id);

watch([storeCollections$], (newValue, oldValue) => {
    onLocal.value = storeCollections$.value?.some(collection => collection.hash === collectionHash.value);
});

// if from last 10mins
inLastTenMins.value = (moment().diff(moment(createdAt.value), 'minutes')) < 10;

let canDelete: Ref<boolean> = ref();
watch([onLocal, inLastTenMins], () => {
    canDelete.value = onLocal.value && inLastTenMins.value;
})

const removeCollection = () => {
    if (onLocal.value && inLastTenMins.value) {
        axios.delete(`${usePage().props.base_url}/catalyst-explorer/bookmark-collection?hash=${collectionHash.value}`)
            .then((res) => {
                bookmarksStore.deleteCollection(collectionHash.value)
                router.get(`${usePage().props.base_url}/catalyst-explorer/bookmarks`)
            })
            .catch((error) => {
                if (error.response && error.response.status === 403) {
                    console.error(error);
                }
            });
    }
}

const removeItem = (id: number) => {
    if (onLocal.value && inLastTenMins.value) {
        axios.delete(route('catalystExplorer.bookmarkItem.delete', { bookmarkItem: id }))
            .then((res) => {
                bookmarksStore.deleteItem(id, collectionHash.value)
                router.get(route('catalystExplorer.bookmark', { bookmarkCollection: collectionHash.value }))
            })
            .catch((error) => {
                if (error.response && error.response.status === 403) {
                    console.error(error);
                }
            });
    }
}

function createDraftBallot() {
    axios.post(route('catalystExplorer.bookmark.createBallot', { bookmarkCollection: collectionHash.value }))
        .then((res) => {
            console.log(res);
        })
        .catch((error) => {
            if (error.response && error.response.status === 403) {
                console.error(error);
            }
        });
}
</script>
