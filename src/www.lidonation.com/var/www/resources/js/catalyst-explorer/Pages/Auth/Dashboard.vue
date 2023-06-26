<template>
    <header-component titleName0="My Catalyst" titleName1="Dashboard" subTitle=""/>

    <section class="py-16 bg-primary-20">
        <div class="container">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="px-2 py-6 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav/>
                </aside>

                <div class="space-y-6 bg-white sm:px-6 lg:col-span-9 xl:col-span-10 lg:px-0">
                    <section>
                        <div
                            class="overflow-hidden bg-gray-200 divide-y divide-gray-200 rounded-lg shadow sm:grid sm:grid-cols-2 sm:gap-px sm:divide-y-0">
                            <div v-for="(action, actionIdx) in actions" :key="action.title"
                                 :class="[actionIdx === 0 ? 'rounded-tl-lg rounded-tr-lg sm:rounded-tr-none' : '', actionIdx === 1 ? 'sm:rounded-tr-lg' : '', actionIdx === actions.length - 2 ? 'sm:rounded-bl-lg' : '', actionIdx === actions.length - 1 ? 'rounded-bl-lg rounded-br-lg sm:rounded-bl-none' : '', 'relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500']">
                                <div>
                                    <div
                                        :class="[action.iconBackground, action.iconForeground, 'rounded-lg inline-flex p-3 ring-4 ring-white']">
                                        <component :is="action.icon" class="w-6 h-6" aria-hidden="true"/>
                                    </div>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-base font-semibold leading-6 text-gray-900">
                                        <Link :href="$utils.localizeRoute(action.href)" class="focus:outline-none">
                                            <!-- Extend touch target to entire panel -->
                                            <span class="absolute inset-0" aria-hidden="true"/>
                                            {{ $t(action.title) }}
                                        </Link>
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">{{$t(action?.excerpt)}}</p>
                                </div>
                                <div
                                    class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400"
                                    aria-hidden="true">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import UserNav from "./UserNav.vue";
import {
    AcademicCapIcon,
    BanknotesIcon,
    CheckBadgeIcon,
    ClockIcon,
    ReceiptRefundIcon,
    UsersIcon,
} from '@heroicons/vue/24/outline';
import {inject} from "vue";
const $utils: any = inject('$utils');

const actions = [
    {
        title: 'Profiles',
        excerpt: 'Manage your lidonation account information and all of the Catalyst Profiles you have claimed. To manage and claim more profiles, visit the specific user profile page.',
        href: 'catalyst-explorer/my/profiles',
        icon: UsersIcon,
        iconForeground: 'text-teal-700',
        iconBackground: 'bg-teal-50',
    },
    {
        title: 'Proposals',
        excerpt: 'Manage your proposal: Add a git repo, or youtube channel. Access required reporting links (monthly reports, close out report, etc...). ',
        href: 'catalyst-explorer/my/proposals',
        icon: CheckBadgeIcon,
        iconForeground: 'text-purple-700',
        iconBackground: 'bg-purple-50',
    },
    // {
    //     title: 'Schedule a one-on-one',
    //     href: '#',
    //     icon: UsersIcon,
    //     iconForeground: 'text-sky-700',
    //     iconBackground: 'bg-sky-50',
    // },
    {
        title: 'Groups',
        excerpt: 'If your proposals are part of a group or company, add group information and manage team members.',
        href: 'catalyst-explorer/my/groups',
        icon: BanknotesIcon,
        iconForeground: 'text-yellow-700',
        iconBackground: 'bg-yellow-50',
    },
    // {
    //     title: 'Submit an expense',
    //     href: '#',
    //     icon: ReceiptRefundIcon,
    //     iconForeground: 'text-rose-700',
    //     iconBackground: 'bg-rose-50',
    // },
    {
        title: 'Coming soon',
        excerpt: 'more coming soon. send us your feedback if you have any!',
        href: 'catalyst-explorer/my/groups',
        icon: AcademicCapIcon,
        iconForeground: 'text-indigo-700',
        iconBackground: 'bg-indigo-50',
    },
]

</script>
