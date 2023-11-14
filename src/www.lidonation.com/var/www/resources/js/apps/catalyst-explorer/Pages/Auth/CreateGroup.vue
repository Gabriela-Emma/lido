<template>
    <Modal>
    <div class="overflow-hidden bg-white sm:rounded-sm">
        <form  class="border-t border-slate-200 px-4 py-5 sm:px-6" @submit.prevent="submit">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <dt class="text-md font-medium text-slate-500">
                        <label for="bio" class="block text-sm font-medium text-slate-700">
                            {{ $t("About (20 words or more)") }}
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

                            <div class="text-pink-600" v-if="validBio">
                                {{ $t("20 words minimum") }}
                            </div>
                        </div>
                    </dd>
                </div>

                <div class="flex gap-8 sm:col-span-2 w-full relative">
                    <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2" >
                        {{ $t("Group Details") }}
                    </div>
                    <div class="border divide-x space-x-8 flex gap-4 p-2 sm:col-span-2 w-full">
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="name" class=" block text-sm font-medium text-slate-700">
                                    {{ $t("Group Name (10 characters min)")}}
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
                                    <div class="text-pink-600" v-if="validName">
                                        {{ $t("10 characters minimum") }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                {{ $t("Admin") }}
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                {{ $t(owner.name) }}
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="website" class="block text-sm font-medium text-slate-700">
                                    {{ $t("Website") }}
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
                                        {{ $t(groupForm.errors.website) }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>

                <div class="flex gap-8 sm:col-span-2 w-full relative">
                    <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2">
                        {{ $t("Community & Support Links") }}
                    </div>
                    <div class="border divide-x space-x-8 flex gap-8 p-2 sm:col-span-2 w-full">
                        <div class="flex flex-col flex-1 justify-center p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="twitter" class="block text-sm font-medium text-slate-700">
                                    {{ $t("twitter") }}
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
                                        {{ $t(groupForm.errors.twitter) }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-8">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="discord" class="block text-sm font-medium text-slate-700">
                                    {{ $t("discord") }}
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
                                        {{ $t(groupForm.errors.discord) }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-8">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="github" class="block text-sm font-medium text-slate-700">
                                    {{ $t("github org") }}
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
                                        {{ $t(groupForm.errors.github) }}
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
                    {{ $t("Create") }}
                </button>
            </div>
        </form>
    </div>
    </Modal>

</template>

<script lang="ts" setup>
import { router, useForm, usePage } from "@inertiajs/vue3";
import {ref} from "vue";
import Profile from "@apps/catalyst-explorer/models/profile";
import Modal from "@/global/Components/Modal.vue";

const props = withDefaults(
    defineProps<{
        owner: Profile;
    }>(),
    {}
);
function getPage():any
{
    router.visit(`${usePage().props.base_url}/catalyst-explorer/my/groups`,
    {
        // preserveScroll:true,
        // preserveState:true,
    }
    );

}
let owner = ref(props?.owner)
let groupForm = useForm({
    bio: '',
    name: '',
    website: '',
    github: '',
    twitter:'',
    discord:'',
    owner
});

let validBio = ref();
let validName = ref();

let submit = () => {

 validBio.value = groupForm.bio.split(' ').length >= 20 ? false : true;
 validName.value = groupForm.name.length >= 10 ? false : true;

    if((validBio.value || validName.value))
    {
        return;
    }

    groupForm.post(`${usePage().props.base_url}/catalyst-explorer/my/groups`,
        {
            preserveScroll: true,
            preserveState: true,

        })
    setTimeout(() => {
        getPage();
    }, 300);

}
</script>
