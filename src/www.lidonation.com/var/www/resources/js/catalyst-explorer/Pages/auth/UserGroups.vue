<template>
    <header-component titleName0="My Catalyst" titleName1="Groups" subTitle=""/>

    <section class="py-16 bg-primary-20">
        <div class="container">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="py-6 px-2 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav />
                </aside>

                <div class="space-y-6 sm:px-6 lg:col-span-9 xl:col-span-10">
                    <div class="">
                        <div class="bg-white p-6 rounded-sm mb-6">
                            <h2 class="leading-6 text-slate-900">My Groups</h2>
                        </div>
                        <div class="flex flex-col gap-8">
                            <UserGroupCard v-for="group in groups?.data" :group="group" />

                            <div class="text-center rounded-sm border border-slate-400 border-dashed p-8">
                                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-slate-900">
                                    Add a Group
                                </h3>
                                <p class="mt-1 text-md text-slate-500">
                                    Is this project part of a team or company,
                                    create a profile to feature on the groups page.
                                </p>
                                <div class="mt-6">
                                    <button type="button" class="inline-flex items-center rounded-sm border border-transparent bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                        <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                                        Coming Soon
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import UserNav from "./UserNav.vue";
import UserGroupCard from "./UserGroupCard.vue";
import Group from "../../models/group";
import { PlusIcon } from '@heroicons/vue/20/solid'


const props = withDefaults(
    defineProps<{
        locale: string,
        groups: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Group[]
        };
    }>(), {});


</script>
