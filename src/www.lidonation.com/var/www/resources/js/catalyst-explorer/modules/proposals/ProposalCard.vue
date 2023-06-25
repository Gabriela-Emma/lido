<style scoped lang="scss">
.proposal-drip {
    .drip-content p {
        @apply mt-0 inline;
        display: inline;
    }
}
</style>
<template>
    <div
        class="relative flex flex-col w-full h-full bg-white border divide-y rounded-sm border-slate-100 proposal-drip overflow-clip">
        <div class="flex flex-col justify-start h-full gap-4 p-4" >
            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="translate-y-1 opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="translate-y-0 opacity-100"
                leave-to-class="translate-y-1 opacity-0">

                <div class="absolute z-10 w-full h-full px-4 transform -translate-x-1/2 -translate-y-4 left-1/2 sm:px-0 bg-white/90" v-if="profileQuickView">
                    <div class="overflow-hidden rounded-sm shadow-xs ring-1 ring-black/5">
                        <div class="relative flex gap-3 p-2 pt-16 text-white bg-teal-600 shadow-sm">
                            <div class="absolute top-0 flex justify-end w-full h-16 px-5 py-3">
                                <button type="button" @click="profileQuickView = null"
                                        class="flex justify-center w-10 h-10 p-2 text-white rounded-lg shadow-sm bg-slate-600 hover:bg-slate-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                                    <XMarkIcon class="w-5 h-5" aria-hidden="true" />
                                </button>
                            </div>
                            <div class="flex items-center justify-center w-12 h-12 bg-white rounded-full">
                                <img
                                    class="relative inline-block w-10 h-10 rounded-full ring-2 ring-white"
                                    :src="profileQuickView?.profile_photo_url"
                                    :alt="`${profileQuickView?.name} gravatar`"/>
                            </div>
                            <div class="flex flex-0">
                                <h3 class="text-md md:text-xl">{{ profileQuickView?.name }}</h3>
                            </div>
                        </div>

                        <div class="relative flex flex-col gap-4 bg-white p-7">
                            <a :href="$utils.localizeRoute(`project-catalyst/users/${profileQuickView.username}`)" target="_blank"
                                class="flex items-center p-2 -m-3 transition duration-150 ease-in-out rounded-lg hover:bg-gray-50 focus:outline-none focus-visible:ring focus-visible:ring-orange-500 focus-visible:ring-opacity-50">
                                <div class="flex items-center justify-center w-10 h-10 text-white shrink-0 sm:h-12 sm:w-12">
                                    <LinkIcon class="w-5 h-5 text-slate-700"
                                    :class="{
                                        'hover:text-slate-400':isBookmarked,
                                        'group-hover:text-teal-900':!isBookmarked
                                    }"
                                    aria-hidden="true" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        LIDO Profile
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        View Full Profile
                                    </p>
                                </div>
                            </a>


                            <a :href="`https://cardano.ideascale.com/c/profile/${profileQuickView.ideascale_id}/`" target="_blank"
                                class="flex items-center p-2 -m-3 transition duration-150 ease-in-out rounded-lg hover:bg-gray-50 focus:outline-none focus-visible:ring focus-visible:ring-orange-500 focus-visible:ring-opacity-50">
                                <div class="flex items-center justify-center w-10 h-10 text-white shrink-0 sm:h-12 sm:w-12">
                                    <img class="rounded-sm w-7 h-7"
                                        :src="$utils.assetUrl('img/ideascale-logo.png')"
                                        alt="Ideascale logo">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        Ideascale Profile
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        View & Contact user on Ideascale
                                    </p>
                                </div>
                            </a>
                        </div>

                        <div class="grid grid-cols-3 p-4 text-left gap-y-3 bg-gray-50">
                            <div class="flex flex-col items-start justify-between p-2">
                                <span class="flex justify-start text-xs font-medium text-gray-900">
                                    <span class="inline-flex">F10 Primary Proposals</span>
                                </span>
                                <span class="block text-xs text-gray-500">
                                    Coming Soon...
                                </span>
                            </div>
                            <div class="flex flex-col items-start justify-between p-2">
                                <span class="flex justify-start text-xs font-medium text-gray-900">
                                    <span class="indline-flex">F10 Co-proposing</span>
                                </span>
                                <span class="block text-xs text-gray-500">
                                    Coming Soon...
                                </span>
                            </div>
                            <div class="flex flex-col items-start justify-between p-2">
                                <span class="flex justify-start text-xs font-medium text-gray-900">
                                    <span>Completed Proposals</span>
                                </span>
                                <span class="block text-xs text-gray-500">
                                    Coming Soon...
                                </span>
                            </div>
                            <div class="flex flex-col items-start justify-between p-2">
                                <span class="flex justify-start text-xs font-medium text-gray-900">
                                    <span>Outstanding Proposals</span>
                                </span>
                                <span class="block text-xs text-gray-500">
                                    Coming Soon...
                                </span>
                            </div>

                            <div class="flex flex-col items-start justify-between p-2">
                                <span class="flex justify-start text-xs font-medium text-gray-900">
                                    <span>Outstanding Co-Proposals</span>
                                </span>
                                <span class="block text-xs text-gray-500">
                                    Coming Soon...
                                </span>
                            </div>

                            <button @click="handleFilterToUserProposals(profileQuickView)" class="flex flex-col items-start justify-center h-full p-2 text-center text-white bg-teal-700 hover:cursor-pointer hover:bg-teal-500">
                                <span class="text-xs">
                                    See all {{profileQuickView.username}}'s proposals
                                </span>
                            </button>

                        </div>
                    </div>
                </div>
            </transition>

            <header class="flex flex-col justify-center gap-y-1">
                <div class="relative flex justify-between gap-4">
                    <h2 class="flex items-start justify-between h-24 pr-6 overflow-clip line-clamp-3">
                        <span>
                            <a class="font-medium text-gray-800 text-md"
                               target="_blank"
                               :href="$utils.localizeRoute(`proposals/${proposal.slug}`)">
                                {{ proposal.title }}
                            </a>
                        </span>
                    </h2>
                    <div class="absolute top-1 right-1">
                        <Link preserve-state preserve-scroll
                            :href="$utils.localizeRoute(`catalyst-explorer/proposals/${proposal.id}/bookmark`)" as="button"
                            :class="{
                                'bg-teal-600 hover:bg-slate-600 focus:ring-slate-300':isBookmarked,
                                'bg-slate-600 hover:bg-teal-600 focus:ring-teal-300':!isBookmarked
                            }"
                            class="inline-flex items-center rounded-md border border-transparent group p-0.5 text-sm font-medium leading-4 text-white shadow-sm focus:outline-none focus:ring-2  focus:ring-offset-2">
                            <BookmarkIcon class="w-4 h-4 "
                            :class="{
                                      'hover:text-slate-400':isBookmarked,
                                      'group-hover:text-teal-900':!isBookmarked
                                    }"
                            aria-hidden="true" />
                        </Link>
                    </div>
                </div>
                <div class="flex flex-row mb-2 text-white flex-nowrap">
                    <div
                        v-if="proposal.amount_received > 0.00"
                        class="inline-flex text-xs xl:text-lg font-semibold rounded-l-sm py-0.5">
                        <div class="px-1 py-1.5 pb-4 bg-accent-800">
                            {{ $filters.currency(proposal.amount_received, proposal.currency) }}
                            <sub class="text-gray-200 block mt-0.5 italic">
                                {{  $t("Distributed") }}
                            </sub>
                        </div>

                        <div class="px-3 py-1.5 text-sm xl:text-md bg-accent-900 inline-flex items-center"
                             v-if="(proposal.amount_requested - proposal.amount_received) === 0">
                            {{  $t("Fully") }}<br/>
                            {{  $t("Paid") }}
                        </div>
                        <div class="px-1 py-1.5 bg-accent-900" v-else>
                            {{ $filters.currency(proposal.amount_requested - proposal.amount_received, proposal.currency) }}
                            <sub class="text-gray-200 block mt-0.5 italic">
                                {{  $t("Remaining") }}
                            </sub>
                        </div>
                    </div>

                    <div
                        class="flex flex-col justify-center items-start p-1.5 text-xs xl:text-lg leading-3 font-semibold rounded-r-sm bg-teal-800">
                        <div>{{ $filters.currency(proposal.amount_requested, proposal.currency) }}</div>
                        <small class="block text-sm italic text-gray-200">
                            {{  $t("Requested") }}
                        </small>
                    </div>
                </div>
            </header>
            <div class="space-y-3 text-sm">
                <div class="font-normal drip-content">
                    <div v-if="proposal.solution"
                         v-html="$filters.markdown('**Solution:** ' + proposal.solution)"></div>
                    <div v-else v-html="$filters.markdown('**Problem:** ' + proposal.problem)"></div>
                </div>
                <div class="flex flex-row flex-wrap items-center gap-2">
                    <div v-if="proposal.challenge_label" class="inline gap-1">
                        <strong>{{  $t("Challenge") }}: </strong>
                        {{ proposal.challenge_label }}
                    </div>
                    <div v-if="proposal.fund_label"
                         class="rounded-sm bg-slate-200 text-xs xl:text-sm text-slate-900 px-2 font-semibold py-0.5 inline gap-1">
                        {{ proposal.fund_label }}
                    </div>
                </div>
            </div>
            <div class="space-x-1 italic">


                <!--                <div class="inline-flex text-xs xl:text-md font-semibold rounded-l-sm py-0.5">-->
                <!--                    <div class="px-1 py-1" :class="{-->
                <!--                    'bg-teal-600': proposal.funding_status === 'funded',-->
                <!--                    'bg-slate-500': proposal.funding_status === 'over_budget',-->
                <!--                    'bg-slate-300': proposal.funding_status === 'not_approved'}">-->
                <!--                        {{ proposal.funding_status?.replace('_', ' ') }}-->
                <!--                        <sub class="text-gray-200 block mt-0.5 italic text-xs">-->
                <!--                            Funding Status-->
                <!--                        </sub>-->
                <!--                    </div>-->
                <!--                    <div class="px-1 py-1 bg-slate-400">-->
                <!--                        {{ proposal.status?.replace('_', ' ') }}-->
                <!--                        <sub class="text-gray-200 block mt-0.5 italic text-xs">-->
                <!--                            Project Status-->
                <!--                        </sub>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            @elseif(!!$proposal->funded_at)-->
                <!--            <span-->
                <!--                class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-teal-light-500">funded</span>-->
                <!--            @elseif($proposal->funding_status == 'pending')-->
                <!--            <span-->
                <!--                class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm bg-gray-600">vote pending</span>-->
                <!--            @else-->
                <!--            <span-->
                <!--                class="inline-block px-1.5 py-0.5 font-semibold text-white text-xs rounded-sm {{$proposal->funding_status == 'over_budget' ? 'bg-slate-400' : 'bg-slate-300'}}">-->
                <!--            {{Str::replace('_', ' ', $proposal->funding_status)}}-->
                <!--        </span>-->
                <!--            @endif-->

                <!--            @if($proposal->is_impact_proposal)-->
                <!--            <span-->
                <!--                class="inline-block px-1.5 py-0.5 font-semibold text-gray-800 text-xs rounded-sm bg-accent-500">-->
                <!--        impact proposal-->
                <!--    </span>-->
                <!--            @endif-->

                <!--            <span>{{$proposal->funded_at ? 'Awarded' : 'Requested'}} {{round((float)($proposal->amount_requested / $proposal->fund->amount) * 100, 3 ) . '%'}} of the-->
                <!--    fund.</span>-->
            </div>

            <div class="relative z-0 flex flex-row-reverse mt-auto -space-x-1">
                <div class="mr-auto" v-for="(author, index) in authors">
                    <button class="w-10 h-10 rounded-full" @click="handleProfileQuickView(author)">
                        <img
                            v-if="index === 0"
                            class="h-10 w-10 relative -left-2 z-{{index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                            :src="author.profile_photo_url"
                            :alt="`${author.name} gravatar`"/>
                        <img v-else
                             class="h-10 w-10 relative z-{{index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                             :src="author.profile_photo_url"
                             :alt="`${author.name} gravatar`"/>
                    </button>

                    <!-- <a class="block" target="_blank"
                       :href="$utils.localizeRoute(`project-catalyst/users/${author.username}`)">
                        <img
                            v-if="index === 0"
                            class="h-10 w-10 relative -left-2 z-{{index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                            :src="author.avatar"
                            :alt="`${author.name} gravatar`"/>
                        <img v-else
                             class="h-10 w-10 relative z-{{index}} inline-block h-10 w-10 rounded-full ring-2 ring-white"
                             :src="author.avatar"
                             :alt="`${author.name} gravatar`"/>
                    </a> -->
                </div>
            </div>
        </div>

        <footer class="mt-auto divide-y">
            <div class="grid grid-cols-2 -mt-px text-xs divide-x xl:text-sm">
                <div class="flex items-center justify-start flex-1 gap-2 p-2">
                    <div class="text-xs">
                        <a v-if="proposal?.ideascale_link" :href="proposal?.ideascale_link" target="_blank"
                           class="flex items-center gap-2 hover:cursor-pointer">
                            <img class="rounded-sm w-7 h-7"
                                 :src="$utils.assetUrl('img/ideascale-logo.png')"
                                 alt="Ideascale logo">
                                 <span class="text-xs">View on Ideascale</span>
                        </a>
                    </div>
                    <div>
                        <a v-if="proposal.website" :href="proposal.website" target="_blank"
                           class="hover:cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="flex justify-end flex-1 w-full -ml-px">
                    <div
                        class="flex items-center justify-center flex-1 py-2 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-sm hover:text-gray-500">
                        <div class="flex items-center gap-1">
                            <div class="text-sm font-semibold">
                                {{ $filters.shortNumber(proposal.ca_rating)?.toFixed(2) }}
                            </div>
                            <div>
                                <Rating :modelValue="proposal.ca_rating" :stars="5" :readonly="true" :cancel="false">
                                    <template #onicon>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                             class="w-4 h-4 text-teal-500">
                                            <path
                                                d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                                        </svg>
                                    </template>
                                    <template #officon>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                        </svg>

                                    </template>
                                </Rating>
                            </div>
                            <div class="text-xs text-slate-400">
                                ({{ proposal.ratings_count }})
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-2 -mt-px text-xs divide-x xl:text-sm 2xl:text-md">
                <div class="flex items-center justify-start flex-1 gap-2 p-2">
                    <div class="text-xs">
                        {{  $t("Voted Yes") }}:
                    </div>
                    <div class="font-semibold">
                        ₳{{ $filters.shortNumber(proposal.yes_votes_count, 2) }}
                    </div>
                </div>

                <div class="flex flex-1 -ml-px">
                    <div
                        class="flex items-center gap-2 justify-end flex-1 py-2 px-1.5 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-sm hover:text-gray-500">
                        <div class="text-xs">
                            {{  $t("Voted No") }}:
                        </div>
                        <div class="font-semibold">
                            ₳{{ $filters.shortNumber(proposal.no_votes_count) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 -mt-px text-xs divide-x xl:text-sm 2xl:text-md">
                <div class="flex flex-row flex-wrap items-center justify-start flex-1 gap-1 px-2 py-2" :class="{
                            'bg-teal-500': proposal.funding_status === 'funded',
                            'bg-slate-500': proposal.funding_status === 'over_budget',
                            'bg-slate-400': proposal.funding_status === 'not_approved'}">
                    <div class="text-xs text-slate-200">
                        {{  $t("Funding Status") }}:
                    </div>
                    <div class="inline-block px-1 py-0 text-xs font-semibold text-white capitalize rounded-sm">
                        {{ proposal.funding_status?.replace('_', ' ') }}
                    </div>
                </div>

                <div class="flex flex-1 -ml-px">
                    <div
                        class="flex items-center justify-end flex-1 gap-1 px-1 py-2 -mr-px text-xs font-medium text-gray-700 border border-transparent rounded-bl-sm hover:text-gray-500"
                        :class="{
                            'bg-pink-400': proposal.status === 'complete',
                            'bg-slate-200': proposal.status === 'in_progress'}">
                        <div class="text-xs" :class="{ 'text-slate-200': proposal.status === 'complete'}">
                            {{  $t("Project Status") }}:
                        </div>
                        <div class="font-semibold capitalize" :class="{ 'text-white': proposal.status === 'complete'}">
                            {{ proposal.status?.replace('_', ' ') }}
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script lang="ts" setup>
import Proposal from "../../models/proposal";
import Rating from 'primevue/rating';
import {ComputedRef, computed, inject, ref, watch} from "vue";
import {BookmarkIcon, LinkIcon, XMarkIcon} from "@heroicons/vue/20/solid";
import { Link } from '@inertiajs/vue3';
import { useBookmarksStore } from "../../stores/bookmarks-store";
import { storeToRefs } from "pinia";
import { Ref } from "@vue/reactivity";
import { usePeopleStore } from "../../stores/people-store";

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

interface Author {
    id: number;
    name: string;
    username: string;
    profile_photo_url: string;
    ideascale_id: number;
    media: {original_url: string}[]
}

/**
 * Init People
 */
 const peopleStore = usePeopleStore();
 const {people} = storeToRefs(peopleStore);

// computer properties
const authors: ComputedRef<Author[]> = computed(() => {
    return props.proposal.users?.reverse().map((user) => {
        return {
            ...user,
            profile_photo_url: user.media?.length > 0 ? user.media[0]?.original_url : user.profile_photo_url
        }
    })
});

let isBookmarked:Ref<boolean> = ref()

const bookmarksStore = useBookmarksStore();
const {models: bookmarkCollectionsModels$} = storeToRefs(bookmarksStore);

watch([bookmarkCollectionsModels$], (newValue, oldValue) => {
    isBookmarked.value =  bookmarkCollectionsModels$.value?.some(model => model.id === props.proposal.id);
});

let profileQuickView = ref(null);
let handleProfileQuickView  = (user: Author) => {
    profileQuickView.value = user;
}

let handleFilterToUserProposals = (user: Author) => {
    peopleStore.select([user.id]);
}
</script>
