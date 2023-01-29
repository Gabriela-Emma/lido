<template>
    <div
        class="w-full">
        <Multiselect
            placeholder="Limit to Challenge(s)"
            v-model="selectedRef"
            value-prop="id"
            label="title"
            mode="tags"
            :loading="filteredChallenges?.length <= 0"
            :options="filteredChallenges"
            :searchable="true"
            :classes="{
                container: 'multiselect border-0 px-1 py-2 flex-wrap',
                containerActive: 'shadow-none shadow-transparent box-shadow-none',
                tagsSearch: 'w-full absolute top-0 left-0 inset-0 outline-none focus:ring-0 appearance-none custom-input border-0 text-base font-sans bg-white pl-1 rtl:pl-0 rtl:pr-1',
                tag: 'multiselect-tag bg-teal-500 whitespace-normal',
                tags: 'multiselect-tags px-2'
            }"
        />
    </div>
</template>

<script lang="ts" setup>
import Multiselect from '@vueform/multiselect';
import {defineEmits, ref, watch} from "vue";
import {storeToRefs} from "pinia";
import {useChallengesStore} from "../../stores/challenges-store";
import Challenge from "../../models/challenge";

const props = withDefaults(
    defineProps<{
        modelValue?: Challenge
    }>(),
    {},
);
let selectedRef = ref(props.modelValue);
const challengesStore = useChallengesStore();
const {filteredChallenges} = storeToRefs(challengesStore);

////
// events & watchers
////
const emit = defineEmits<{
    (e: 'update:modelValue', challenge: Challenge): void
}>();

watch(selectedRef, (newChallenge, oldFund) => {
    emit('update:modelValue', newChallenge);
});
</script>
