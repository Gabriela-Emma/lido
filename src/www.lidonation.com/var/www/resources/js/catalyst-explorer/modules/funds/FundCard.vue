<template>
    <li class="py-8 px-6 bg-white text-center rounded-sm flex flex-row justify-center xl:px-8 xl:text-left">
        <div class="space-y-6 flex flex-col justify-between w-full xl:space-y-10">
            <a v-bind:href="fund.link"
            class="w-32 h-32 lg:w-32 lg:h-32 xl:w-44 xl:h-44 rounded-full mx-auto shadow-inner shadow-md">
                <img class="rounded-full w-full h-full"
                    v-bind:src="fund.thumbnail_url ?? fund.gravatar"
                    v-bind:alt="fund.title"/>
            </a>
            <div class="space-y-2 w-full xl:flex xl:items-center xl:justify-between items-end">
                <div class="font-medium text-lg leading-6 space-y-1 w-full">
                    <h2 class="mb-2">
                        <a v-bind:href="fund.link"
                        class="text-gray-800 hover:text-teal-700">
                            {{fund.title}}
                        </a>
                    </h2>
                    <div class="flex flex-row justify-between items-start gap-2 w-full">
                        <div class="flex flex-col gap2 itemscenter justify-center">
                            <span class="text-gray-600 font-semibold text-lg">
                                {{fund.currency_symbol}} {{fund.amount}}
                            </span>
                            <span class="text-gray-500 text-xs"> {{ $t("Total") }} <br />{{ $t("Awarded") }}</span>
                        </div>
                        <div class="flex flex-col gap2 itemscenter justify-center">
                            <span class="text-gray-600 font-semibold text-lg">
                                {{fund.proposals_count}}
                            </span>
                            <span class="text-gray-500 text-xs">{{ $t("Projects") }} <br />{{ $t("Funded") }}</span>
                        </div>
                        <div class="flex flex-col gap2 itemscenter justify-center">
                            <span class="text-gray-600 font-semibold text-lg">
                                {{fund.launch_date}}
                            </span>
                            <span class="text-gray-500 text-xs">{{ $t("Launched") }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script lang="ts" setup>
import Fund from "../../models/fund";
const props = withDefaults(
    defineProps<{
        fund: Fund
    }>(),
    {
        fund: () => {
            return {} as Fund;
        },
    },
);

</script>
