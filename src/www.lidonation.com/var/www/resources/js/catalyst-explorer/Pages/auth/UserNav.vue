<template>
    <nav class="space-y-1">
        <!-- Current: "bg-slate-50 text-teal-700 hover:text-teal-700 hover:bg-white", Default: "text-slate-900 hover:text-slate-900 hover:bg-slate-50" -->
        <Link :href="$utils.localizeRoute('catalyst-explorer/my/dashboard')" aria-current="page"
              :class="{
                'bg-slate-50 text-teal-700 hover:text-teal-700 hover:bg-white': $page.component.endsWith('Dashboard'),
                'text-slate-900 hover:text-slate-900 hover:bg-slate-50': !$page.component.endsWith('Dashboard'),
              }"
              class="group rounded-sm px-3 py-2 flex items-center text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor"
                 class="text-teal-500 group-hover:text-teal-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            <span class="truncate">Dashboard</span>
        </Link>
        <Link :href="$utils.localizeRoute('catalyst-explorer/my/profile')" aria-current="page"
              :class="{
                'bg-slate-50 text-teal-700 hover:text-teal-700 hover:bg-white': $page.component.endsWith('Profile'),
                'text-slate-900 hover:text-slate-900 hover:bg-slate-50': !$page.component.endsWith('Profile'),
              }"
              class="group rounded-sm px-3 py-2 flex items-center text-sm font-medium">
            <svg class="text-teal-500 group-hover:text-teal-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="truncate">Profile</span>
        </Link>

        <Link :href="$utils.localizeRoute('catalyst-explorer/my/proposals')"
              :class="{
                'bg-slate-50 text-teal-700 hover:text-teal-700 hover:bg-white': $page.component.endsWith('UserProposals'),
                'text-slate-900 hover:text-slate-900 hover:bg-slate-50': !$page.component.endsWith('UserProposals'),
              }"
              class="group rounded-sm px-3 py-2 flex items-center text-sm font-medium">
            <!-- Heroicon name: outline/squares-plus -->
            <svg class="text-slate-400 group-hover:text-slate-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z"/>
            </svg>
            <span class="truncate">Proposals</span>
        </Link>

        <Link :href="$utils.localizeRoute('catalyst-explorer/my/groups')"
              :class="{
                'bg-slate-50 text-teal-700 hover:text-teal-700 hover:bg-white': $page.component.endsWith('UserGroups'),
                'text-slate-900 hover:text-slate-900 hover:bg-slate-50': !$page.component.endsWith('UserGroups'),
              }"
              class="group rounded-sm px-3 py-2 flex items-center text-sm font-medium">
            <!-- Heroicon name: outline/user-group -->
            <svg class="text-slate-400 group-hover:text-slate-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
            </svg>
            <span class="truncate">Groups</span>
        </Link>
    </nav>
</template>

<script lang="ts">
import {Link} from '@inertiajs/vue3';

export default {
    components: {Link},

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
