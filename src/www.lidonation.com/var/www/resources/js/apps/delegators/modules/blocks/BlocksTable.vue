<template>
    <div v-if="!poolBlocks" class="w-full h-full flex items-center justify-center">
        <div
            class="flex items-center justify-center w-16 bg-white rounded-full bg-opacity-90">
            <svg
                class="relative w-16 h-16 border-t-2 border-b-2 rounded-full animate-spin border-primary-600"
                viewBox="0 0 24 24"></svg>
        </div>
    </div>
    <table v-if="poolBlocks" class="min-w-full divide-y divide-primary-800">
        <thead>
            <tr class="sticky top-0  bg-gradient-to-br from-primary-10 to-primary-20 via-slate-50">
                <th scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">
                    Time
                </th>
                <th scope="col"
                    class="py-3.5 px-3 text-left text-sm font-semibold text-slate-900">
                    Block
                </th>
                <th scope="col"
                    class="py-3.5 px-3 text-left text-sm font-semibold text-slate-900">
                    Epoch
                </th>
                <th scope="col"
                    class="py-3.5 px-3 text-left text-sm font-semibold text-slate-900">
                    Slot
                </th>
                <th scope="col"
                    class="py-3.5 px-3 text-left text-sm font-semibold text-slate-900">
                    Txs
                </th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 md:pr-0">
                    <span class="sr-only">Explore</span>
                </th>
            </tr>
        </thead>
        <tbody v-if="poolBlocks" class="divide-y divide-teal-800">
            <template v-for="block in poolBlocks">
                <tr :class="{
                    'text-teal-800': !block.hash,
                    'text-slate-600': !!block.hash,
                }">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium  sm:pl-6 md:pl-0">
                        <span v-text="block.date"></span>
                    </td>
                    <td class="whitespace-nowrap py-4 px-3 text-sm text-slate-600">
                        <span class="truncate w-16 inline-block text-right " v-text="block.hash"></span>
                    </td>
                    <td class="whitespace-nowrap py-4 px-3 text-sm">
                        <span v-text="block.epoch"></span>
                    </td>
                    <td class="whitespace-nowrap py-4 px-3 text-sm">
                        <span v-text="block.slot"></span>
                    </td>
                    <td class="whitespace-nowrap py-4 px-3 text-sm">
                        <span v-text="block.tx_count"></span>
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                        <span v-show="!block.hash">UPCOMING</span>
                        <a v-bind:href='"http://" + config?.blockExplorer + "/block/" + block.hash'
                            v-show="block.hash"
                            target="_blank"
                            class="text-teal-700 hover:text-teal-900">
                                Explore
                                <span class="sr-only">
                                    , on block explorer
                                </span>
                        </a>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</template>
<script lang="ts" setup>
import {useDelegatorsStore} from '../../stores/delegators-store';
import {storeToRefs} from "pinia";

const loadingBlocks = true;

let delegatorsStore = useDelegatorsStore();
let {config, poolBlocks} = storeToRefs(delegatorsStore);
</script>