<template>
    <Modal>
        <div class="bg-teal-900 w-full flex flex-col rounded-sm relative overflow-clip">
            <div class="pt-12 xl:pt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-lg tracking-tight text-slate-300 sm:text-xl sm:tracking-tight lg:text-2xl lg:tracking-tight flex gap-2 justify-center">
                            <span>
                                {{ $t('BookmarkItem') }}
                            </span>
                            <b class="text-white">{{ proposal.title }}</b>
                        </h2>
                        <p class="mt-4 text-slate-200 max-w-md mx-auto">
                            {{ $t('Bookmarks can be public or private') }}.
                            {{
                                $t("If you're logged in, you may feature your bookmark on the lidonation bookmarks page")
                            }}.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-8 bg-teal-700 pb-16 sm:mt-12 sm:pb-20 lg:pb-28">
                <div class="relative">
                    <div class="absolute inset-0 h-1/2 bg-teal-900"></div>
                    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="max-w-lg mx-auto rounded-sm shadow-lg lg:max-w-none lg:flex">

                            <div class="flex-1 bg-teal-500">
                                <div class="flex flex-col lg:flex-row lg:justify-between w-full">
                                    <div class="p-4 w-full lg:w-1/2 text-white">
                                        <div v-if="!bookmarked$">
                                            <div v-if="!creatingAnonymousBookmarks">
                                                <h3 class="text-xl font-bold text-slate-100 xl:text-2xl sm:tracking-tight text-center">
                                                    {{ $t("You're not logged in") }}.
                                                </h3>

                                                <h4 class="text-center font-semibold mb-2">{{ $t('Log in to') }}:</h4>

                                                <ul role="list"
                                                    class="space-y-5 lg:space-y-0 lg:grid lg:grid-cols-2 my-4 lg:gap-x-8 lg:gap-y-5">
                                                    <li class="flex items-start lg:col-span-1">
                                                        <div class="flex-shrink-0 relative w-5 h-5">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="h-5 w-5 absolute"
                                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                 stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                                            </svg>
                                                        </div>
                                                        <p class="ml-3 text-sm text-slate-200">
                                                            {{
                                                                $t('Create and Manage multiple bookmarks from your portal')
                                                            }}
                                                        </p>
                                                    </li>
                                                    <li class="flex items-start lg:col-span-1">
                                                        <div class="flex-shrink-0 relative w-5 h-5">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="h-5 w-5 absolute"
                                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                 stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                                            </svg>
                                                        </div>
                                                        <p class="ml-3 text-sm text-slate-200">
                                                            {{
                                                                $t('Name and share bookmark on lidonation bookmark page')
                                                            }}.
                                                        </p>
                                                    </li>
                                                    <li class="flex items-start lg:col-span-1">
                                                        <div class="flex-shrink-0 relative w-5 h-5">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="h-5 w-5 absolute"
                                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                 stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                                            </svg>
                                                        </div>
                                                        <p class="ml-3 text-sm text-slate-200">
                                                            {{ $t('Leave or respond to comments on bookmarks') }}
                                                        </p>
                                                    </li>
                                                    <li class="flex items-start lg:col-span-1">
                                                        <div class="flex-shrink-0 relative w-5 h-5">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="h-5 w-5 absolute"
                                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                 stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                                            </svg>
                                                        </div>
                                                        <p class="ml-3 text-sm text-slate-200">
                                                            {{ $t('Create private bookmarks') }}
                                                        </p>
                                                    </li>
                                                </ul>

                                                <div class="mt-5 flex justify-center">
                                                    <button type="button" @click="creatingAnonymousBookmarks = true"
                                                            class="inline-flex items-center rounded-sm border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                                        {{ $t('Continue Anonymously') }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="h-full flex flex-col gap-4 justify-center" v-else>
                                                <div
                                                    class="border border-slate-300 rounded-sm flex flex-col gap-4 w-full relative text-slate-800">
                                                    <div
                                                        class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2">
                                                        {{ $t("Bookmark Note") }}
                                                    </div>
                                                    <div class="w-full rounded-sm p-3">
                                                     <textarea
                                                         id="content"
                                                         name="content"
                                                         rows="4"
                                                         v-model="bookmarkProposalContent$"
                                                         class="mt-2 block w-full rounded-sm border-teal-800 focus:border-teal-700 focus:ring-teal-500 sm:text-sm bg-teal-800 text-white"
                                                     ></textarea>
                                                    </div>
                                                </div>

                                                <!--                                                class="block w-full bg-teal-500 rounded-sm z-10 border border-slate-300 p-0.5 font-medium text-slate-900"-->
                                                <Multiselect
                                                    mode="single"
                                                    @option="addToNewCollection"
                                                    @select="addToCollection"
                                                    value-prop="hash"
                                                    label="title"
                                                    :options="collections$"
                                                    :searchable="true"
                                                    :close-on-select="true"
                                                    :clear-on-select="false"
                                                    :create-option="true"
                                                    :placeholder="collections$?.length === 0 ? 'Create new collection' : 'Select Collection or Write New Col. Name'"
                                                    noOptionsText="Type collection name and hit enter"
                                                    :classes="{
                                                    container: 'multiselect border-0 flex-wrap bg-teal500 text-teal-800',
                                                    containerActive: 'shadow-none shadow-transparent box-shadow-none',
                                                    search: 'w-full absolute inset-0 outline-none focus:ring-0 box-border border-0 text-base bg-white rounded-sm pl-3.5 rtl:pl-0 rtl:pr-3.5 custom-input',
                                                    options: 'multiselect-options border-0',
                                                    optionPointed: 'is-pointed text-white bg-teal-600',
                                                    optionSelected: 'text-white bg-teal-600',
                                                }"
                                                />

                                                <!-- Turn this into reusable error component that takes an AxiosError or a errors: models/errors object -->
                                                <template v-if="errors">
                                                    <div class="rounded-sm bg-teal-800 mt-3 text-yellow-500">
                                                        <div class="flex  p-4">
                                                            <div class="flex-shrink-0">
                                                                <XCircleIcon class="h-5 w-5 font-semibold"
                                                                             aria-hidden="true"/>
                                                            </div>
                                                            <div class="ml-3">
                                                                <h3 class="text-sm font-medium">
                                                                    {{  $t("Error") }}
                                                                </h3>
                                                                <div class="mt-2 text-sm">
                                                                    <ul role="list" class="list-disc space-y-1 pl-5">
                                                                        <template
                                                                            v-for="error in Object.getOwnPropertyNames(errors)">
                                                                            <li>
                                                                                {{ errors[error] }}
                                                                            </li>
                                                                        </template>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="" v-else-if="collection$?.hash">
                                            <div class="relative isolate flex flex-col items-center">
                                                <a :href="collection$?.link" :style="{backgroundColor: collection$?.color}"
                                                    class="h-56 w-72 lg:max-w-xs p-3 object-cover shadow-md hover:shadow-xl rounded-l-xl rounded-r-xs flex flex-col justify-center relative">
                                                    <div class="flex w-full justify-end absolute top-1 right-1">
                                                        <button type="button"
                                                           class="inline-flex items-center gap-x-0.5 rounded-sm bg-slate-600 py-1 px-1.5 hover:text-white text-xs font-semibold text-white shadow-sm hover:bg-slate-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                                                            {{  $t("View") }}
                                                            <ArrowTopRightOnSquareIcon class="-mr-0.5 h-3 w-3" aria-hidden="true" />
                                                        </button>
                                                    </div>
                                                    <div class="relative isolate h-16 mb-2">
                                                        <h2 class="text-xl w-4/5 font-bold tracking-tight text-slate-100 sm:text-2xl inline box-border box-decoration-cloe bg-white py-4 px-3 mb-3 rounded-l-lg text-slate-800 absolute -right-3">
                                                            {{ collection$?.title }}
                                                        </h2>
                                                    </div>
                                                    <div class="w-full flex gap-2 justify-end" v-if="collection$?.items_count > 0">
                                                        <div
                                                            class="inline-flex items-center items-center rounded-sm py-0.5 pl-2.5 pr-1 text-sm font-medium text-black border border-black">
                                                            Items
                                                            <span
                                                                class="ml-0.5 inline-flex flex-shrink-0 items-center justify-center rounded-full text-black font-bold focus:outline-none">
                                                                {{ collection$?.items_count }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </a>


                                                <!--                                                <img-->
                                                <!--                                                    class="h-96 w-full flex-none rounded-2xl object-cover shadow-xl lg:aspect-square lg:h-auto lg:max-w-sm"-->
                                                <!--                                                    src="https://images.unsplash.com/photo-1519338381761-c7523edc1f46?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80"-->
                                                <!--                                                    alt=""/>-->

                                                <div class="flex-auto mt-4">
                                                    <h2 class="text-sm w-80 mx-auto pl-8 font-bold tracking-tight text-slate-200 sm:text-lg">
                                                        <span class="text-white">{{ proposal?.title }}</span>
                                                        bookmarked!
                                                    </h2>
                                                    <!--                                                    <p class="mt-6 text-lg leading-8 text-gray-300">-->
                                                    <!--                                                        Lorem ipsum dolor sit amet consect adipisicing elit.-->
                                                    <!--                                                    </p>-->
                                                    <!--                                                    <ul role="list"-->
                                                    <!--                                                        class="mt-10 grid grid-cols-1 gap-y-3 gap-x-8 text-base leading-7 text-white sm:grid-cols-2">-->
                                                    <!--                                                        <li class="flex gap-x-3">-->
                                                    <!--                                                            <CheckCircleIcon class="h-7 w-5 flex-none"-->
                                                    <!--                                                                             aria-hidden="true"/>-->
                                                    <!--                                                            Bookmark Saved-->
                                                    <!--                                                        </li>-->
                                                    <!--                                                    </ul>-->
                                                </div>

                                                <div
                                                    class="absolute inset-x-0 -top-16 -z-10 flex transform-gpu justify-center overflow-hidden blur-3xl">
                                                    <svg viewBox="0 0 1318 752" class="w-[82.375rem] flex-none"
                                                         aria-hidden="true">
                                                        <path fill="url(#ee394704-5802-4a27-9451-3d29bf7415a3)"
                                                              fill-opacity=".25"
                                                              d="m279.655 479.549-211.511-96.46L.638 751.469l279.017-271.92 380.928 173.723c-77.415-137.198-159.845-384.186 129.758-274.555C1152.34 515.756 1226.88 775.51 1299.76 547.101c58.31-182.726-41.07-382.222-98.04-459.13L964.951 386.243 771.295.416 279.655 479.55Z"/>
                                                        <defs>
                                                            <linearGradient id="ee394704-5802-4a27-9451-3d29bf7415a3"
                                                                            x1="1452.56" x2="-101.59" y1="515.446"
                                                                            y2="760.592" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#4F46E5"/>
                                                                <stop offset="1" stop-color="#80CAFF"/>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="bg-teal-600 lg:ml-auto items-center p-4 flex flex-col h-full lg:w-1/2 justify-center">
                                        <Login :show-logo="false" v-if="!user?.id" :embedded="true"/>
                                        <div v-else>
                                            <img
                                                src="https://storage.googleapis.com/www.lidonation.com/8651/conversions/VvemcGIMNQfjogVsxCVKDe4_po5VTjV_wFLGrKU-BaI-preview.jpg"
                                                alt="" class="aspect-[6/5] w-full rounded-sm object-cover">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import {computed, defineEmits, ref, watch} from "vue";
import Modal from '../Shared/Components/Modal.vue';
import Challenge from "../models/challenge";
import Proposal from "../models/proposal";
import {usePage} from "@inertiajs/vue3";
import User from "../../global/Shared/Models/user";
import Login from "./Auth/Login.vue";
import {useBookmarksStore} from "../stores/bookmarks-store";
import Multiselect from '@vueform/multiselect';
import {storeToRefs} from "pinia";
import BookmarkCollection from "../models/bookmark-collection";
import BookmarkItem from "../models/bookmark-item";
import axios from "axios";
import {XCircleIcon, ArrowTopRightOnSquareIcon} from '@heroicons/vue/20/solid';

const props = withDefaults(
    defineProps<{
        proposal?: Proposal
    }>(),
    {},
);
const user = computed(() => usePage().props?.user as User);
const bookmarksStore = useBookmarksStore();
const collections$ = ref<BookmarkCollection[]>([]);

const {collections$: storeCollections$} = storeToRefs(bookmarksStore);
collections$.value = [...storeCollections$.value].map(((col: BookmarkCollection) => ({
    ...col,
    disabled: col.items?.some((item) => item.model?.id === props.proposal.id)
})));

let creatingAnonymousBookmarks = ref(true);
let errors = ref()
let bookmarkProposalContent$ = ref(null)
let creating = false;
let bookmarked$ = ref(false);
let collection$ = ref<BookmarkCollection>(null);

// collection$.value = collections$.value[0] as BookmarkCollection;

////
// events & watchers
////
const emit = defineEmits<{
    (e: 'update:modelValue', challenge: Challenge): void
}>();

watch(storeCollections$, (newCollections: BookmarkCollection[], oldCollections) => {
    collections$.value = [...newCollections];
});

////
// Actions
////////////////
async function addToCollection(option) {
    if (creating) {
        creating = false;
        return;
    }
    errors.value = null;

    // create bookmarkItem
    const item = {
        model_id: props.proposal?.id,
        model_type: 'proposals',
        content: bookmarkProposalContent$.value,
        collection: {hash: option} as BookmarkCollection
    } as BookmarkItem;

    await bookmarkProposal(item);
}

async function addToNewCollection(title) {
    creating = true;
    errors.value = null;

    // create new collection
    const collection = {
        title
    } as BookmarkCollection;

    // create bookmarkItem
    const item = {
        model_id: props.proposal.id,
        model_type: 'proposals',
        content: bookmarkProposalContent$.value,
        collection
    } as BookmarkItem;

    await bookmarkProposal(item);
}

async function bookmarkProposal(item: BookmarkItem) {
    // get response
    try {
        const res = await axios.post(`${usePage().props.base_url}/catalyst-explorer/bookmarks/items`, item);

        // fire of store event to save collection to localStorage
        bookmarksStore.saveCollection(res.data?.data);

        // update ui
        bookmarked$.value = true;
        collection$.value = {...res.data.data};
    } catch (e) {
        errors.value = {...e?.response?.data?.errors || {message: e?.response?.data?.message}};
        console.log(e);
    }
}
</script>
