<template>
    <Modal>
        <div
            class="bg-white flex flex-col divide-y bg-white p-16 rounded-sm relative overflow-clip">>
            This is coming soon!
        </div>
    </Modal>
</template>

<script lang="ts" setup>
import {defineEmits, ref, watch} from "vue";
import {storeToRefs} from "pinia";
import Modal from "../Shared/Components/Modal.vue";
import Challenge from "../models/challenge";
import {useTagsStore} from "../stores/tags-store";

const props = withDefaults(
    defineProps<{
        modelValue?: Challenge
    }>(),
    {},
);
let selectedRef = ref(props.modelValue);
const tagsStore = useTagsStore();
const {tags} = storeToRefs(tagsStore);

////
// events & watchers
////
const emit = defineEmits<{
    (e: 'update:modelValue', challenge: Challenge): void
}>();

watch(selectedRef, (newChallenge, oldFund) => {
    emit('update:modelValue', newChallenge);
});

////
// Actions
////////////////
function search(search) {
    tagsStore.search({search})
}
</script>
