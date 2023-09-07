<template>
      <div class="relative z-10">
        <section class="relative py-16 bg-primary-20">
            <div class="container">
                <div class="space-y-12">
                    <ul role="list"
                        class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 2xl:grid-cols-4 lg:gap-6">
                        <template v-for="(fund, index) in funds">
                            <FundCard v-if="fund" :key="fund?.id" :fund="fund"></FundCard>
                        </template>
                    </ul>
                </div>
                <div class="mt-6 paginator ">
                </div>
            </div>
        </section>
    </div>
</template>

<script lang="ts" setup>

import FundCard from "./FundCard.vue";
import Fund from "../../models/fund";

withDefaults(
    defineProps<{
        funds: Fund[]
    }>(),
    {
        funds: () => [],
    },
);

</script>
