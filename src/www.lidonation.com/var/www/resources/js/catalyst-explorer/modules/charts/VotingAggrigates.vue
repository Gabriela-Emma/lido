<template>
    <div class="grid h-full grid-cols-2 text-sm">
        <div class="relative col-span-2 row-span-1 md:text-base px-3 py-8 border border-white bg-blue-dark-500 round-sm">
            <RegisteredAdaPower :fundId="fundId"/>
        </div>
        <!--  -->
        <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-900 border border-white round-sm">
            <RegisteredWithoutVotes :fund-id="fundId"/>
        </div>
        <!--  -->
        <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-700 border border-white round-sm">
            <RegisteredWalletsWithoutVotes :fund-id="fundId"/>
        </div>
        <!--  -->
        <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-500 border border-white round-sm">
            <PowerDelegated :fund-id="fundId"/>
        </div>
        <!--  -->
        <div class="relative col-span-1 row-span-1 px-3 py-5 bg-teal-800 border border-white round-sm">
            <TotalWalletDelegations :fundId="fundId"/>
        </div>
        <!--  -->
        <div class="relative col-span-2 row-span-1 px-3 md:text-base py-8 bg-teal-900 border border-white round-sm">
            <TotalValidRegistration :fundId="fundId"/>
        </div>
    </div>
</template>

<script setup lang="ts">
import {defineAsyncComponent} from 'vue';
import TotalValidRegistration from './partials/TotalValidRegistration.vue'
import RegisteredAdaPower from './partials/RegisteredAdaPower.vue'
import TotalWalletDelegations from './partials/TotalWalletDelegations.vue'
import PowerDelegated from './partials/PowerDelegated.vue'
import RegisteredWalletsWithoutVotes from './partials/RegisteredWalletsWithoutVotes.vue'
import RegisteredWithoutVotes from './partials/RegisteredWithoutVotes.vue'

const props = defineProps<{
    fundId: number
}>()
</script>
