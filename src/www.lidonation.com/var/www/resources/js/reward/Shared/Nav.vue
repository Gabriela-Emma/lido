<template>
    <div class="sticky top-0 z-30 border-b border-teal-400 md:border-teal-light-300 bg-teal-600 page-nav" >
        <div class='container relative'>
            <div class="flex flex-row justify-between flex-nowrap gap-4">
                <nav></nav>
                <nav class="relative hidden lg:inline-flex">
                    <ul
                        class="flex flex-row items-center justify-end gap-2 py-2 text-xs md:text-sm flex-nowrap overflow-x-auto h-full">
                        <!-- <li class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 menu-link hover:text-black"
                                :class="[$page.component.endsWith('Learn') ? 'text-black' : 'text-white']"
                                :href="$utils.localizeRoute('proposals')">
                                {{ $t('Catalyst Explorer') }}
                            </Link>
                        </li>
                        <li class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 menu-link hover:text-black"
                                :class="[$page.component.startsWith('Dashboard') ? 'text-black' : 'text-white']"
                                :href="$utils.localizeRoute('earn/learn')">
                                {{ $t('Learn') }}
                            </Link>
                        </li> -->
                        <!-- <li class="flow-root menu-item">
                            <Link class="px-1 py-3 menu-link hover:text-black"
                                  :class="[$page.component.startsWith('LearningModules') ? 'text-black' : 'text-white']"
                                  :href="$utils.localizeRoute('earn/learn')">
                                {{ $t('Modules') }}
                            </Link>
                        </li> -->
                        <!-- <li class="flow-root menu-item">
                            <Link class="px-1 py-3 menu-link hover:text-black"
                                  :class="[$page.component.startsWith('Rewards') ? 'text-black' : 'text-white']"
                                  :href="$utils.localizeRoute('rewards')">
                                {{ $t('Rewards') }}
                            </Link>
                        </li> -->
                        <!-- <li class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 menu-link hover:text-black"
                                :class="[$page.component.startsWith('Profile') ? 'text-black' : 'text-white']"
                                :href="$utils.localizeRoute('earn/learn')">
                                {{ $t('Learn') }}
                            </Link>
                        </li> -->
                    </ul>
                </nav>

            </div>
        </div>

    </div>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import {computed, inject} from "vue";

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});
let crumbsLength = computed<number>(() => props.crumbs?.length);
</script>
