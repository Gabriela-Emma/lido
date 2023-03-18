<template>
    <form class="flex h-full flex-col divide-y divide-gray-200 bg-white p-4">
        <div class="flex flex-row h-full justify-between">

                <h3>
                    {{ $t("Add a git repo") }}
                </h3>

            <div class="items-center ">
                <button @click.prevent="initUpdating"
                        v-if="hasRepo"
                        as="button"
                        class="inline-flex custom-input justify-center mb-3 rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    {{ $t("Update Repo") }}
                </button>
            </div>
        </div>
        <div class=" flex-1 overflow-y-auto ">
            <div class="flex flex-1 flex-col justify-between">
                <div class="divide-y divide-gray-200 px-4 sm:px-6 h-64">
                    <div class="space-y-6 pt-6 pb-5">
                        <div>
                            <label for="project-name" class="block text-sm font-medium text-gray-900">
                                ){{ $t("Git (https url") }}
                            </label>
                            <div class="mt-1 flex-grow">
                                <input v-model="repoForm.gitUrl" type="text" name="gitUrl" id="git"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"
                                       :class="{'bg-gray-100':hasRepo}"
                                       :disabled="hasRepo"/>
                                <div v-if="errorMessage && repoForm.gitUrl !== '' "
                                     class="text-red-500 mt-2 text-sm">{{ errorMessage }}
                                </div>
                                <input v-model="repoForm.proposal_id" type="text" class="hidden"
                                       name="proposal_id">
                                <input v-model="repoForm.user_id" type="text" class="hidden"
                                       name="catalystUser_id">
                                <div class="flex text-xs w-full lg:text-base justify-start mt-2">
                                    <multiselect
                                        class="block mt-3 rounded-sm z-10  p-0.5"
                                        :class="{'bg-gray-100':hasRepo}"
                                        v-model="repoForm.branch"
                                        :options="branches"
                                        :disabled="branches?.length === 0 || hasRepo "
                                        :close-on-select="true"
                                        :clear-on-select="false"
                                        :placeholder="branches?.length === 0 ? 'Add a git repo above' : 'Select primary development  or base branch'"
                                        label="name"
                                        track-by="name"
                                        :multiple="false"
                                        :taggable="false"
                                        :hide-selected="true"
                                        @input="repoForm.branch = $event">
                                    </multiselect>
                                </div>
                                <div class="w-full items center" v-show="success">
                                    <div
                                        class="flex justify-between  rounded-md bg-green-700  w-48 mt-4 p-1">
                                        <span class="text-white ">{{ success }}</span>
                                        <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"
                                             id="IconChangeColor" height="20" width="20">
                                            <path fill="#ffffff" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm-55.808 536.384-99.52-99.584a38.4 38.4 0 1
                                                    0-54.336 54.336l126.72 126.72a38.272 38.272 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336L456.192 600.384z"
                                                  id="mainIconPathAttribute" stroke-width="0"
                                                  stroke="#ff0000"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-4 justify-end px-4 py-4">
            <button @click.prevent="saveChanges"
                    v-if="startUpdate === true "
                    as="button"
                    class="inline-flex custom-input justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                {{ $t("Save Changes") }}
            </button>
            <button type="button" @click="emit('cancelled')"
                    class="rounded-sm border border-gray-300 bg-white py-2 inline-flex  gap-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                <ArrowUturnLeftIcon class="w-4 h-4"/>
                <span>{{ $t("Back") }}</span>
            </button>
            <button @click.prevent="submitRepo"
                    v-if="!hasRepo && !startUpdate"
                    as="button"
                    class="inline-flex custom-input justify-center rounded-sm border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                {{ $t("Save") }}
            </button>
        </div>
    </form>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";
import {useForm, usePage} from "@inertiajs/vue3";
import {debounce} from "lodash";
import Multiselect from '@vueform/multiselect';
import axios from "axios";
import {ref, watch, defineEmits, computed} from "vue";
import { ArrowUturnLeftIcon } from '@heroicons/vue/20/solid';

let errorMessage = ref('');
let success = ref();

const props = withDefaults(
    defineProps<{
        proposal: Proposal
    }>(),
    {
        proposal: () => {
            return {} as Proposal;
        },
    },
);
const repo = computed(() => (props.proposal?.repos[0] || null) );
let branches = ref<string[]>([repo.value?.tracked_branch]);
let repoForm = useForm({
    gitUrl: repo.value?.url,
    user_id: props.proposal.user_id,
    proposal_id: props.proposal.id,
    branch: repo.value?.tracked_branch
});

const emit = defineEmits<{
    (e: 'cancelled'): void
}>();

// get branches
async function getBranches(newUrl: string) {
    if (!newUrl.startsWith('https://')) {
        errorMessage.value = 'Invalid Git URL!!';
        branches.value = [];
        repoForm.branch = '';
        return;
    }

    try {
        const response = await fetch(`${usePage().props.base_url}/api/catalyst-explorer/branches?gitUrl=${newUrl}`);
        if (!response.ok) {
            throw new Error('Invalid Git URL!!');
        }
        const data = await response.json();
        if (!data || data.length === 0) {
            errorMessage.value = 'No branches found, ensure repo is public!!';
        } else {
            branches.value = data;
            if (!branches.value.includes(repoForm.branch)) {
                repoForm.branch = '';
            }
            errorMessage.value = '';
        }
    } catch (error) {
        console.error(error);
        branches.value = [];
        repoForm.branch = '';
        errorMessage.value = error.message;
    }
}

watch(
    () => repoForm.gitUrl,
    debounce(getBranches, 500)
);


let submitRepo = () => {
    axios.post(`${usePage().props.base_url}/api/catalyst-explorer/proposal/repo`, repoForm)
        .then((response) => {
            success.value = response.data;
            setTimeout(() => {
                success.value = null;
                errorMessage.value = '';
            }, 5000);
            errorMessage.value = '';
        })
        .catch((error) => {
            console.error(error);
        });
}


// updating repo  details
let startUpdate = ref(false);
let hasRepo = ref(repo.value != null);


// start updating 
let initUpdating = () =>{
    hasRepo.value =!hasRepo;
    startUpdate.value = true;

    watch(() => repoForm.gitUrl, debounce(getBranches, 500),
    { immediate: true });
}

let saveChanges = () =>
 {
    axios.patch(`${usePage().props.base_url}/api/catalyst-explorer/proposal/repo`, repoForm)
        .then((response) => {
            success.value = response.data;
            setTimeout(() => {
                success.value = null;
                errorMessage.value = '';
            }, 5000);
            errorMessage.value = '';
        })
        .catch((error) => {
            console.error(error);
        });
 }


</script>
