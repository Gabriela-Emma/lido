<template>
    <Modal position="sidebar">
        <div class="pt-28 relative">
            <header class="bg-teal-700 text-white py-8 px-4 w-full sticky top-28">
                <div class="flex items-center justify-between relative">
                    <DialogTitle class="text-lg xl:text-xl 2xl:text-2xl font-medium text-white">
                        {{
                            proposal.title
                        }}
                    </DialogTitle>
                    <div class="flex h-7 items-center absolute -right-1 -top-1">
                        <button type="button"
                                class="rounded-sm bg-teal-900 text-teal-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                                @click="open = false">
                            <span class="sr-only">Close panel</span>
                            <XMarkIcon class="h-6 w-6" aria-hidden="true"/>
                        </button>
                    </div>
                </div>

                <dl class="flex flex-row gap-6 w-full text-sm w-full">
                    <div class="flex gap-2">
                        <dt class="text-slate-100">
                            {{ $t('Budget') }}
                        </dt>
                        <dd class="font-semibold">
                            {{ $filters.currency(proposal.amount_requested) }}
                        </dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="text-slate-100">
                            {{ $t('Distributed') }}
                        </dt>
                        <dd class="font-semibold">
                            {{ $filters.currency(proposal.amount_received) }}
                        </dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="text-slate-100">
                            {{ $t('Remaining') }}
                        </dt>
                        <dd class="font-semibold">
                            {{ $filters.currency(proposal.amount_requested - proposal.amount_received) }}
                        </dd>
                    </div>
                </dl>
            </header>

            <div class="shadow-xl">
                <div v-if="!currAction"
                     class="divide-y divide-gray-200 overflow-hidden bg-gray-200  sm:grid sm:grid-cols-2 sm:gap-px sm:divide-y-0">
                    <div v-for="(action, actionIdx) in actions" :key="action.title"
                         :class="[actionIdx === 0 ? 'rounded-tl-sm rounded-tr-sm sm:rounded-tr-none' : '', actionIdx === 1 ? 'sm:rounded-tr-sm' : '', actionIdx === actions.length - 2 ? 'sm:rounded-bl-sm' : '', actionIdx === actions.length - 1 ? 'rounded-bl-md rounded-br-sm sm:rounded-bl-none' : '', 'relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-teal-500']">
                        <div>
                        <span
                            :class="[action.iconBackground, action.iconForeground, 'rounded-md inline-flex p-3 ring-4 ring-white']">
                          <component :is="action.icon" class="h-6 w-6" aria-hidden="true"/>
                        </span>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-md font-medium">
                                <a :href="action['href']" class="focus:outline-none" target="_blank" v-if="action['href']">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"/>
                                    {{ action.title }}
                                </a>
                                <a href="#" @click.prevent="currAction = action.handler" class="focus:outline-none"
                                   v-else-if="action.handler">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"/>
                                    {{ action.title }}
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 break-words">
                                {{ action.excerpt }}
                            </p>
                        </div>
                        <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                              aria-hidden="true">
                         <component :is="action.hint || ArrowUpRightIcon" class="h-6 w-6" aria-hidden="true"/>
                    </span>
                    </div>
                </div>

                <div v-if="currAction === 'git'">
                    <ProposalAddGitRepo :proposal="proposal" @cancelled="currAction = null"/>
                </div>

                <div class="flex h-full flex-col divide-y divide-gray-200 bg-white" v-if="currAction === 'reports'">
                    <div class="p-4 w-full" v-if="proposal.meta_data?.iog_hash">
                        {{ $t('Links to official required reporting and evidence submission to the community') }}.
                        {{ $t('Your Project ID is') }}:   <b> {{proposal.meta_data?.iog_hash}}</b>
                    </div>
                    <ul role="list" class="divide-y divide-gray-200">
                        <li v-for="iogAction in iogReportActions" class="px-4">
                            <a :href="iogAction?.href" class="flex w-full items-start py-4 h-full" target="_blank" v-if="iogAction.href">
                                <div class="h-10 w-10 rounded-full">
                                    <component :is="iogAction.icon" class="h-10 w-10" aria-hidden="true"/>
                                </div>
                                <div class="ml-3">
                                    <div class="text-lg text-gray-600">{{ iogAction.title }}</div>
                                    <p class="text-sm font-medium text-gray-500">{{ iogAction.excerpt }}</p>
                                </div>
                                <div class="w-8 ml-auto flex h-full flex items-center justify-end">
                                    <ArrowUpRightIcon class="w-4 h-4" />
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="flex gap-4 justify-center items-center p-4 w-full">
                        <button type="submit" @click="currAction = null"
                                class="inline-flex gap-2 justify-center rounded-sm border border-transparent bg-slate-300 py-2 px-4 text-sm font-medium text-white shadow-xs hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <ArrowUturnLeftIcon class="w-4 h-4"/>
                            <span>{{ $t('Back') }}}}</span>
                        </button>
                    </div>
                </div>

                <div class="flex h-full flex-col divide-y divide-gray-200 bg-white" v-if="currAction === 'youtube'">
                    <h2 class="text-center py-4">{{ $t('Feature coming soon') }}</h2>
                    <div class="flex gap-4 justify-center items-center p-4 w-full">
                        <button type="submit" @click="currAction = null"
                                class="inline-flex gap-2 justify-center rounded-sm border border-transparent bg-slate-300 py-2 px-4 text-sm font-medium text-white shadow-xs hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <ArrowUturnLeftIcon class="w-4 h-4"/>
                            <span>{{ $t('Back') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";
import Modal from "../../Shared/Components/Modal.vue";
import {XMarkIcon, ArrowUturnLeftIcon} from '@heroicons/vue/24/outline'
import {
    PlusIcon,
    ArrowUpRightIcon,
    AcademicCapIcon,
    BuildingOfficeIcon, VideoCameraIcon
} from '@heroicons/vue/20/solid'
import {
    DocumentCheckIcon,
    CommandLineIcon,
    NewspaperIcon,
} from '@heroicons/vue/24/outline';
import {DialogTitle} from "@headlessui/vue";
import {computed, ref} from "vue";
import ProposalAddGitRepo from "../../modules/proposals/ProposalAddGitRepo.vue";

const props = withDefaults(
    defineProps<{
        locale?: string,
        proposal: Proposal,
    }>(), {});
const gitRepo = computed(() => {
    if (props.proposal?.repos?.length === 0) {
        return null
    }
    if (typeof props.proposal?.repos[0] === 'undefined') {
        return null;
    }
    return props.proposal?.repos[0] || null
});
let currAction = ref(null);

const actions = [
    {
        title: 'Git Repo' + (!!gitRepo?.value ? ' - successfully added!' : ''),
        excerpt: !!gitRepo?.value ? `Tracking ${gitRepo?.value?.url}:${gitRepo?.value?.tracked_branch}` : 'Stream git commit messages to the community by adding a public or private repository.',
        handler: 'git',
        icon: CommandLineIcon,
        hint: PlusIcon,
        iconForeground: 'text-teal-700',
        iconBackground: 'bg-teal-50',
    },
    // {
    //     title: 'Community Links',
    //     excerpt: 'Add community links for your project. Facebook, twitter, discord, website, etc.',
    //     handler: 'links',
    //     icon: ShareIcon,
    //     hint: PlusIcon,
    //     iconForeground: 'text-purple-700',
    //     iconBackground: 'bg-purple-50',
    // },
    {
        title: 'Official (IOG) Funding Reports',
        excerpt: 'Official google forms and reports you need to submit to receive funding and fulfill community reporting obligations.',
        handler: 'reports',
        hint: PlusIcon,
        icon: DocumentCheckIcon,
        iconForeground: 'text-yellow-700',
        iconBackground: 'bg-yellow-50',
    },
    {
        title: 'Youtube Channel - coming soon',
        excerpt: 'Do you have a dedicated YouTube Channel for this project?',
        handler: 'youtube',
        icon: VideoCameraIcon,
        hint: PlusIcon,
        iconForeground: 'text-pink-700',
        iconBackground: 'bg-pink-50',
    },
];

const iogReportActions = [
    {
        title: 'Submit Monthly Report',
        excerpt: 'Must be submitted by 20th to receive funding.',
        href: 'https://docs.google.com/forms/d/e/1FAIpQLSdS6wAzKdSR1mAwCHP0EkVqOVlszvU5E45B0G2-0HmjO6qgbA/viewform',
        icon: NewspaperIcon,
        iconForeground: 'text-yellow-700',
        iconBackground: 'bg-yellow-50',
    },
    {
        title: 'Proof of Accomplishment/Milestone',
        excerpt: 'Did you have to submit milestone for your project? Must submit a proof of accomplishment in addition to your monthly report to receive final payment for your milestone budget',
        href: 'https://docs.google.com/forms/d/e/1FAIpQLSfbvfiIKsK6sXxRnUjBn5nCIdwtIGhOGMgf8pmmnTkH7u9lGA/viewform',
        icon: AcademicCapIcon,
        iconForeground: 'text-sky-700',
        iconBackground: 'bg-sky-50',
    },
    {
        title: 'Close Project',
        excerpt: 'Project completed? Need to submit closeout report for final payment.',
        href: 'https://drive.google.com/drive/u/1/folders/1SSW2afDX5w30aTZYF3p7o7rLUep7v0TJ',
        icon: BuildingOfficeIcon,
        iconForeground: 'text-sky-700',
        iconBackground: 'bg-sky-50',
    }
];

</script>
