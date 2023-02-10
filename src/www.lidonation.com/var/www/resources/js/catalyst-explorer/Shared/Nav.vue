<template>
    <div class="sticky top-0 z-30 border-b border-teal-400 md:border-teal-light-300 bg-teal-600 page-nav">
        <div class='container relative'>
            <div class="flex flex-row justify-between flex-nowrap gap-4">
                <nav class="flex max-w-[70%] overflow-x-auto" aria-label="Breadcrumb">
                    <ol role="list" class="flex space-x-0">
                        <li class="flex">
                            <div class="flex items-center">
                                <Link href="/en/catalyst-explorer/dashboard"
                                    class="text-white flex flex-row items-center hover:text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/>
                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/>
                                    </svg>
                                    <span class="ml-1 text-xs font-medium sr-only">
                                        dashboard
                                    </span>
                                </Link>
                            </div>
                        </li>
                        <li v-show="(crumbsLength >= 1)"
                            v-for="crumb, key in crumbs"
                            class="flex">
                                <div v-if="!(crumbsLength-1 == key)" class="flex items-center" >
                                    <svg class="flex-shrink-0 w-6 h-full text-teal-200" viewBox="0 0 24 44"
                                         preserveAspectRatio="none" fill="currentColor"
                                         xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"/>
                                    </svg>
                                        <Link :href=crumb.link
                                           class="ml-2 text-xs inline-block font-medium text-white hover:text-yellow-400 whitespace-nowrap">
                                            {{crumb.label}}
                                        </Link>
                                </div>
                                <div v-if="(crumbsLength-1 == key)" class="flex items-center">
                                    <svg class="flex-shrink-0 w-6 h-full text-teal-200" viewBox="0 0 24 44"
                                         preserveAspectRatio="none" fill="currentColor"
                                         xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"/>
                                    </svg>
                                        <span class="ml-2 text-xs font-medium inline-block text-teal-light-100 whitespace-nowrap">
                                            {{crumb.label}}
                                        </span>
                                </div>
                        </li>
                    </ol>
                </nav>

                <nav class="relative hidden xl:inline-flex">
                    <ul
                        class="flex flex-row items-center justify-end gap-2 py-2 text-xs md:text-sm flex-nowrap overflow-x-auto h-full">
                        <li class="flow-root menu-item">
                            <a class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                               href="/project-catalyst/votes/ccv4">
                                CCV4 Votes
                            </a>
                        </li>
                        <li class="flow-root menu-item">
                            <a class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                               href="/catalyst-explorer/api">
                                Api
                            </a>
                        </li>
                        <li class="flow-root menu-item">
                            <Link class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Reports')}"
                                href="/catalyst-explorer/reports">
                            Monthly Reports
                            </Link>
                        </li>
                        <li class="flow-root menu-item">
                            <a
                                class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Charts') }"
                                :href="$utils.localizeRoute('project-catalyst/dashboard')">
                            Charts
                            </a>
                        </li>
                        <li class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Funds') }"
                                href="/catalyst-explorer/funds">
                            Funds
                            </Link>
                        </li>
                        <li class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Proposals') }"
                                href="/catalyst-explorer/proposals">
                            Proposals
                            </Link>
                        </li>
                        <li class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                :class="{ 'text-yellow-500': $page.component.startsWith('People') }"
                                href="/catalyst-explorer/people">
                            People
                            </Link>
                        </li>
                        <li class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Groups') }"
                                href="/catalyst-explorer/groups">
                            Groups
                            </Link>
                        </li>
                        <li class="flow-root menu-item">
                            <a
                                class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                :class="{ 'text-yellow-500': $page.component.startsWith('VoterTool') }"
                                :href="$utils.localizeRoute('project-catalyst/voter-tool')">
                            Voter Tool
                            </a>
                        </li>
                        <li class="flow-root menu-item" x-data="bookmarksMenuLink">
                            <Link href="/catalyst-explorer/bookmarks" class="inline-flex items-center menu-link group">
                            <span class="relative z-0 inline-flex rounded-md shadow-sm" x-cloak>
                                <button type="button"
                                    class="relative inline-flex items-center px-2 py-1 text-sm font-medium text-white bg-pink-700 border border-pink-300 rounded-l-sm group-hover:bg-pink-600 focus:z-10 focus:outline-none">
                                    <svg x-show="getBookmarkCount() > 0" class="w-5 h-5 mr-2 -ml-1 text-white"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path x-show="getBookmarkCount() > 0"
                                            d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                    </svg>
                                    <svg x-show="getBookmarkCount() === 0" xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 mr-2 -ml-1 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                    <span class="hidden md:inline-block">Bookmarks</span>
                                </button>
                                <button type="button"
                                    class="relative inline-flex items-center px-2 py-1 -ml-px text-sm font-medium text-white bg-white bg-pink-700 border border-pink-300 rounded-r-sm group-hover:bg-pink-600 focus:z-10 focus:outline-none">
                                    <span class="min-w-[1.45rem]" x-text="getBookmarkCount()"></span>
                                </button>
                            </span>
                            </Link>
                        </li>

                    </ul>
                </nav>

            </div>
        </div>

    </div>
</template>

<script lang="ts">
import { Link } from '@inertiajs/vue3';

export default {
    components: { Link },

    props: {
        crumbs: Array
    },

    computed: {
        crumbsLength() {
            return this.crumbs.length;
        }
    }
}
</script>
