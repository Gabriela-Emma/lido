<template>
    <header-component titleName0="My Catalyst" titleName1="Proposals" subTitle=""/>

    <section class="py-16 bg-primary-20">
        <div class="container">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="px-2 py-6 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav :crumbs="crumbs"/>
                </aside>

                <div class="lg:col-span-9 xl:col-span-10">
                    <div class="p-6 space-y-6 bg-white sm:px-6">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="">
                                    <h2 class="leading-6 text-slate-900">{{ $t("My Community Reviews") }}</h2>
                                </div>
                                <div class="w-1/4">
                                    <FundPicker v-model="filters.funds" class="border border-1 border-slate-300"/>
                                </div>
                            </div>

                            <div
                                class="pb-4 mt-8 -mx-4 ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-sm">
                                <table class="min-w-full overflow-x-auto divide-y divide-slate-300">
                                    <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">
                                            {{ $t("Rating") }}
                                        </th>
                                        <th scope="col"
                                            class="hidden px-3 py-3.5 text-left text-sm font-semibold text-slate-900 sm:table-cell">
                                            {{ $t("Rationale") }}
                                        </th>
                                        <th scope="col"
                                            class="hidden px-3 py-3.5 text-left text-sm font-semibold text-slate-900 sm:table-cell w-44">
                                            {{ $t("Proposal") }}
                                        </th>
                                        <th scope="col"
                                            class="hidden px-3 py-3.5 text-left text-sm font-semibold text-slate-900 lg:table-cell">
                                            {{ $t("Assessor") }}
                                        </th>

                                        <!-- <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">
                                            {{ $t("Assessor Level") }}
                                        </th> -->
                                        <!-- <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">{{ $t("Edit") }}</span>
                                        </th> -->
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200 text-slate-900">
                                    <tr v-for="rating in proposalRatings?.data">
                                        <td class="w-full py-4 pl-4 pr-3 text-sm max-w-0 sm:w-auto sm:max-w-none sm:pl-6 sm:text-lg">
                                            {{ rating.rating }}
                                        </td>

                                        <!-- Remaining -->
                                        <td class="hidden px-3 py-4 text-sm sm:table-cell">
                                            <div class="flex flex-col gap-2">
                                                <div class="flex flex-col gap-4">
                                                    <div>
                                                        <div>
                                                            {{ rating.rationale }}
                                                        </div>

                                                        <div class="flex gap-2 mt-2">
                                                            <button type="button" @click="respondingTo = rating"
                                                                    v-if="respondingTo?.id !== rating.id"
                                                                    :disabled="!!respondingTo"
                                                                    :class="{
                                                                'focus-visible:outline-teal-600 text-white bg-teal-600 hover:bg-teal-500': !respondingTo,
                                                                'focus-visible:outline-gray-300 text-gray-700 bg-gray-300 hover:bg-gray-200 cursor-not-allowed': respondingTo
                                                            }"
                                                                    class="inline-flex items-center gap-x-1.5 rounded-sm px-3 py-2 text-sm font-semibold  shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2">
                                                                <span>Respond</span>
                                                                <ArrowUturnLeftIcon class="w-4 h-4"/>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="flex flex-col gap-3 p-4 ml-8 divide-y-2 rounded-sm bg-slate-100 divide-slate-300"
                                                        v-if="rating.community_review?.comments?.length > 0">
                                                        <h2>Responses</h2>
                                                        <div v-for="comment in rating.community_review.comments"
                                                             class="flex justify-between items-center">
                                                            <div class="flex flex-col">
                                                                <div class="py-2"
                                                                     v-html="comment.text">
                                                                </div>
                                                                <div v-if="editing && comment.id === editingId">
                                                                    <textarea v-model="editedResponse"
                                                                              class="w-full h-24 p-2 border border-gray-300 rounded-md">
                                                                    </textarea>
                                                                    <div class="flex gap-2">
                                                                        <button type="button" @click="editingId = null"
                                                                                class="inline-flex items-center gap-x-1.5 rounded-sm bg-gray-300 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-300">
                                                                            <span>Cancel</span>
                                                                        </button>
                                                                        <button type="button"
                                                                                @click="submitResponseEdit(comment.id, rating.community_review.id)"
                                                                                class="inline-flex items-center gap-x-1.5 rounded-sm bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                                                                            <span>Submit</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flex items-center gap-3"
                                                                 v-if="comment.id !== editingId">
                                                                <button @click="editResponse(comment.text, comment.id)">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                         viewBox="0 0 24 24" stroke-width="1.5"
                                                                         stroke="currentColor" class="w-5 h-5">
                                                                        <path stroke-linecap="round"
                                                                              stroke-linejoin="round"
                                                                              d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                                                    </svg>
                                                                </button>
                                                                <TrashIcon
                                                                    @click="deleteResponse(comment.id, rating.community_review.id)"
                                                                    aria-hidden="true"
                                                                    class="w-5 h-5 text-black hover:text-red-600 hover:cursor-pointer"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div v-if="respondingTo?.id == rating.id">
                                                    <div>
                                                        <textarea v-model="respondingToResponse"
                                                                  class="w-full h-24 p-2 border border-gray-300 rounded-md">
                                                        </textarea>
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <button type="button" @click="respondingTo = null"
                                                                class="inline-flex items-center gap-x-1.5 rounded-sm bg-gray-300 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-300">
                                                            <span>Cancel</span>
                                                        </button>
                                                        <button type="button" @click="respondToReview"
                                                                class="inline-flex items-center gap-x-1.5 rounded-sm bg-teal-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                                                            <span>Submit</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="hidden px-3 py-4 text-sm align-top w-44 sm:table-cell">
                                            <a target="_blank" :href="rating?.proposal?.link">
                                                {{ rating.proposal?.title }}
                                            </a>
                                        </td>

                                        <td class="hidden px-3 py-4 text-sm align-top lg:table-cell">
                                            <div class="flex flex-col justify-start w-full gap-4 text-center">
                                                <div class="flex flex-col gap-1">
                                                    <span class="font-medium">Id</span>
                                                    <span class="font-bold">
                                                        {{ rating.meta_data?.assessor_id }}
                                                    </span>
                                                </div>
                                                <div class="flex flex-col gap-1">
                                                    <span>Level</span>
                                                    <span class="font-bold">
                                                        {{ rating.meta_data?.assessor_level }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>


                                        <!-- <td class="px-3 py-4 text-sm">
                                            15th
                                        </td> -->
                                        <!-- <td class="py-4 pl-3 pr-4 text-sm text-right sm:pr-6"> -->
                                        <!-- <Link
                                            :href="$utils.localizeRoute(`catalyst-explorer/my/proposals/${proposal.id}`)"
                                            class="text-teal-600 hover:text-teal-900">{{ $t("Manage") }}<span
                                            class="sr-only">{{ proposal.title }}</span></Link> -->
                                        <!-- </td> -->
                                    </tr>

                                    </tbody>
                                </table>
                                <div class="flex justify-between w-full gap-16 my-16 xl:gap-24">
                                    <div class="flex-1 w-full px-6">
                                        <Pagination :links="props.proposalRatings.links"
                                                    :per-page="props.perPage"
                                                    :total="props.proposalRatings?.meta?.total"
                                                    :from="props.proposalRatings?.meta?.from"
                                                    :to="props.proposalRatings?.meta?.to"
                                                    @perPageUpdated="(payload) => perPageRef = payload"
                                                    @paginated="(payload) => currPageRef = payload"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {router, useForm, usePage} from '@inertiajs/vue3';
import {watch, ref} from "vue";
import {ArrowUturnLeftIcon, TrashIcon} from "@heroicons/vue/20/solid";
import {Ref} from "vue";
import route from "ziggy-js";
import ProposalRatingData = App.DataTransferObjects.ProposalRatingData;
import Filters from "@/global/models/filters";
import {VARIABLES} from "@apps/catalyst-explorer/models/variables";
import Pagination from "@apps/catalyst-explorer/Components/Global/Pagination.vue";
import FundPicker from "@apps/catalyst-explorer/modules/funds/FundPicker.vue";
import UserNav from "@apps/catalyst-explorer/Pages/Auth/UserNav.vue";


const props = withDefaults(
    defineProps<{
        locale: string,
        filters: Filters,
        totalDistributed: number,
        totalRemaining: number,
        budgetSummary: number,
        currPage?: number,
        perPage?: number,
        crumbs: [],
        proposalRatings: {
            data: ProposalRatingData[]
            links: [],
            meta: {
                total: number,
                to: number,
                from: number,
            };
        };
    }>(), {});

let filtersRef = ref(props.filters);
let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);
let filters = ref<Filters>(props.filters);

let respondingTo: Ref<ProposalRatingData | null> = ref(null);
let respondingToResponse = ref(null);
let editedResponse = ref(null);
let editing = ref(false);
let editingId = ref(null);

watch([filtersRef], () => {
    query();
}, {deep: true});

watch([currPageRef, perPageRef], () => {
    query();
});

function query() {
    const data = {} as any;

    if (currPageRef.value) {
        data[VARIABLES.PAGE] = currPageRef.value;
    }
    if (perPageRef.value) {
        data[VARIABLES.PER_PAGE] = perPageRef.value;
    }
    if (!filtersRef.value?.funded) {
        data[VARIABLES.FUNDED_PROPOSALS] = 0;
    }
    if (filtersRef.value?.funds) {
        data[VARIABLES.FUNDS] = Array.from(filtersRef.value?.funds);
    }

    router.get(
        `${usePage().props.base_url}/catalyst-explorer/my/reviews`,
        data,
        {preserveState: true, preserveScroll: true}
    );
}

async function respondToReview() {
    const response = useForm({
        reply: respondingToResponse.value,
    });

    response.post(route(
            'catalyst-explorer.replyToMyCommunityReview',
            {assessment: respondingTo.value.community_review.id}
        ),
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                respondingTo.value = null;
                respondingToResponse.value = null;
            }
        });
}

function deleteResponse(responseId: number, reviewId: number) {
    const response = useForm({
        resId: responseId,
    });

    response.delete(route(
            'catalyst-explorer.destroyResponseToMyCommunityReview',
            {assessment: reviewId}
        ),
        {
            preserveScroll: true,
        });
}

function editResponse(resContent: string, responseId: number) {
    editing.value = true;
    editingId.value = responseId;

    const parser = new DOMParser();
    const parsedHtml = parser.parseFromString(resContent, 'text/html');
    const extractedText = parsedHtml.body.textContent;

    editedResponse.value = extractedText;
}

function submitResponseEdit(responseId: number, reviewId: number) {
    const response = useForm({
        reply: editedResponse.value,
        resId: responseId,
    });

    response.patch(route(
            'catalyst-explorer.editResponseToMyCommunityReview',
            {assessment: reviewId}
        ),
        {
            preserveScroll: true,
            onSuccess: () => {
                editingId.value = null;
            }
        });
}

</script>
