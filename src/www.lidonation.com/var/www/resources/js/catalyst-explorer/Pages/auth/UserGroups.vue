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
                        <div class="flex flex-col gap-6">
                            <UserGroupCard v-for="group in groups?.data" :group="group" />
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
