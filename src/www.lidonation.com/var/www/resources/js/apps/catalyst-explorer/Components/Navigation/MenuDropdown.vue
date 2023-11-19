<template>
    <div>
        <li class="flow-root menu-item">
            <a @click="openMenu = !openMenu"
                class="px-1 relative py-3 font-semibold text-white menu-link hover:text-yellow-500" href="#">
                {{ $t('More') }}
            </a>
        </li>
        <teleport to="header">
            <Transition name="fade" appear appear-active-class="transition-opacity duration-300"
                appear-to-class="opacity-100">
                <div ref="target" class="fixed z-20 overflow-y-auto mt-11 right-0 mr-5 transition-transform font-semibold rounded-sm shadow-md bg-white" v-if="openMenu">
                    <ul>
                        <ul class="block px-4 py-2 text-teal-800">Proposals
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
                        <ul class="block px-4 py-2 text-teal-800">People
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
                            <li class="text-gray-900 hover:text-teal-800 font-normal">Proposers</li>
                        </ul>
                        <ul class="block px-4 py-2 text-teal-800">Charts
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
                        <ul class="block px-4 py-2 text-teal-800">Tools
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
                            <li class="text-gray-900 hover:text-teal-800 font-normal">Check MY Vote</li>
                        </ul>
                    </ul>
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