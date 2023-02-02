<template>
    <header-component titleName0="Catalyst" titleName1="Funding Rounds" subTitle=""/>

    <div class="relative z-10">
        <section class="relative bg-primary-20 py-16">
            <div class="container">
                <div class="space-y-12">
                    <ul role="list"
                        class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 2xl:grid-cols-4 lg:gap-6">
                            <li v-for="fund in funds" :key="fund.id" class="py-8 px-6 bg-white text-center rounded-sm flex flex-row justify-center xl:px-8 xl:text-left">
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
                                                    <span class="text-gray-500 text-xs">Total <br />Awarded</span>
                                                </div>
                                                <div class="flex flex-col gap2 itemscenter justify-center">
                                                    <span class="text-gray-600 font-semibold text-lg">
                                                        {{fund.proposals_count}}
                                                    </span>
                                                    <span class="text-gray-500 text-xs">Projects <br />Funded</span>
                                                </div>
                                                <div class="flex flex-col gap2 itemscenter justify-center">
                                                    <span class="text-gray-600 font-semibold text-lg">
                                                        {{fund.launch_date}}
                                                    </span>
                                                    <span class="text-gray-500 text-xs">Launched</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                    </ul>
                </div>
                <div class="mt-6 paginator ">
                </div>
            </div>
        </section>

        <section id="catalystVoting" class="bg-gradient-to-br from-teal-800 via-teal-600 to-accent-900 text-white">
            <div class="container">
                <!-- <x-catalyst.ballot-quick-pitches :proposals="$quickPitches" /> -->
            </div>
        </section>
        <section class="relative bg-slate-50 border rounded-sm">
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
        </section>
    </div>
</template>

<script lang="ts">
import { storeToRefs } from "pinia";
import {useFundsStore} from "../stores/funds-store"

export default {
    setup(){
        const {funds}=storeToRefs(useFundsStore())

        return{
            funds
        }
    }
}
</script>
