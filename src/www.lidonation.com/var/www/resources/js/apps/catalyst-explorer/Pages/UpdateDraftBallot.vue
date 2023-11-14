<template>
    <Modal>
        <form class="z-40 flex flex-col p-4 overflow-y-auto md:w-full md:h-full" @submit.prevent="submit">
            <div>
                <span class="text-sm lg:text-2xl">
                    Edit {{ draftBallot.title }}
                </span>
            </div>
            <div>
                <div class="relative flex mt-4 border rounded-md border-slate-200 bg-slate-50">
                    <small
                        class="absolute bg-slate-50 rounded-sm -top-2 border border-slate-200 left-3 px-1 py-0.5 text-sm z-10">Title</small>
                    <input type="text" v-model="editForm.title"
                           class="w-full pt-4 text-gray-900 transition-all border-0 border-transparent custom-input round-sm bg-slate-50 ring-0 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-teal-600 sm:text-sm sm:leading-6">
                </div>
                <div class="relative mt-4 border rounded-md border-slate-200 bg-slate-50">
                    <small
                        class="absolute bg-slate-50 rounded-sm -top-2 border border-slate-200 left-3 px-1 py-0.5 text-sm z-10">Write
                        up</small>
                    <textarea rows="8" name="write-up" id="write-up" v-model="editForm.content"
                              class="block w-full py-1.5 text-gray-900 pt-4 custom-input border-0 border-transparent round-sm bg-slate-50 ring-0 placeholder:text-gray-400 focus:ring-2 transition-all focus:ring-inset focus:ring-teal-600 sm:text-sm sm:leading-6 mt-0"/>
                </div>

                <div class="relative flex mt-4">
                    <label for="favcolor">Select Bookmark color:</label>
                    <input type="color" id="favcolor" name="favcolor" v-model="editForm.color">
                </div>
            </div>

            <div class="flex justify-end w-full mt-4">
                <button type="submit"
                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-sm shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    Save
                </button>
            </div>
        </form>
    </Modal>
</template>

<script setup lang="ts">
import {useForm} from '@inertiajs/vue3';
import {useModal} from 'momentum-modal';
import route from 'ziggy-js';
import DraftBallot from "@apps/catalyst-explorer/models/draft-ballot";
import Proposal from "@apps/catalyst-explorer/models/proposal";
import Modal from "@/global/Components/Modal.vue";


const props = defineProps<{
    draftBallot: DraftBallot<Proposal>
}>();

let editForm = useForm({...props.draftBallot})
let {close} = useModal();

let submit = () => {
    editForm.patch(route('catalyst-explorer.draftBallot.update', {draftBallot: props.draftBallot.hash}),
        {
            preserveState: false,
        }
    )
};
</script>
