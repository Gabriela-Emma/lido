<template>
    <div class="sticky top-0 z-30 border-b border-teal-700 md:border-teal-700 bg-teal-800 page-nav">
        <div class='container relative'>
            <div class="flex flex-row justify-between flex-nowrap gap-4">
                <nav class="flex max-w-[70%] overflow-x-auto" aria-label="Breadcrumb">
                    <ol role="list" class="flex space-x-0">
<!--                        <li class="flex">-->
<!--                            <div class="flex items-center">-->
<!--                                <Link href="/en/earn/learn"-->
<!--                                      class="text-white flex flex-row items-center hover:text-yellow-400">-->
<!--                                    <AcademicCapIcon class="h-5 w-5" aria="true"/>-->
<!--                                    <span class="ml-1 text-xs font-medium sr-only">-->
<!--                                        {{ $t('dashboard') }}-->
<!--                                    </span>-->
<!--                                </Link>-->
<!--                            </div>-->
<!--                        </li>-->
                        <li v-show="(crumbsLength >= 1)"
                            v-for="(crumb, key) in crumbs"
                            class="flex">
                            <div v-if="!(crumbsLength - 1 === key)" class="flex items-center">
                                <svg class="flex-shrink-0 w-6 h-full text-teal-400" viewBox="0 0 24 44"
                                     preserveAspectRatio="none" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"/>
                                </svg>
                                <Link :href=crumb.link
                                      class="ml-2 text-xs inline-block font-medium text-white hover:text-yellow-400 whitespace-nowrap">
                                    {{ $t(crumb.name) }}
                                </Link>
                            </div>
                            <div v-if="(crumbsLength - 1 === key)" class="flex items-center">
                                <svg class="flex-shrink-0 w-6 h-full text-teal-400" viewBox="0 0 24 44"
                                     preserveAspectRatio="none" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z"/>
                                </svg>
                                <span
                                    class="ml-2 text-xs font-medium inline-block text-teal-light-100 whitespace-nowrap">
                                    {{ $t(crumb.name) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <nav class="relative hidden lg:inline-flex">
                    <ul
                        class="flex flex-row items-center justify-end gap-2 py-2 text-xs md:text-sm flex-nowrap overflow-x-auto h-full">
                        <li class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 menu-link hover:text-black"
                                :class="[$page.component.endsWith('Learn') ? 'text-black' : 'text-white']"
                                :href="$utils.localizeRoute('earn')">
                                {{ $t('Ways To Earn') }}
                            </Link>
                        </li>
                        <li class="flow-root menu-item">
                            <a class="px-1 py-3 menu-link hover:text-black"
                                  :class="[$page.component.startsWith('Rewards') ? 'text-black' : 'text-white']"
                                  :href="$utils.localizeRoute('rewards')">
                                {{ $t('My Rewards') }}
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>

    </div>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import {computed, inject} from "vue";
import {AcademicCapIcon} from '@heroicons/vue/24/outline';

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});
let crumbsLength = computed<number>(() => props.crumbs?.length);
</script>
