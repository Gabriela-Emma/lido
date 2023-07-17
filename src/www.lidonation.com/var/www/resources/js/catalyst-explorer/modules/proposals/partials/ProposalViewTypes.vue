<template>
 <div class="flex gap-2">
    <div @click="proposalsStore.setViewType('card')" class="px-3 py-2 bg-white border-b-4 rounded-sm" :class="{
        'border-teal-600 text-teal-600' : viewType === 'card',
        'text-gray-400 border-white hover:cursor-pointer hover:text-teal-600 hover:border-teal-600': viewType !== 'card',
    }">
        <RectangleGroupIcon class="w-6 h-6"/>
    </div>

    <div @click="proposalsStore.setViewType('quickpitch')" class="px-3 py-2 bg-white border-b-4 rounded-sm" :class="{
        'border-teal-600 text-teal-600' : viewType === 'quickpitch',
        'text-gray-400 border-white hover:cursor-pointer hover:text-teal-600 hover:border-teal-600': viewType !== 'quickpitch',
    }">
        <VideoCameraIcon class="w-6 h-6"/>
    </div>
</div>
</template>
<script lang="ts" setup>
import { RectangleGroupIcon, VideoCameraIcon } from '@heroicons/vue/24/outline';
import {useProposalsStore} from "../../../stores/proposals-store";
import { storeToRefs } from 'pinia';

const proposalsStore = useProposalsStore();
let {viewType} = storeToRefs(proposalsStore);
</script>
