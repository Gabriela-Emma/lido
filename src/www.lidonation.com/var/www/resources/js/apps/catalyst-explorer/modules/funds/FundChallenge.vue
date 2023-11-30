<template>
    <div
        class="flex flex-col divide-y rounded items-start justify-center text-center rounded-md bg-white xl:text-left">
        <!-- thumbnail or gravatar -->
        <a v-bind:href="fund.link" class="w-full h-64">
            <img class="w-full h-full" v-bind:src="fund.thumbnail_url ?? fund.gravatar"
                v-bind:alt="fund.title" />
        </a>

        <!-- content and budget -->
        <div class="flex flex-col w-full h-auto divide-y xl:px-8 bg-white">
            <div class="pt-8 flex flex-col items-start justify-between w-full space-y-6 xl:space-y-10">
                <div class="items-end w-full space-y-2 xl:flex xl:items-center xl:justify-between">
                    <div class="w-full space-y-1 text-lg font-medium leading-6">
                        <h2 class="mb-2">
                            <a v-bind:href="fund.link" class="text-left text-gray-800 hover:text-teal-700">
                                {{ fund.label }}
                            </a>
                        </h2>
                        <div class="flex flex-col items-start justify-between w-full gap-2">
                            <div class="h-48 text-lg font-medium text-left text-gray-500 min-h-1/2 overflow-hidden">
                                {{ fund.content.length > 150 ? fund.content.slice(150) + ' ...' : fund.content }}
                            </div>
                            
                            <div class="flex flex-row justify-center pt-4 gap-2">
                                <span class="text-lg font-medium text-gray-500">Budget:</span>
                                <span class="text-lg font-semibold text-gray-600">
                                    {{ $filters.shortNumber(fund.amount, 2) }} {{ fund.currency_symbol }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>

            <!-- proposed and approved, very bottom -->   
            <div class="w-full mt-6 grid grid-cols-2 -mt-px text-sm divide-x xl:text-sm 2xl:text-md">
                <div class="flex items-center justify-center flex-1 gap-2 p-2">
                    <div class="text-sm">
                        {{  $t("Proposals") }}:
                    </div>
                    <div class="font-semibold">
                        {{ fund.proposals_count }}
                    </div>
                </div>

                <div class="flex flex-1 -ml-px">
                    <div
                        class="flex items-center justify-center flex-1 gap-2 p-2">
                        <div class="text-sm">
                            {{  $t("Approved") }}:
                        </div>
                        <div class="font-semibold">
                            {{ fund.funded_proposals }}
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