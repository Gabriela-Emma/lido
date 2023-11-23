<template>
    <div ref="target">
        <ul>
            <li class="flow-root menu-item">
                <a @click="openMenu = !openMenu"
                   class="px-1 py-3 font-semibold text-white menu-link hover:text-teal-500" href="#">
                    More
                    <ChevronDownIcon class="inline-block w-5 h-5"/>
                </a>
            </li>
        </ul>
        <teleport to="header">
            <transition enter-from-class="opacity-0 scale-95">
                <div v-show="openMenu"
                     class="fixed left-1/2 -translate-x-1/2 w-[1250px] h-[200px] mt-12 font-semibold rounded-sm p-6 shadow-md bg-white">
                    <ul class="flex flex-row gap-28 text-lg">
                        <li>
                            <span class="text-slate-700 text-xl">
                                Proposals
                            </span>
                            <ul class="block">
                                <li>
                                    <Link
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :class="{ 'text-teal-600': $page.component.startsWith('Proposals') }"
                                        :href="route('catalyst-explorer.proposals')">
                                        {{ $t('All Proposals') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :class="{ 'text-teal-600': $page.component.startsWith('Funds') }"
                                        :href="route('catalyst-explorer.funds.index')">
                                        {{ $t('Funds') }}
                                    </Link>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <span class="text-slate-700 text-xl">
                                People
                            </span>
                            <ul class="block">
                                <li>
                                    <Link
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :class="{ 'text-teal-600': $page.component.startsWith('Groups') }"
                                        :href="route('catalyst-explorer.groups')">
                                        {{ $t('Groups') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :class="{ 'text-teal-600': $page.component.startsWith('DReps') }"
                                        :href="route('catalyst-explorer.dReps.index')">
                                        {{ $t('dReps') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :class="{ 'text-teal-600': $page.component.startsWith('People') }"
                                        :href="route('catalyst-explorer.people.index')">
                                        {{ $t('Proposers') }}
                                    </Link>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <span class="text-slate-700 text-xl">Charts</span>
                            <ul class="block">
                                <li>
                                    <a
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :class="{ 'text-teal-600': $page.component.startsWith('Charts') }"
                                        :href="route('catalyst-explorer.charts')">
                                        {{ $t('Catalyst by the Numbers') }}
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :href="route('projectCatalyst.votes.ccv4')">
                                        {{ $t('CCV4 Votes') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span class="text-slate-700 text-xl">Tools</span>
                            <ul class="block">
                                <li>
                                    <Link
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :class="{ 'text-teal-600': $page.component.startsWith('VoterTool') }"
                                        :href="route('catalyst-explorer.voter-tool')">
                                        {{ $t('Voter Tool') }}
                                    </Link>
                                </li>
                                <li>
                                    <a
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :href="route('catalyst-explorer.registrations')"
                                        :class="{ 'text-teal-600': $page.component.startsWith('Registrations') }">
                                        {{ $t('Check my registration') }}
                                    </a>
                                </li>
                                <li>
                                    <Link
                                        class="text-gray-900 menu-link font-normal hover:text-teal-800"
                                        :class="{ 'text-teal-600': $page.component.startsWith('Registrations') }"
                                        :href="route('catalyst-explorer.registrations')">
                                        {{ $t('Check my vote') }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </transition>
        </teleport>
    </div>
</template>
<script lang="ts" setup>
import {inject, ref} from "vue";
import route from "ziggy-js";
import {Link} from '@inertiajs/vue3';
import {onClickOutside} from '@vueuse/core';
import {ChevronDownIcon} from "@heroicons/vue/20/solid";

const $utils: any = inject('$utils');

let openMenu = ref(false);

const target = ref(null)

onClickOutside(target, (event: any) => openMenu.value = false)

</script>
