<template>
    <div class="sticky top-0 z-30 bg-teal-600 border-b border-teal-400 md:border-teal-light-300 page-nav">
        <div class='container relative'>
            <div class="flex flex-row justify-between gap-4 flex-nowrap">
                <nav class="flex max-w-[70%] overflow-x-auto" aria-label="Breadcrumb">
                    <ol role="list" class="flex space-x-0">
                    </ol>
                </nav>
                <nav class="relative hidden lg:inline-flex">
                    <ul
                        class="flex flex-row items-center justify-end h-full gap-2 py-2 overflow-x-auto text-xs md:text-sm flex-nowrap">
                       <ConnectWallet />
                    </ul>
                </nav>

            </div>
        </div>

    </div>
</template>

<script lang="ts" setup>
import {inject} from "vue";
import ConnectWallet from "@/global/Components/ConnectWallet.vue";
const $utils: any = inject('$utils');

// const props = withDefaults(
//     defineProps<{
//         crumbs: []
//     }>(), {});
// let crumbsLength = computed<number>(() => props.crumbs?.length);
</script>
