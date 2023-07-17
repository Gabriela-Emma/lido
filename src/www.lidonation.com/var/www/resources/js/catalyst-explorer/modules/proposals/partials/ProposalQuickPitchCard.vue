<template>
<div class="relative flex flex-col w-full h-full gap-4 p-4 quick-pitch-wrapper">
    <div class="relative">
        <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="translate-y-1 opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="translate-y-0 opacity-100"
                leave-to-class="translate-y-1 opacity-0">
                <div class="embed-wrapper">
                    <vue-plyr v-if="quickpitchProvider === 'youtube'">
                        <div :data-plyr-provider="quickpitchProvider" :data-plyr-embed-id="proposal.quickpitch"></div>
                    </vue-plyr>
                    <vue-plyr v-if="quickpitchProvider === 'vimeo'">
                        <div class="plyr__video-embed">
                            <iframe :src="`https://player.vimeo.com/video/${proposal.quickpitch}?h=f2c5cf1159&title=0&byline=0&portrait=0`"
                            style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0"
                            allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </vue-plyr>
                </div>
        </transition>
    </div>

    <h2 class="flex items-start justify-between h-24 pr-6 xl:pr-8 overflow-clip line-clamp-3">
        <span>
            <a class="font-medium text-gray-800 text-md"
                target="_blank"
                :href="$utils.localizeRoute(`proposals/${proposal.slug}`)">
                {{ proposal.title }}
            </a>
        </span>
    </h2>

    <div class="mb-4">
        <ProposalBudget v-if="proposal" :proposal="proposal" />
    </div>

    <ProposalAuthors :proposal="proposal" @profileQuickView="emit('profileQuickView', $event)"/>

    <div class='absolute right-0 -bottom-1 details-toggle-wrapper'>
        <button type="button"
            @click="emit('summary')"
            class="inline-flex items-center px-5 py-3 border border-transparent shadow-sm shadow-inner text-sm leading-4 font-medium rounded-sm rounded-tl-[6rem] rounded-bl-[3rem] rounded-tr-[12rem] text-slate-600 bg-slate-200 hover:bg-slate-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-400">
            Details
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="h-3 ml-2 w-3s">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
            </svg>
        </button>
    </div>
</div>
</template>
<script lang="ts" setup>
import { computed, inject, ref } from "vue";
import Proposal from "../../../models/proposal";
import ProposalBudget from "./ProposalBudget.vue";
import ProposalAuthors from "./ProposalAuthors.vue";

const $utils: any = inject('$utils');

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

const emit = defineEmits<{
    (e: 'summary'): void,
    (e: 'profileQuickView', profile: Author): void,
}>();

interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: {original_url: string}[]
}

const regex: RegExp = /[a-zA-Z]/g;
const quickPitchId = props.proposal?.quickpitch;
const quickpitchProvider = computed(() => quickPitchId.match(regex) ? "youtube" : "vimeo" );
</script>
