<template>
    <div class="overflow-hidden bg-white sm:rounded-sm">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg xl:text-xl font-medium leading-6 text-slate-900">
                    {{ group.name }}
                </h3>
                <div class="flex gap-4 text-slate-400">
                    <div class="flex gap-1 ">
                        <div>Total Proposals</div>
                        <div class="font-semibold">-</div>
                    </div>
                    <div class="flex gap-1">
                        <div>Total Awarded</div>
                        <div class="font-semibold">-</div>
                    </div>
                    <div class="flex gap-1">
                        <div>Total Received</div>
                        <div class="font-semibold">-</div>
                    </div>
                    <div class="flex gap-1">
                        <div>Funding Remaining</div>
                        <div class="font-semibold">-</div>
                    </div>
                </div>
            </div>
            <div>
                <button type="button" @click.prevent="editing = !editing"
                        class="inline-flex items-center rounded-sm border border-slate-300 bg-white px-2.5 py-1.5 text-md font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    <span v-if="!editing">Edit</span>
                    <span v-if="!!editing">Cancel</span>
                </button>
            </div>
        </div>
        <form class="border-t border-slate-200 px-4 py-5 sm:px-6" @submit.prevent="submit">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <dt class="text-md font-medium text-slate-500">
                        <label for="bio" class="block text-sm font-medium text-slate-700">
                            About
                        </label>
                    </dt>
                    <dd class="mt-1 text-md text-slate-900">
                        <div v-if="!editing">
                            {{ group.bio }}
                        </div>
                        <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                            <textarea id="bio" name="bio" rows="6" v-model="groupForm.bio"
                                      class="mt-1 block w-full rounded-sm border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"></textarea>

                            <div class="text-pink-600" v-if="groupForm.errors.bio">
                                {{ groupForm.errors.bio }}
                            </div>
                        </div>
                    </dd>
                </div>

                <div class="flex gap-8 sm:col-span-2 w-full relative">
                    <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2">
                        Group Details
                    </div>
                    <div class="border divide-x space-x-8 flex gap-4 p-2 sm:col-span-2 w-full">
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="name" class="block text-sm font-medium text-slate-700">
                                    Group Name
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span v-if="!editing">{{ group.name }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="name" id="name" autocomplete="name"
                                           v-model="groupForm.name"
                                           class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.name">
                                        {{ groupForm.errors.name }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                Admin
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                {{ group?.owner?.name }}
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="website" class="block text-sm font-medium text-slate-700">
                                    Website
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span v-if="!editing">{{ group.website }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="website" id="website" autocomplete="website"
                                           v-model="groupForm.website"
                                           class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.website">
                                        {{ groupForm.errors.website }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>

                <div class="flex gap-8 sm:col-span-2 w-full relative">
                    <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2">
                        Community & Support Links
                    </div>
                    <div class="border divide-x space-x-8 flex gap-8 p-2 sm:col-span-2 w-full">
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="twitter" class="block text-sm font-medium text-slate-700">
                                    twitter
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span v-if="!editing">{{ group.twitter || '-' }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="twitter" id="twitter" autocomplete="twitter"
                                           v-model="groupForm.twitter"
                                           class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.twitter">
                                        {{ groupForm.errors.twitter }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-8">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="discord" class="block text-sm font-medium text-slate-700">
                                    discord
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span v-if="!editing">{{ group.discord || '-' }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="discord" id="discord" autocomplete="discord"
                                           v-model="groupForm.discord"
                                           class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.discord">
                                        {{ groupForm.errors.discord }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-8">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="github" class="block text-sm font-medium text-slate-700">
                                    github org
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span v-if="!editing">{{ group.github || '-' }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="github" id="github" autocomplete="github"
                                           v-model="groupForm.github"
                                           class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.github">
                                        {{ groupForm.errors.github }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2 hidden">
                    <dt class="text-sm font-medium text-slate-500">Attachments</dt>
                    <dd class="mt-1 text-sm text-slate-900">
                        <ul role="list" class="divide-y divide-slate-200 rounded-md border border-slate-200">
                            <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                <div class="flex w-0 flex-1 items-center">
                                    <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-slate-400" aria-hidden="true"/>
                                    <span class="ml-2 w-0 flex-1 truncate">resume_back_end_developer.pdf</span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="#" class="font-medium text-teal-600 hover:text-teal-500">Download</a>
                                </div>
                            </li>
                            <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                <div class="flex w-0 flex-1 items-center">
                                    <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-slate-400" aria-hidden="true"/>
                                    <span class="ml-2 w-0 flex-1 truncate">coverletter_back_end_developer.pdf</span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="#" class="font-medium text-teal-600 hover:text-teal-500">Download</a>
                                </div>
                            </li>
                        </ul>
                    </dd>
                </div>
            </dl>

            <div class="group-proposals-wrapper p-4 bg-slate-100 mt-8">
                <div>
                    <h3>{{ group.name }} Proposals <span> - more coming soon</span></h3>

                    <div>
                        <div class="overflow-hidden bg-white shadow sm:rounded-md">
                            <ul role="list" class="divide-y divide-gray-200">
                                <li v-for="proposal in proposals" :key="proposal.id">
                                    <a href="#" class="block hover:bg-gray-50">
                                        <div class="flex items-center px-4 py-4 sm:px-6">
                                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                                <div class="truncate">
                                                    <div class="flex text-sm">
                                                        <p class="truncate font-medium text-teal-600">{{ proposal.title }}</p>
<!--                                                        <p class="ml-1 flex-shrink-0 font-normal text-gray-500">in {{ position.department }}</p>-->
                                                    </div>
                                                    <div class="mt-2 flex">
                                                        <div class="flex items-center text-sm text-gray-500">
                                                            <CalendarIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                                            <p>
                                                                {{proposal.fund?.label}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                                    <div class="flex -space-x-1 overflow-hidden">
                                                        <img v-for="user in proposal.users" :key="user.id" class="inline-block h-6 w-6 rounded-full ring-2 ring-white" :src="user.profile_photo_url" :alt="user.name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-5 flex-shrink-0">
                                                <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 px-4 py-3 text-right sm:px-6 mt-8 -mx-6 -mb-6">
                <button type="submit"
                        class="inline-flex justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    {{ group.id ? 'Save' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script lang="ts" setup>
import Group from '../../models/group';
import {PaperClipIcon} from '@heroicons/vue/20/solid';
import {useForm, usePage} from "@inertiajs/vue3";
import {Ref, ref} from "vue";
import axios from "axios";
import { CalendarIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'
import Proposal from "../../models/proposal";

let proposals: Ref<Proposal[]> = ref([]);
const props = withDefaults(
    defineProps<{
        group: Group;
    }>(),
    {
        group: () => {
            return {} as Group;
        }
    }
);

axios.get(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group?.id}/proposals`)
    .then((response) => {
        proposals.value = [...response?.data?.data];
    })
    .catch((error) => {
        console.error(error);
    });

let groupForm = useForm({...props.group});
let editing = ref(!props?.group?.name || false);

let submit = () => {
    let url;
    if (props.group?.id) {
        url = `${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group.id}`;
    } else {
        url = `${usePage().props.base_url}/catalyst-explorer/my/groups`;
    }
    groupForm.post(url,
        {
            preserveScroll: false,
            preserveState: false,
            onSuccess: () => editing.value = false
        });
}

</script>
