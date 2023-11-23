<template>
    <div ref="target" >
        <li class="flow-root menu-item">
            <a @click="openMenu = !openMenu"
                class="px-1 py-3 font-semibold text-white menu-link hover:text-yellow-500" href="#">
                More
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                </svg>
            </a>
        </li>
        <teleport to="header">
            <Transition class="ease-in-out">
                <div class="fixed left-1/2 -translate-x-1/2 w-[1250px] h-[300px] mt-11 font-semibold rounded-sm shadow-md bg-white" v-if="openMenu">
                    <ul class="flex flex-row gap-28">
                        <ul class="block px-4 py-2 text-teal-600">Proposals
                            <li>
                                <Link
                                class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Proposals') }"
                                :href="route('catalyst-explorer.proposals')">
                                {{ $t('All Proposals') }}
                                </Link>
                            </li>
                            <li>
                                <Link
                                class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Funds') }"
                                :href="route('catalyst-explorer.funds.index')">
                                {{ $t('Funds') }}
                                </Link>
                            </li>
                        </ul>
                        <ul class="block px-4 py-2 text-teal-600">People
                            <li>
                                <Link
                                    class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                    :class="{ 'text-yellow-500': $page.component.startsWith('Groups') }"
                                    :href="$utils.localizeRoute('catalyst-explorer/groups')">
                                    {{ $t('Groups') }}
                                </Link>
                            </li>
                            <li>
                                <Link
                                class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                :class="{ 'text-yellow-500': $page.component.startsWith('DReps') }"
                                :href="route('catalyst-explorer.dReps.index')">
                                {{ $t('dReps') }}
                                </Link>
                            </li>
                            <li>
                                <Link
                                class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                :class="{ 'text-yellow-500': $page.component.startsWith('People') }"
                                :href="route('catalyst-explorer.people.index')">
                                {{ $t('Proposers') }}
                                </Link>
                            </li>
                        </ul>
                        <ul class="block px-4 py-2 text-teal-600">Charts
                            <li>
                                <a
                                class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Charts') }"
                                :href="route('catalyst-explorer.charts')">
                                {{ $t('Catalyst Charts') }}
                            </a>
                            </li>
                            <li>
                                <a
                                class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                href="/project-catalyst/votes/ccv4">
                                {{ $t('CCV4 Votes') }}
                            </a>
                            </li>
                        </ul>
                        <ul class="block px-4 py-2 text-teal-600">Tools
                            <li>
                                <Link
                                class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                :class="{ 'text-yellow-500': $page.component.startsWith('VoterTool') }"
                                :href="route('catalyst-explorer.voter-tool')">
                                {{ $t('Voter Tool') }}
                                </Link>
                            </li>
                            <li>
                                <a 
                                class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                href="/catalyst-explorer/registrations"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Registrations') }">
                                {{ $t('Registration') }}
                            </a>
                            </li>
                            <li>
                                <Link
                                class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                :class="{ 'text-yellow-500': $page.component.startsWith('VoterTool') }"
                                :href="route('catalyst-explorer.voter-tool')">
                                {{ $t('Check MY Vote') }}
                                </Link>
                            </li>
                        </ul>
                    </ul>
                    <button    
                    class="p-2 text-gray-900 menu-link font-normal hover:text-teal-800"
                    style="position: absolute; top: 0; right: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </Transition>
        </teleport>
    </div>
</template>
<script lang="ts" setup>
import { inject, ref } from "vue";
import route from "ziggy-js";
import {Link} from '@inertiajs/vue3';
import {onClickOutside} from '@vueuse/core';

const $utils: any = inject('$utils');

let openMenu = ref(false);

const target = ref(null)

onClickOutside(target, (event: any) => openMenu.value = false)

</script>