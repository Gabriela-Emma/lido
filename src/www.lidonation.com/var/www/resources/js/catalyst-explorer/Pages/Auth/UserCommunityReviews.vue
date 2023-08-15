<template>
    <header-component titleName0="My Catalyst" titleName1="Proposals" subTitle=""/>

    <section class="py-16 bg-primary-20">
        <div class="container">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="px-2 py-6 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav :crumbs="crumbs" />
                </aside>

                <div class="lg:col-span-9 xl:col-span-10">
                    <div class="p-6 space-y-6 bg-white sm:px-6">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="">
                                    <h2 class="leading-6 text-slate-900">{{ $t("My Community Reviews") }}</h2>
                                </div>
                            </div>

                            <div
                                class="py-4 mt-8 -mx-4 ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-sm">
                                <table class="min-w-full divide-y divide-slate-300">
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
                                    <tr v-for="review in reviews?.data">
                                        <td class="w-full py-4 pl-4 pr-3 text-sm max-w-0 sm:w-auto sm:max-w-none sm:pl-6">
                                            {{ review.rating }}
                                        </td>

                                        <!-- Remaining -->
                                        <td class="hidden px-3 py-4 text-sm sm:table-cell">
                                            {{ review.rationale }}
                                        </td>

                                        <td class="hidden px-3 py-4 text-sm lg:table-cell">
                                            <div class="flex flex-col justify-center w-full gap-4 text-center">
                                                <div class="flex flex-col gap-1">
                                                    <span class="font-medium">Id</span>
                                                    <span class="font-bold">
                                                        {{ review.meta_data?.assessor_id }}
                                                    </span>
                                                </div>
                                                <div class="flex flex-col gap-1">
                                                    <span>Level</span>
                                                    <span class="font-bold">
                                                        {{ review.meta_data?.assessor_level }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- <td class="px-3 py-4 text-sm">
                                            15th
                                        </td> -->
                                        <td class="py-4 pl-3 pr-4 text-sm text-right sm:pr-6">
                                            <!-- <Link
                                                :href="$utils.localizeRoute(`catalyst-explorer/my/proposals/${proposal.id}`)"
                                                class="text-teal-600 hover:text-teal-900">{{ $t("Manage") }}<span
                                                class="sr-only">{{ proposal.title }}</span></Link> -->
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <div class="flex justify-between w-full gap-16 my-16 xl:gap-24">
                                    <div class="flex-1 w-full px-6">
                                        <Pagination :links="props.reviews.links"
                                                    :per-page="props.perPage"
                                                    :total="props.reviews?.meta?.total"
                                                    :from="props.reviews?.meta?.from"
                                                    :to="props.reviews?.meta?.to"
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
import UserNav from "./UserNav.vue";
import Proposal from "../../models/proposal";
import {Link, router, usePage} from '@inertiajs/vue3';
import Filters from "../../models/filters";
import { VARIABLES } from "../../models/variables";
import {watch, ref, inject} from "vue";
import Pagination from "../../Shared/Components/Pagination.vue";
import Assessment from "../../models/assessment";

const $utils: any = inject('$utils');
const props = withDefaults(
    defineProps<{
        locale: string,
        filters:Filters,
        totalDistributed: number,
        totalRemaining: number,
        budgetSummary: number,
        currPage?: number,
        perPage?: number,
        crumbs: [],
        reviews: {
            data: Assessment[]
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

watch([filtersRef], () => {
   query();
}, {deep: true});

watch([currPageRef, perPageRef], () => {
    query();
});

function query()
{
    const data = {};

    if (currPageRef.value) {
        data[VARIABLES.PAGE] = currPageRef.value;
    }
    if (perPageRef.value) {
        data[VARIABLES.PER_PAGE] = perPageRef.value;
    }
    if (!filtersRef.value?.funded) {
        data[VARIABLES.FUNDED_PROPOSALS] = 0;
    }

    router.get(
        `${usePage().props.base_url}/catalyst-explorer/my/reviews`,
        data,
        {preserveState: true, preserveScroll: true}
    );
}


</script>
