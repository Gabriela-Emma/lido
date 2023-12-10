<template>
    <div class="relative z-0 flex flex-row-reverse mt-auto -space-x-1">
        <div class="mr-auto" v-for="(author, index) in authors">
            <button class="rounded-full" @click="emit('profileQuickView', author)" :class="[`w-${size}`, `h-${size}`]">
                <img v-if="index === 0" class="relative inline-block w-10 h-10 rounded-full -left-2 ring-2 ring-white"
                    :src="author['profile_photo_url']" :alt="`${author['name']} gravatar`"
                    :class="[`w-${size}`, `h-${size}`, `z-${index}`]" />
                <img v-else class="relative z-{{index}} inline-block rounded-full ring-2 ring-white"
                    :src="author['profile_photo_url']" :alt="`${author['name']} gravatar`"
                    :class="[`w-${size}`, `h-${size}`, `z-${index}`]" />
            </button>
        </div>
    </div>
</template>
<script lang="ts" setup>
import Proposal from "../../../models/proposal";
import { ComputedRef, computed, ref } from 'vue';


interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: { original_url: string }[]
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
        size: 10,
    },
);

const proposerUri = props.proposal?.links ? props.proposal.links.find(item => item.rel === "users")?.href : null;
let proposers = ref<Author[]>([]);

const emit = defineEmits<{
    (e: 'quickpitch'): void,
    (e: 'profileQuickView', profile: Author): void,
}>();

if (proposerUri) {
    loadProposers(proposerUri);
}

const authors: ComputedRef<Author[]> = computed(() => {
    if (props.proposal?.users) {
        return props.proposal?.users.map((user) => {
            return {
                ...user,
                profile_photo_url: user.media?.length > 0 ? user.media[0]?.original_url : user.profile_photo_url
            }
        })
    } else {
        return proposers.value
    }
});

async function loadProposers(proposerUri: string) {
    try {
        const  data  = (await window.axios.get(proposerUri, {})).data;
        proposers.value = data.data
    } catch (e) {
        console.log({ e });
    }
}
</script>
