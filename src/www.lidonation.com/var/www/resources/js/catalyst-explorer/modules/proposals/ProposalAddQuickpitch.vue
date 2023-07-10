<template>
    <form class="flex flex-col h-full p-4 bg-white divide-y divide-gray-200">
        <div class="flex flex-row justify-between h-full">
            <h3>
                {{ $t("Add a Quickpitch") }}
            </h3>
        </div>
        <div class="flex-1 overflow-y-auto ">
            <div class="flex flex-col justify-between flex-1">
                <div class="h-64 divide-y divide-gray-200">
                    <div class="pt-6 pb-5 space-y-6">
                        <div>
                            <label for="project-name" class="block text-sm font-medium text-gray-900">
                                {{ $t("Youtube or Vimeo link") }}
                            </label>
                            <div class="flex-grow mt-1">
                                <input v-model="form.quickpitch" type="text" name="quickpitch" id="quickpitch"
                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" />

                                <div v-if="errorMessage && form.quickpitch !== '' "
                                     class="mt-2 text-sm text-red-500">{{ errorMessage }}
                                </div>

                                <div class="w-full items center" v-show="success">
                                    <div
                                        class="flex justify-between w-48 p-1 mt-4 bg-green-700 rounded-md">
                                        <span class="text-white">Quickpitch Saved!</span>
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
        <div class="flex justify-end gap-4 px-4 py-4">
            <button type="button" @click="emit('cancelled')"
                    class="inline-flex gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-sm shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                <ArrowUturnLeftIcon class="w-4 h-4"/>
                <span>{{ $t("Back") }}</span>
            </button>
            <button @click.prevent="submit"
                    as="button"
                    class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm custom-input hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                {{ $t("Save") }}
            </button>
        </div>
    </form>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";
import {useForm} from "@inertiajs/vue3";
import {debounce} from "lodash";
import axios from "axios";
import {ref, watch, defineEmits, computed} from "vue";
import { ArrowUturnLeftIcon } from '@heroicons/vue/20/solid';
import route from "ziggy-js";

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
let form = useForm({
    quickpitch: props.proposal?.meta_data?.quickpitch || null,
});

const emit = defineEmits<{
    (e: 'cancelled'): void
}>();

async function validateVideo(newPitch: string) {
    //@todo implement this function
    try {

    } catch (error) {
        console.error(error);
    }
}

watch( () => form.quickpitch,  debounce(validateVideo, 500));

let submit = () => {
    axios.post(route('catalystExplorerApi.proposals.storeQuickpitch', {proposal: props.proposal?.id}), form)
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
