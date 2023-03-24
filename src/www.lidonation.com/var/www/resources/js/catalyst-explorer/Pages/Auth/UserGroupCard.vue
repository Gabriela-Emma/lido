<template>
    <div class="overflow-hidden bg-white sm:rounded-sm">
        <div class="flex items-center justify-between px-4 py-5 sm:px-6">
            <div>
                <h3 class="text-lg font-semibold leading-6 xl:text-xl f text-slate-900">
                    {{ group.name }}
                </h3>
                <div class="flex gap-4 text-slate-400">
                    <div class="flex gap-1 ">
                        <div>{{ $t("Total Proposals") }}</div>
                        <div class="font-semibold text-slate-900">- {{ totalProposals }}</div>
                    </div>
                    <div class="flex gap-1">
                        <div>{{ $t("Total Awarded") }}</div>
                        <div class="font-semibold text-slate-900">- {{ $filters.currency(totalAwarded)  }}</div>
                    </div>
                    <div class="flex gap-1">
                        <div>{{ $t("Total Received") }}</div>
                        <div class="font-semibold text-slate-900">- {{ $filters.currency(totalReceived)  }}</div>
                    </div>
                    <div class="flex gap-1">
                        <div>{{ $t("Funding Remaining") }}</div>
                        <div class="font-semibold text-slate-900">- {{ $filters.currency(totalRemaining)  }}</div>
                    </div>
                </div>
            </div>
            <div>
                <!-- make this a Link to the single group page. Use query parameters toggle edit mode-->
                <Link type="button" :href="$utils.localizeRoute(`catalyst-explorer/my/groups/${group.id}`)"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent hover:text-white hover:bg-teal-800 rounded-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    <span >{{ $t("Manage") }}</span>
                </Link>
            </div>
        </div>
        <form class="px-4 py-5 border-t border-slate-200 sm:px-6" >
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <dt class="font-medium text-md text-slate-500">
                        <label for="bio" class="block text-sm font-medium text-slate-700">
                            {{ $t("About") }}
                        </label>
                    </dt>
                    <dd class="mt-1 text-md text-slate-900">
                        <div >
                            {{ group.bio }}
                        </div>
                        <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                            <textarea id="bio" name="bio" rows="6" v-model="groupForm.bio"
                                    class="block w-full mt-1 rounded-sm shadow-sm border-slate-300 focus:border-teal-500 focus:ring-teal-500 sm:text-sm"></textarea>

                            <div class="text-pink-600" v-if="groupForm.errors.bio">
                                {{ groupForm.errors.bio }}
                            </div>
                        </div>
                    </dd>
                </div>

                <div class="relative flex w-full gap-8 sm:col-span-2">
                    <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2">
                        {{ $t("Group Details") }}
                    </div>
                    <div class="flex w-full gap-4 p-2 space-x-8 border divide-x sm:col-span-2">
                        <div class="flex flex-col justify-center flex-1 p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="name" class="block text-sm font-medium text-slate-700">
                                    {{ $t("Group Name") }}
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span >{{ group.name }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="name" id="name" autocomplete="name"
                                        v-model="groupForm.name"
                                        class="block w-full px-3 py-2 mt-1 border rounded-sm shadow-sm border-slate-300 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.name">
                                        {{ groupForm.errors.name }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col justify-center flex-1 p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                {{ $t("Admin") }}
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                {{ group?.owner?.name }}
                            </dd>
                        </div>
                        <div class="flex flex-col justify-center flex-1 p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="website" class="block text-sm font-medium text-slate-700">
                                    {{ $t("Website") }}
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span >{{ group.website }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="website" id="website" autocomplete="website"
                                        v-model="groupForm.website"
                                        class="block w-full px-3 py-2 mt-1 border rounded-sm shadow-sm border-slate-300 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.website">
                                        {{ groupForm.errors.website }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>

                <div class="relative flex w-full gap-8 sm:col-span-2">
                    <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2">
                        {{ $t("Community & Support Links") }}
                    </div>
                    <div class="flex w-full gap-8 p-2 space-x-8 border divide-x sm:col-span-2">
                        <div class="flex flex-col justify-center flex-1 p-2 pl-4">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="twitter" class="block text-sm font-medium text-slate-700">
                                    {{ $t("twitter") }}
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span >{{ group.twitter || '-' }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="twitter" id="twitter" autocomplete="twitter"
                                        v-model="groupForm.twitter"
                                        class="block w-full px-3 py-2 mt-1 border rounded-sm shadow-sm border-slate-300 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.twitter">
                                        {{ groupForm.errors.twitter }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col justify-center flex-1 p-2 pl-8">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="discord" class="block text-sm font-medium text-slate-700">
                                    {{ $t("discord") }}
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span>{{ group.discord || '-' }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="discord" id="discord" autocomplete="discord"
                                        v-model="groupForm.discord"
                                        class="block w-full px-3 py-2 mt-1 border rounded-sm shadow-sm border-slate-300 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.discord">
                                        {{ groupForm.errors.discord }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="flex flex-col justify-center flex-1 p-2 pl-8">
                            <dt class="text-sm font-medium text-slate-500">
                                <label for="github" class="block text-sm font-medium text-slate-700">
                                    {{ $t("github org") }}
                                </label>
                            </dt>
                            <dd class="mt-1 text-md text-slate-900">
                                <span >{{ group.github || '-' }}</span>
                                <div class="col-span-6 sm:col-span-3" v-if="!!editing">
                                    <input type="text" name="github" id="github" autocomplete="github"
                                        v-model="groupForm.github"
                                        class="block w-full px-3 py-2 mt-1 border rounded-sm shadow-sm border-slate-300 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                                    <div class="text-pink-600" v-if="groupForm.errors.github">
                                        {{ groupForm.errors.github }}
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
            </dl>
        </form>
    </div>
</template>

<script lang="ts" setup>
import Group from '../../models/group';
import {Link, useForm, usePage} from "@inertiajs/vue3";
import {inject, ref} from "vue";
import axios from "axios";
const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        perPage: number;
        group: Group;
    }>(),
    {
        group: () => {
            return {} as Group;
        }
    }
);

// metrics
getMetrics()

let groupForm = useForm({...props.group});
let editing = ref(!props?.group?.name || false);

let totalProposals = ref<number>();
let totalAwarded = ref<number>();
let totalReceived = ref<number>();
let totalRemaining = ref<number>();



// group's proposals metrics
function getMetrics()
{
    // proposal count
    axios.get(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group.id}/sum/proposals`)
    .then((res) => {
        totalProposals.value = res?.data;
    })
    .catch((error) => {
            console.error(error);
    });


    axios.get(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group.id}/sum/awarded`)
    .then((res) => {
        totalAwarded.value = res?.data;
    })
    .catch((error) => {
            console.error(error);
    });


    axios.get(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group.id}/sum/received`)
    .then((res) => {
        totalReceived.value = res?.data;
    })
    .catch((error) => {
            console.error(error);
    });


    axios.get(`${usePage().props.base_url}/catalyst-explorer/my/groups/${props.group.id}/sum/remaining`)
    .then((res) => {
        totalRemaining.value = res?.data;
    })
    .catch((error) => {
            console.error(error);
    });
}
</script>
