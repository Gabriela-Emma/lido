<template>
    <div class="top-0 z-30 bg-teal-600 border-b border-teal-400 md:border-teal-light-300 page-nav">
        <div class='container relative'>
            <div class="flex flex-row justify-between gap-4 flex-nowrap">
                <nav class="flex max-w-[70%] overflow-x-auto" aria-label="Breadcrumb">
                    <ol role="list" class="flex space-x-0">
                        <li class="flex">
                            <div class="flex items-center">
                                <Link :href="route('catalyst-explorer.home')"
                                      class="flex flex-row items-center text-white hover:text-yellow-400">
                                    <HomeIcon class="w-6 h-6" aria-hidden="true" />
                                    <span class="ml-1 text-xs font-medium sr-only">
                                        {{ $t('home') }}
                                    </span>
                                </Link>
                            </div>
                        </li>
                        <li v-show="(crumbsLength >= 1)"
                            v-for="(crumb, key) in crumbs"
                            class="flex">
                            <div v-if="!(crumbsLength-1 == key)" class="flex items-center">
                                <svg class="flex-shrink-0 w-6 h-full text-teal-200" viewBox="0 0 24 44"
                                     preserveAspectRatio="none" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"/>
                                </svg>
                                <a :href="crumb.link" v-if="crumb.external === true"
                                   class="inline-block ml-2 text-xs font-medium text-white hover:text-yellow-400 whitespace-nowrap">
                                    {{ $t(crumb.label) }}
                                </a>
                                <Link :href="crumb.link" v-else
                                      class="inline-block ml-2 text-xs font-medium text-white hover:text-yellow-400 whitespace-nowrap">
                                    {{ $t(crumb.label) }}
                                </Link>
                            </div>
                            <div v-if="(crumbsLength-1 == key)" class="flex items-center">
                                <svg class="flex-shrink-0 w-6 h-full text-teal-200" viewBox="0 0 24 44"
                                     preserveAspectRatio="none" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"/>
                                </svg>
                                <span
                                    class="inline-block ml-2 text-xs font-medium text-teal-light-100 whitespace-nowrap">
                                    {{ $t(crumb.label) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <nav class="relative hidden xl:inline-flex">
                    <ul
                        class="flex flex-row items-center justify-end h-full gap-2 py-2 overflow-x-auto text-xs md:text-sm flex-nowrap">
                        <li v-for="link in menulinks" :key="link.name" class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                :class="{ 'text-yellow-500': $page.component.startsWith(link.name) }"
                                :href="route(link.route)">
                                {{ $t(link.name) }}          
                            </Link>
                        </li>
                        
                        <MenuDropdown />
                        <!--                        <li class="flow-root menu-item" x-data="bookmarksMenuLink">-->
                        <!--                            <Link href="/catalyst-explorer/bookmarks" class="inline-flex items-center menu-link group">-->
                        <!--                            <span class="relative z-0 inline-flex rounded-md shadow-sm" x-cloak>-->
                        <!--                                <button type="button"-->
                        <!--                                    class="relative inline-flex items-center px-2 py-1 text-sm font-medium text-white bg-pink-700 border border-pink-300 rounded-l-sm group-hover:bg-pink-600 focus:z-10 focus:outline-none">-->
                        <!--                                    <svg x-show="getBookmarkCount() > 0" class="w-5 h-5 mr-2 -ml-1 text-white"-->
                        <!--                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"-->
                        <!--                                        aria-hidden="true">-->
                        <!--                                        <path x-show="getBookmarkCount() > 0"-->
                        <!--                                            d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />-->
                        <!--                                    </svg>-->
                        <!--                                    <svg x-show="getBookmarkCount() === 0" xmlns="http://www.w3.org/2000/svg"-->
                        <!--                                        class="w-5 h-5 mr-2 -ml-1 text-white" fill="none" viewBox="0 0 24 24"-->
                        <!--                                        stroke="currentColor" stroke-width="2">-->
                        <!--                                        <path stroke-linecap="round" stroke-linejoin="round"-->
                        <!--                                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />-->
                        <!--                                    </svg>-->
                        <!--                                    <span class="hidden md:inline-block">Bookmarks</span>-->
                        <!--                                </button>-->
                        <!--                                <button type="button"-->
                        <!--                                    class="relative inline-flex items-center px-2 py-1 -ml-px text-sm font-medium text-white bg-white bg-pink-700 border border-pink-300 rounded-r-sm group-hover:bg-pink-600 focus:z-10 focus:outline-none">-->
                        <!--                                    <span class="min-w-[1.45rem]" x-text="getBookmarkCount()"></span>-->
                        <!--                                </button>-->
                        <!--                            </span>-->
                        <!--                            </Link>-->
                        <!--                        </li>-->
                    </ul>
                </nav>

                <div class="mt-2 xl:hidden">
                    <Bars3Icon v-show="toggle == false" @click="toggle = !toggle" class="w-6 h-6 text-yellow-400"
                               aria-hidden="true"/>
                    <XMarkIcon v-show="toggle == true" @click="toggle = false" class="w-6 h-6 text-yellow-400"
                               aria-hidden="true"/>
                    <div v-show="toggle"
                         ref="target"
                         class="flex flex-col absolute right-0 mr-3.5 w-36 bg-white rounded-sm shadow-md overflow-hidden">
                        <ul
                            class="flex flex-col items-start justify-end gap-2 py-2 overflow-x-auto text-xs divide-y divide-teal-300 md:text-sm flex-nowrap">
                            <li class="flow-root menu-item p-1.5 w-full items-center">
                                <Link
                                    class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                    @click.stop="(toggle = false)"
                                    :class="{ 'text-yellow-500': $page.component.startsWith('Proposals') }"
                                    :href="$utils.localizeRoute('catalyst-explorer/proposals')">
                                    {{ $t('Proposals') }}
                                </Link>
                            </li>
                            <li class="flow-root menu-item p-1.5 w-full items center">
                                <Link
                                    class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                    @click.stop="(toggle = false)"
                                    :class="{ 'text-yellow-500': $page.component.startsWith('People') }"
                                    :href="$utils.localizeRoute('catalyst-explorer/people')">
                                    {{ $t('People') }}
                                </Link>
                            </li>
                            <li class="flow-root menu-item p-1.5 w-full items center">
                                <Link
                                    class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                    @click.stop="(toggle = false)"
                                    :class="{ 'text-yellow-500': $page.component.startsWith('Groups') }"
                                    :href="$utils.localizeRoute('catalyst-explorer/groups')">
                                    {{ $t('Groups') }}
                                </Link>
                            </li>
                            <li class="flow-root menu-item p-1.5 w-full items center">
                                <Link class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                      @click.stop="(toggle = false)"
                                      :class="{ 'text-yellow-500': $page.component.startsWith('Reports')}"
                                      :href="$utils.localizeRoute('catalyst-explorer/reports')">
                                    {{ $t('Monthly Reports') }}
                                </Link>
                            </li>
                            <li class="flow-root menu-item p-1.5 w-full items center">
                                <Link class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                      @click.stop="(toggle = false)"
                                      :class="{ 'text-yellow-500': $page.component.endsWith('Assessments')}"
                                      :href="$utils.localizeRoute('catalyst-explorer/assessments')">
                                    {{ $t('PAs') }}
                                </Link>
                            </li>
                            <li class="flow-root menu-item p-1.5 w-full items-center">
                                <a
                                    class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                    @click.stop="(toggle = false)"
                                    :class="{ 'text-yellow-500': $page.component.startsWith('Charts') }"
                                    :href="$utils.localizeRoute('catalyst-explorer/charts')">
                                    {{ $t('Charts') }}
                                </a>
                            </li>
                            <li class="flow-root menu-item p-1.5 w-full items-center">
                                <a class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                   @click.stop="(toggle = false)"
                                   href="/project-catalyst/votes/ccv4">
                                    {{ $t('CCV4 Votes') }}
                                </a>
                            </li>
                            <li class="flow-root menu-item p-1.5 w-full items-center">
                                <a class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                   @click.stop="(toggle = false)"
                                   href="/catalyst-explorer/api">
                                    {{ $t('Api') }}
                                </a>
                            </li>
                            <li class="flow-root menu-item p-1.5 w-full items-center">
                                <Link
                                    class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                    @click.stop="(toggle = false)"
                                    :class="{ 'text-yellow-500': $page.component.startsWith('Funds') }"
                                    :href="route('catalyst-explorer.funds.index')">
                                    {{ $t('Funds') }}
                                </Link>
                            </li>

                            <li class="flow-root menu-item p-1.5 w-full items-center">
                                <Link
                                    class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                    @click.stop="(toggle = false)"
                                    :class="{ 'text-yellow-500': $page.component.startsWith('Bookmark') }"
                                    :href="$utils.localizeRoute('catalyst-explorer/bookmarks')">
                                    {{ $t('Bookmarks') }}
                                </Link>
                            </li>

                            <li class="flow-root menu-item p-1.5 w-full items-center">
                                <Link
                                    class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                    @click.stop="(toggle = false)"
                                    :class="{ 'text-yellow-500': $page.component.startsWith('VoterTool') }"
                                    :href="route('catalyst-explorer.voter-tool')">
                                    {{ $t('Voter Tool') }}
                                </Link>
                            </li>
                            <li class="flow-root menu-item p-1.5 w-full items-center">
                                <Link
                                    class="px-1 py-3 text-teal-600 menu-link hover:text-yellow-500"
                                    @click.stop="(toggle = false)"
                                    :class="{ 'text-yellow-500': $page.component.startsWith('DReps') }"
                                    :href="route('catalyst-explorer.dReps.index')">
                                    {{ $t('dReps') }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import {computed, inject, Ref, ref} from "vue";
import {Bars3Icon, XMarkIcon, HomeIcon} from '@heroicons/vue/20/solid';
import {onClickOutside} from '@vueuse/core';
import route from "ziggy-js";
import MenuDropdown from "../Navigation/MenuDropdown.vue"
import { menulinkStore } from '../../stores/menu-links-store';

const { menulinks } = menulinkStore();

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});
let crumbsLength = computed<number>(() => props.crumbs?.length);

let toggle: Ref<boolean> = ref(false);

const target = ref(null)

onClickOutside(target, (event: any) => toggle.value = false)

</script>
