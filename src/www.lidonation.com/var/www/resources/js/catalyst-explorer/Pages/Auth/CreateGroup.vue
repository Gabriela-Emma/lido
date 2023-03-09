<template>
    <Modal>
    <div class="overflow-hidden bg-white sm:rounded-sm">
        <form  class="border-t border-slate-200 px-4 py-5 sm:px-6" @submit.prevent="submit">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <dt class="text-md font-medium text-slate-500">
                        <label for="bio" class="block text-sm font-medium text-slate-700">
                            About
                        </label>
                    </dt>
                    <dd class="mt-1 text-md text-slate-900">
                        <div class="col-span-6 sm:col-span-3">
                            <textarea
                                id="bio"
                                name="bio"
                                rows="6"
                                v-model="groupForm.bio"
                                class="mt-1 block w-full rounded-sm border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"
                            ></textarea>

                            <div class="text-pink-600">
                                {{ groupForm.errors.bio }}
                            </div>
                        </div>
                    </dd>
                </div>

                <div class="flex gap-8 sm:col-span-2 w-full relative">
                    <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2" >
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
                                <span></span>
                                <div class="col-span-6 sm:col-span-3">
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        autocomplete="name"
                                        v-model="groupForm.name"
                                        class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                                    />
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
                                {{ owner.name }}
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="website" class="block text-sm font-medium text-slate-700">
                                    Website
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <div class="col-span-6 sm:col-span-3">
                                    <input
                                        type="text"
                                        name="website"
                                        id="website"
                                        autocomplete="website"
                                        v-model="groupForm.website"
                                        class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                                    />
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
                                <div class="col-span-6 sm:col-span-3">
                                    <input
                                        type="text"
                                        name="twitter"
                                        id="twitter"
                                        autocomplete="twitter"
                                        v-model="groupForm.twitter"
                                        class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                                    />
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
                                <div class="col-span-6 sm:col-span-3">
                                    <input
                                        type="text"
                                        name="discord"
                                        id="discord"
                                        autocomplete="discord"
                                        v-model="groupForm.discord"
                                        class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                                    />
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
                                <div class="col-span-6 sm:col-span-3">
                                    <input
                                        type="text"
                                        name="github"
                                        id="github"
                                        autocomplete="github"
                                        v-model="groupForm.github"
                                        class="mt-1 block w-full rounded-sm border border-slate-300 py-2 px-3 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm"
                                    />
                                    <div class="text-pink-600" v-if="groupForm.errors.github">
                                        {{ groupForm.errors.github }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
            </dl>
            <div class="bg-slate-50 px-4 py-3 text-right sm:px-6 mt-8 -mx-6 -mb-6">
                <button type="submit" class="inline-flex justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm 
                    font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    Create
                </button>
            </div>
        </form>
    </div>
    </Modal>

</template>

<script lang="ts" setup>
import { router, useForm, usePage } from "@inertiajs/vue3";
import axios from "axios";
import Group from "../../models/group";
import Modal from "../../Shared/Components/Modal.vue";
import {ref} from "vue";
import Profile from "../../models/profile";




const props = withDefaults(
    defineProps<{
        owner: Profile;
    }>(),
    {}
);

let owner = ref(props.owner)
let groupForm = useForm({
    bio: '',
    name: '',
    website: '',
    github: '',
    twitter:'',
    discord:'',
    owner
});

let submit = () => {
    groupForm.post(`${usePage().props.base_url}/catalyst-explorer/my/groups`,
        {
            preserveScroll: true,
            preserveState: true,
        }
        );
}
</script>
