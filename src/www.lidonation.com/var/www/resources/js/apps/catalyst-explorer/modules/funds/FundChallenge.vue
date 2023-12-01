<template>
    <div
        class="relative flex flex-col overflow-hidden bg-white border border-gray-200 rounded-lg group hover:cursor-pointer">
        <a :href="fund.link" class="bg-gray-200 aspect-w-2 aspect-h-2 group-hover:opacity-75 sm:aspect-none sm:h-60">
            <img :alt="fund.title" :src="fund.thumbnail_url ?? fund.hero_url"
                class="object-cover object-center w-full h-full sm:w-full sm:h-full">
        </a>
        <div class="flex flex-col flex-1 p-4 space-y-2">
            <h2>
                <a v-bind:href="fund.link" class="text-left text-gray-800 hover:text-teal-700">
                    {{ fund.label }}
                </a>
            </h2>
            <p class="text-sm text-gray-500 h-auto">{{ fund.content.length > 150 ? fund.content.slice(0, 300) + ' ...' :
                fund.content }}</p>
            <div class="flex flex-col justify-end flex-1 divide-y">
                <p class="text-lg font-medium text-gray-900">
                    Budget: <span class="font-bold">{{ $filters.shortNumber(fund.amount, 2) }} ₳</span>
                </p>
                <div class="w-full grid mt-4 grid-cols-2 -mt-px text-sm divide-x xl:text-sm 2xl:text-md">
                    <div class="flex items-center justify-center flex-1 gap-2 p-2">
                        <div class="text-sm">
                            {{ $t("Proposals") }}:
                        </div>
                        <div class="font-semibold">
                            {{ fund.proposals_count }}
                        </div>
                    </div>

                    <div class="flex flex-1 -ml-px">
                        <div class="flex items-center justify-center flex-1 gap-2 p-2">
                            <div class="text-sm">
                                {{ $t("Approved") }}:
                            </div>
                            <div class="font-semibold">
                                {{ fund.funded_proposals }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import Fund from '../../models/fund';
const props = withDefaults(
    defineProps<{
        fund: Fund;
    }>(),
    {}
);
</script>