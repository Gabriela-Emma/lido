<template>
      <div class="relative z-10">
        <section class="relative bg-primary-20 py-16">
            <div class="container">
                <div class="space-y-12">
                    <ul role="list"
                        class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 2xl:grid-cols-4 lg:gap-6">
                        <FundCard v-for="fund in funds" :fund="fund"></FundCard>
                    </ul>
                </div>
                <div class="mt-6 paginator ">
                </div>
            </div>
        </section>

        <!-- <section id="catalystVoting" class="bg-gradient-to-br from-teal-800 via-teal-600 to-accent-900 text-white">
            <div class="container"> -->
                <!-- <x-catalyst.ballot-quick-pitches :proposals="$quickPitches" /> -->
            <!-- </div>
        </section> -->
        <!-- <section class="relative bg-slate-50 border rounded-sm">
            <div class="mx-auto max-w-7xl py-3 px-3 sm:px-6 lg:px-8">
                <div class="pr-16 sm:px-16 sm:text-center">
                    <p class="font-medium text-slate-400">
                        <span>
                            Are you a proposer? Link your
                        </span>
                        <span class="block sm:ml-2 sm:inline-block">
                          <a href="{{#}}"
                             target="_blank"
                             class="font-semibold underline flex flex-row gap-2 items-center">
                            <span>quickpitch</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                          </a>
                        </span>
                    </p>
                </div>
            </div>
        </section> -->
    </div>
</template>

<script lang="ts" setup>

import FundCard from "./FundCard.vue";
import Fund from "../../models/fund";

const props = withDefaults(
    defineProps<{
        funds: Fund[]
    }>(),
    {
        funds: () => [],
    },
);

</script>
