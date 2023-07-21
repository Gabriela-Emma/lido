<template>
    <transition enter-active-class="transition duration-200 ease-out" enter-from-class="translate-y-1 opacity-0"
        enter-to-class="translate-y-0 opacity-100" leave-active-class="transition duration-150 ease-in"
        leave-from-class="translate-y-0 opacity-100" leave-to-class="translate-y-1 opacity-0">

        <div class="absolute z-10 w-full h-full px-4 transform -translate-x-1/2 -translate-y-0 left-1/2 sm:px-0 bg-white/95"
            v-if="profileQuickView">
            <div class="flex flex-col h-full overflow-hidden rounded-sm shadow-xs ring-1 ring-black/5">
                <div class="relative flex gap-3 p-2 pt-16 text-white bg-teal-600 shadow-sm">
                    <div class="absolute top-0 flex justify-end w-full h-16 px-5 py-3">
                        <button type="button" @click="emit('close');"
                            class="flex justify-center w-10 h-10 p-2 text-white rounded-lg shadow-sm bg-slate-600 hover:bg-slate-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                            <XMarkIcon class="w-5 h-5" aria-hidden="true" />
                        </button>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 bg-white rounded-full">
                        <img class="relative inline-block w-10 h-10 rounded-full ring-2 ring-white"
                            :src="profileQuickView?.profile_photo_url" :alt="`${profileQuickView?.name} gravatar`" />
                    </div>
                    <div class="flex flex-0">
                        <h3 class="text-md md:text-xl">{{ profileQuickView?.name }}</h3>
                    </div>
                </div>

                <div class="relative flex flex-col flex-1 gap-4 bg-white p-7">
                    <a :href="$utils.localizeRoute(`project-catalyst/users/${profileQuickView.username}`)" target="_blank"
                        class="flex items-center p-2 -m-3 transition duration-150 ease-in-out rounded-lg hover:bg-gray-50 focus:outline-none focus-visible:ring focus-visible:ring-orange-500 focus-visible:ring-opacity-50">
                        <div class="flex items-center justify-center w-10 h-10 text-white shrink-0 sm:h-12 sm:w-12">
                            <LinkIcon class="w-5 h-5 text-slate-700" :class="{}" aria-hidden="true" />
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                                LIDO Profile
                            </div>
                            <p class="text-sm text-gray-500">
                                View Full Profile
                            </p>
                        </div>
                    </a>


                    <a :href="`https://cardano.ideascale.com/c/profile/${profileQuickView.ideascale_id}/`" target="_blank"
                        class="flex items-center p-2 -m-3 transition duration-150 ease-in-out rounded-lg hover:bg-gray-50 focus:outline-none focus-visible:ring focus-visible:ring-orange-500 focus-visible:ring-opacity-50">
                        <div class="flex items-center justify-center w-10 h-10 text-white shrink-0 sm:h-12 sm:w-12">
                            <img class="rounded-sm w-7 h-7" :src="$utils.assetUrl('img/ideascale-logo.png')"
                                alt="Ideascale logo">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                                Ideascale Profile
                            </div>
                            <p class="text-sm text-gray-500">
                                View & Contact user on Ideascale
                            </p>
                        </div>
                    </a>
                </div>
                <CatalystUserQuickStats :profileQuickView="profileQuickView"
                    @filter-user="handleFilterToUserProposals(profileQuickView)" />
            </div>
        </div>
    </transition>
</template>
<script lang="ts" setup>
import { inject, ref } from 'vue';
import { usePeopleStore } from '../../../stores/people-store';
import { LinkIcon, XMarkIcon } from "@heroicons/vue/20/solid";
import CatalystUserQuickStats from './CatalystUserQuickStats.vue';

interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: { original_url: string }[]
}

defineProps<{
    profileQuickView: Author
}>();

const $utils: any = inject('$utils');

const peopleStore = usePeopleStore();
let handleFilterToUserProposals = (user: Author) => {
    peopleStore.select([user.id]);
}

const emit = defineEmits<{
    (e: 'close'): void
}>();
</script>
