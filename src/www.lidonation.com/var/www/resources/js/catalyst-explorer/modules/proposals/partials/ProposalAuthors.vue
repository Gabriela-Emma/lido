<template>
<div class="relative z-0 flex flex-row-reverse mt-auto -space-x-1">
    <div class="mr-auto" v-for="(author, index) in authors">
        <button class="rounded-full" @click="emit('profileQuickView', author)"
        :class="[`w-${size} h-${size}`]"
        >
            <img
                v-if="index === 0"
                class="w-10 h-10 relative -left-2 z-{{index}} inline-block rounded-full ring-2 ring-white"
                :src="author.profile_photo_url"
                :alt="`${author.name} gravatar`"
                :class="[`w-${size} h-${size}`]" />
            <img v-else
                class="relative z-{{index}} inline-block rounded-full ring-2 ring-white"
                :src="author.profile_photo_url"
                :alt="`${author.name} gravatar`"
                :class="[`w-${size} h-${size}`]" />
        </button>
    </div>
</div>
</template>
<script lang="ts" setup>
import Proposal from "../../../models/proposal";
import { ComputedRef, computed } from 'vue';

interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: {original_url: string}[]
}

const props = withDefaults(
    defineProps<{
        proposal: Proposal,
        size: number,
    }>(),
    {
        proposal: () => {
            return {} as Proposal;
        },
        resize: 10,
    },
);

const emit = defineEmits<{
    (e: 'quickpitch'): void,
    (e: 'profileQuickView', profile: Author): void,
}>();

const authors: ComputedRef<Author[]> = computed(() => {
    return props.proposal?.users?.map((user) => {
        return {
            ...user,
            profile_photo_url: user.media?.length > 0 ? user.media[0]?.original_url : user.profile_photo_url
        }
    })
});
</script>
