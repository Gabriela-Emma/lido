<template>
    <li class="flex flex-row justify-center px-6 py-8 text-center bg-white rounded-sm xl:px-8 xl:text-left">
        <div class="flex flex-col justify-between w-full space-y-6 xl:space-y-10">
            <a v-bind:href="fund.link"
            class="w-32 h-32 mx-auto rounded-full shadow-inner lg:w-32 lg:h-32 xl:w-44 xl:h-44">
                <img class="w-full h-full rounded-full"
                    v-bind:src="fund.thumbnail_url ?? fund.gravatar"
                    v-bind:alt="fund.title"/>
            </a>
            <div class="items-end w-full space-y-2 xl:flex xl:items-center xl:justify-between">
                <div class="w-full space-y-1 text-lg font-medium leading-6">
                    <h2 class="mb-2">
                        <a v-bind:href="fund.link"
                        class="text-gray-800 hover:text-teal-700">
                            {{fund.title}}
                        </a>
                    </h2>
                    <div class="flex flex-row items-start justify-between w-full gap-2">
                        <div class="flex flex-col justify-center">
                            <span class="text-lg font-semibold text-gray-600">
                                {{ $filters.currency(fund.amount, fund?.currency) }}
                            </span>
                            <span class="text-xs text-gray-500"> {{ $t("Total") }} <br />{{ $t("Awarded") }}</span>
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-lg font-semibold text-gray-600">
                                {{fund.proposals_count}}
                            </span>
                            <span class="text-xs text-gray-500">{{ $t("Projects") }} <br />{{ $t("Funded") }}</span>
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-lg font-semibold text-gray-600">
                                {{fund.launch_date}}
                            </span>
                            <span class="text-xs text-gray-500">{{ $t("Launched") }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script lang="ts" setup>
import Fund from "../../models/fund";
withDefaults(
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
