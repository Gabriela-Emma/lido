<template>
    <div class="grid grid-cols-3 p-4 text-left gap-y-3 bg-gray-50">
        <div class="flex flex-col items-start justify-between p-2">
            <span class="flex justify-start text-xs font-medium text-gray-900">
                <span class="inline-flex">F11 Primary Proposals</span>
            </span>
            <span class="font-bold block text-xs text-gray-500">
                {{ singlePrimaryProposalCount ?? 0 }}
            </span>
        </div>
        <div class="flex flex-col items-start justify-between p-2">
            <span class="flex justify-start text-xs font-medium text-gray-900">
                <span class="indline-flex">F11 Co-proposing</span>
            </span>
            <span class="font-bold block text-xs text-gray-500">
                {{ multipleProposalCount ?? 0 }}
            </span>
        </div>
        <div class="flex flex-col items-start justify-between p-2">
            <span class="flex justify-start text-xs font-medium text-gray-900">
                <span>Completed Proposals</span>
            </span>
            <span class=" font-bold block text-xs text-gray-500">
                {{ completedProposalCount ?? 0 }}
            </span>
        </div>
        <div class="flex flex-col items-start justify-between p-2">
            <span class="flex justify-start text-xs font-medium text-gray-900">
                <span>Outstanding Proposals</span>
            </span>
            <span class="font-bold block text-xs text-gray-500">
                {{ outstandingProposalCount ?? 0 }}
            </span>
        </div>

        <div class="flex flex-col items-start justify-between p-2">
            <span class="flex justify-start text-xs font-medium text-gray-900">
                <span>Outstanding Co-Proposals</span>
            </span>
            <span class="font-bold block text-xs text-gray-500">
                {{ outstandingCoProposalCount ?? 0 }}
            </span>
        </div>

        <button @click="emit('filterUser')"
            class="flex flex-col items-start justify-center h-full p-2 text-center text-white bg-teal-700 rounded-sm hover:cursor-pointer hover:shadow-md hover:bg-teal-500">
            <span class="text-xs">
                See all {{ profileQuickView.username || 'user' }}'s proposals.
            </span>
        </button>
    </div>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';


interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: { original_url: string }[]
}

const props = defineProps<{
    profileQuickView: Author
}>();

const emit = defineEmits<{
    (e: 'filterUser'): void
}>();

let completedProposalCount = ref(null)
let outstandingProposalCount = ref(null)
let outstandingCoProposalCount = ref(null)
let singlePrimaryProposalCount = ref(null)
let multipleProposalCount = ref(null)
axios.get(`${usePage().props.ziggy.base_url}/catalyst-explorer/people/${props.profileQuickView.id}/metrics/sum/completed-proposals`, {})
    .then((res) => {
        completedProposalCount.value = res.data
    })
    .catch(error => {
        console.error(error);
    });

axios.get(`${usePage().props.ziggy.base_url}/catalyst-explorer/people/${props.profileQuickView.id}/metrics/sum/outstanding-proposals`, {})
    .then((res) => {
        outstandingProposalCount.value = res.data
    })
    .catch(error => {
        console.error(error);
    });

axios.get(`${usePage().props.ziggy.base_url}/catalyst-explorer/people/${props.profileQuickView.id}/metrics/sum/outstanding-co-proposals`, {})
    .then((res) => {
        outstandingCoProposalCount.value = res.data
    })
    .catch(error => {
        console.error(error);
    });

axios.get(`${usePage().props.ziggy.base_url}/catalyst-explorer/people/${props.profileQuickView.id}/metrics/sum/f11primary-proposals`, {})
    .then((res) => {
        singlePrimaryProposalCount.value = res.data
    })
    .catch(error => {
        console.error(error);
    });

axios.get(`${usePage().props.ziggy.base_url}/catalyst-explorer/people/${props.profileQuickView.id}/metrics/sum/f11-co-proposals`, {})
    .then((res) => {
        multipleProposalCount.value = res.data
    })
    .catch(error => {
        console.error(error);
    });
</script>
