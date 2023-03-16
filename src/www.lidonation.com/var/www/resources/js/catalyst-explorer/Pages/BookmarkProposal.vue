<template>
    <Modal>
        <div class="bg-teal-900 w-full flex flex-col rounded-sm relative overflow-clip">
            <div class="pt-12 xl:pt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-lg tracking-tight text-slate-300 sm:text-xl sm:tracking-tight lg:text-2xl lg:tracking-tight flex gap-2 justify-center">
                            <span>
                                {{ $t('Bookmark') }}
                            </span>
                            <b class="text-white">{{ proposal.title }}</b>
                        </h2>
                        <p class="mt-4 text-slate-200 max-w-md mx-auto">
                            {{ $t('Bookmarks can be public or private') }}.
                            {{ $t("If you're logged in, you may feature your bookmark on the lidonation bookmarks page") }}.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-8 bg-teal-700 pb-16 sm:mt-12 sm:pb-20 lg:pb-28">
                <div class="relative">
                    <div class="absolute inset-0 h-1/2 bg-teal-900"></div>
                    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="max-w-lg mx-auto rounded-sm shadow-lg overflow-hidden lg:max-w-none lg:flex">

                            <div class="flex-1 bg-teal-500">
                                <div class="flex justify-between w-full" v-if="!user?.id">
                                    <div class="p-4 w-1/2 text-white" >
                                        <div v-if="!creatingAnonymousBookmarks">
                                            <h3 class="text-xl font-bold text-slate-100 xl:text-2xl sm:tracking-tight text-center">
                                                {{ $t("You're not logged in") }}.
                                            </h3>

                                            <h4 class="text-center font-semibold mb-2">{{ $t('Log in to') }}:</h4>

                                            <ul role="list" class="space-y-5 lg:space-y-0 lg:grid lg:grid-cols-2 my-4 lg:gap-x-8 lg:gap-y-5">
                                                <li class="flex items-start lg:col-span-1">
                                                    <div class="flex-shrink-0 relative w-5 h-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                        </svg>
                                                    </div>
                                                    <p class="ml-3 text-sm text-slate-200">
                                                        {{ $t('Create and Manage multiple bookmarks from your portal') }}
                                                    </p>
                                                </li>
                                                <li class="flex items-start lg:col-span-1">
                                                    <div class="flex-shrink-0 relative w-5 h-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                        </svg>
                                                    </div>
                                                    <p class="ml-3 text-sm text-slate-200">
                                                        {{ $t('Name and share bookmark on lidonation bookmark page') }}.
                                                    </p>
                                                </li>
                                                <li class="flex items-start lg:col-span-1">
                                                    <div class="flex-shrink-0 relative w-5 h-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                        </svg>
                                                    </div>
                                                    <p class="ml-3 text-sm text-slate-200">
                                                        {{ $t('Leave or respond to comments on bookmarks') }}
                                                    </p>
                                                </li>
                                                <li class="flex items-start lg:col-span-1">
                                                    <div class="flex-shrink-0 relative w-5 h-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                        </svg>
                                                    </div>
                                                    <p class="ml-3 text-sm text-slate-200">
                                                        {{ $t('Create private bookmarks') }}
                                                    </p>
                                                </li>
                                            </ul>

                                            <div class="mt-5 flex justify-center">
                                                <button type="button" @click="creatingAnonymousBookmarks = true"
                                                        class="inline-flex items-center rounded-sm border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                    {{ $t('Continue Anonymously') }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="h-full flex flex-col justify-center" v-else>

                                            <!--                                                class="block w-full bg-teal-500 rounded-sm z-10 border border-slate-300 p-0.5 font-medium text-slate-900"-->
                                            <Multiselect
                                                @search-change="search"
                                                @option="createCollection"
                                                :options="collections"
                                                v-model="collectiondRef"
                                                mode="single"
                                                :searchable="true"
                                                :close-on-select="true"
                                                :clear-on-select="false"
                                                :createOption="collections?.length === 0"
                                                :placeholder="collections?.length === 0 ? 'Create new collection' : 'Select Collection'"
                                                value-prop="uuid"
                                                label="title"
                                                noOptionsText="Type collection name and hit enter"
                                                :classes="{
                                                    container: 'multiselect border-0 flex-wrap bg-teal-500',
                                                    containerActive: 'shadow-none shadow-transparent box-shadow-none',
                                                    search: 'w-full absolute inset-0 outline-none focus:ring-0 box-border border-0 text-base text-teal-800 bg-white rounded-sm pl-3.5 rtl:pl-0 rtl:pr-3.5 custom-input',
                                                    options: 'multiselect-options border-0'
                                                }"
                                            />
                                        </div>
                                    </div>

                                    <div class="bg-teal-600 ml-auto">
                                        <Login :show-logo="false" :embedded="true" />
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
import Modal from "../Shared/Components/Modal.vue";
import Challenge from "../models/challenge";
import Proposal from "../models/proposal";
import {usePage} from "@inertiajs/vue3";
import User from "../models/user";
import Login from "./Auth/Login.vue";
import {useBookmarksStore} from "../stores/bookmarks-store";
import Multiselect from '@vueform/multiselect';
import {TrashIcon} from "@heroicons/vue/20/solid";
import {storeToRefs} from "pinia";

const props = withDefaults(
    defineProps<{
        proposal?: Proposal
    }>(),
    {},
);
// const selectedCollection = ref(props.groupOptions?.[0] || '');
const user = computed(() => usePage().props?.user as User);
let creatingAnonymousBookmarks = ref(true);
const bookmarksStore = useBookmarksStore();
const {collections} = storeToRefs(bookmarksStore);

////
// events & watchers
////
const emit = defineEmits<{
    (e: 'update:modelValue', challenge: Challenge): void
}>();

// watch(selectedRef, (newChallenge, oldFund) => {
//     emit('update:modelValue', newChallenge);
// });

////
// Actions
////////////////
function search(search) {
    // console.log(search);
    // bookmarksStore.search({search})
}
function createCollection(option) {
    console.log(option);
    // fire a create new action
    // bookmarksStore.search({search})
}
</script>
