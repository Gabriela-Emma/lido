<template>
    <div class="sticky top-0 z-30 border-b border-labs-red-light md:border-labs-red-light bg-labs-red page-nav">
        <div class='container relative'>
            <div class="flex flex-row justify-between flex-nowrap gap-4">
                <nav></nav>
                <nav class="relative hidden xl:inline-flex">
                    <ul
                        class="flex flex-row items-center justify-end gap-2 py-2 text-xs md:text-sm flex-nowrap overflow-x-auto h-full">
                        <li class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Dashboard') }"
                                :href="$utils.localizeRoute('earn/learn/proposals')">
                                {{ $t('Dashboard') }}
                            </Link>
                        </li>
                        <li class="flow-root menu-item">
                            <Link class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                  :class="{ 'text-yellow-500': $page.component.startsWith('Reports')}"
                                  :href="$utils.localizeRoute('earn/learn/reports')">
                                {{ $t('Curriculums') }}
                            </Link>
                        </li>
                        <li class="flow-root menu-item">
                            <Link class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                  :class="{ 'text-yellow-500': $page.component.endsWith('Reward')}"
                                  :href="$utils.localizeRoute('earn/learn/assessments')">
                                {{ $t('Reward') }}
                            </Link>
                        </li>
                        <li class="flow-root menu-item">
                            <Link
                                class="px-1 py-3 text-white menu-link hover:text-yellow-500"
                                :class="{ 'text-yellow-500': $page.component.startsWith('Profile') }"
                                :href="$utils.localizeRoute('earn/learn/profile')">
                                {{ $t('Profile') }}
                            </Link>
                        </li>
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
