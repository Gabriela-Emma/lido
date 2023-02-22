<template>
    <Modal>
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
                            Budget
                        </dt>
                        <dd class="font-semibold">
                            {{ $filters.currency(proposal.amount_requested) }}
                        </dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="text-slate-100">
                            Distributed
                        </dt>
                        <dd class="font-semibold">
                            {{ $filters.currency(proposal.amount_received) }}
                        </dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="text-slate-100">
                            Remaining
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
                        Links to official required reporting and evidence submission to the community.
                        Your Project ID is:   <b> {{proposal.meta_data?.iog_hash}}</b>
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
                            <span>Back</span>
                        </button>
                    </div>
                </div>

                <div class="flex h-full flex-col divide-y divide-gray-200 bg-white" v-if="currAction === 'youtube'">
                    <h2 class="text-center py-4">Feature coming soon</h2>
                    <div class="flex gap-4 justify-center items-center p-4 w-full">
                        <button type="submit" @click="currAction = null"
                                class="inline-flex gap-2 justify-center rounded-sm border border-transparent bg-slate-300 py-2 px-4 text-sm font-medium text-white shadow-xs hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <ArrowUturnLeftIcon class="w-4 h-4"/>
                            <span>Back</span>
                        </button>
                    </div>
                </div>

                <form class="flex h-full flex-col divide-y divide-gray-200 bg-white" v-if="currAction === 'links'">
                    <div class="h-0 flex-1 overflow-y-auto">
                        <div class="flex flex-1 flex-col justify-between">
                            <div class="divide-y divide-gray-200 px-4 sm:px-6">
                                <div class="space-y-6 pt-6 pb-5">
                                    <div>
                                        <label for="project-name" class="block text-sm font-medium text-gray-900">Project
                                            name</label>
                                        <div class="mt-1">
                                            <input type="text" name="project-name" id="project-name"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"/>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="description"
                                               class="block text-sm font-medium text-gray-900">Description</label>
                                        <div class="mt-1">
                                        <textarea id="description" name="description" rows="4"
                                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"/>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Team Members</h3>
                                        <div class="mt-2">
                                            <div class="flex space-x-2">
                                                <a v-for="person in team" :key="person.email" :href="person.href"
                                                   class="rounded-full hover:opacity-75">
                                                    <img class="inline-block h-8 w-8 rounded-full"
                                                         :src="person.imageUrl"
                                                         :alt="person.name"/>
                                                </a>
                                                <button type="button"
                                                        class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full border-2 border-dashed border-gray-200 bg-white text-gray-400 hover:border-gray-300 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                                    <span class="sr-only">Add team member</span>
                                                    <PlusIcon class="h-5 w-5" aria-hidden="true"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <fieldset>
                                        <legend class="text-sm font-medium text-gray-900">Privacy</legend>
                                        <div class="mt-2 space-y-5">
                                            <div class="relative flex items-start">
                                                <div class="absolute flex h-5 items-center">
                                                    <input id="privacy-public" name="privacy"
                                                           aria-describedby="privacy-public-description" type="radio"
                                                           class="h-4 w-4 border-gray-300 text-teal-600 focus:ring-teal-500"
                                                           checked=""/>
                                                </div>
                                                <div class="pl-7 text-sm">
                                                    <label for="privacy-public" class="font-medium text-gray-900">Public
                                                        access</label>
                                                    <p id="privacy-public-description" class="text-gray-500">Everyone
                                                        with
                                                        the link will see this project.</p>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="relative flex items-start">
                                                    <div class="absolute flex h-5 items-center">
                                                        <input id="privacy-private-to-project" name="privacy"
                                                               aria-describedby="privacy-private-to-project-description"
                                                               type="radio"
                                                               class="h-4 w-4 border-gray-300 text-teal-600 focus:ring-teal-500"/>
                                                    </div>
                                                    <div class="pl-7 text-sm">
                                                        <label for="privacy-private-to-project"
                                                               class="font-medium text-gray-900">Private to project
                                                            members</label>
                                                        <p id="privacy-private-to-project-description"
                                                           class="text-gray-500">Only members of this project would be
                                                            able
                                                            to access.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="relative flex items-start">
                                                    <div class="absolute flex h-5 items-center">
                                                    <input id="privacy-private" name="privacy"
                                                                            aria-describedby="privacy-private-to-project-description"
                                                                            type="radio"
                                                                            class="h-4 w-4 border-gray-300 text-teal-600 focus:ring-teal-500"/>
                                                    </div>
                                                    <div class="pl-7 text-sm">
                                                        <label for="privacy-private" class="font-medium text-gray-900">Private
                                                            to you</label>
                                                        <p id="privacy-private-description" class="text-gray-500">You
                                                            are
                                                            the only one able to access this project.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="pt-4 pb-6">
                                    <div class="flex text-sm">
                                        <a href="#"
                                           class="group inline-flex items-center font-medium text-teal-600 hover:text-teal-900">
                                            <LinkIcon class="h-5 w-5 text-teal-500 group-hover:text-teal-900"
                                                      aria-hidden="true"/>
                                            <span class="ml-2">Copy link</span>
                                        </a>
                                    </div>
                                    <div class="mt-4 flex text-sm">
                                        <a href="#"
                                           class="group inline-flex items-center text-gray-500 hover:text-gray-900">
                                            <QuestionMarkCircleIcon
                                                class="h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                                aria-hidden="true"/>
                                            <span class="ml-2">Learn more about sharing</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4 justify-end items-center p-4">
                        <button type="submit" @click="currAction = null"
                                class="inline-flex justify-center rounded-sm border border-transparent bg-slate-300 py-2 px-4 text-sm font-medium text-white shadow-xs hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            Close
                        </button>
                        <button type="submit"
                                class="inline-flex custom-input justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-xs hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";
import Modal from "../../Shared/Components/Modal.vue";
import {XMarkIcon, ArrowUturnLeftIcon} from '@heroicons/vue/24/outline'
import {
    LinkIcon,
    PlusIcon,
    QuestionMarkCircleIcon,
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

const team = [
    {
        name: 'Tom Cook',
        email: 'tom.cook@example.com',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Whitney Francis',
        email: 'whitney.francis@example.com',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Leonard Krasner',
        email: 'leonard.krasner@example.com',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Floyd Miles',
        email: 'floyd.miles@example.com',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Emily Selman',
        email: 'emily.selman@example.com',
        href: '#',
        imageUrl:
            'https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
];

console.log('gitRepo::', gitRepo.value);
</script>
