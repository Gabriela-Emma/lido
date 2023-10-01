<template>
    <header-component titleName0="My Catalyst" titleName1="Proposals" subTitle="" />

    <section class="py-16 bg-primary-20">
        <div class="container">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="px-2 py-6 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav :crumbs="crumbs" />
                </aside>

                <div class="lg:col-span-9 xl:col-span-10">
                    <div class="flex flex-row items-center justify-between w-full px-6 py-2 mb-4 bg-white ">
                        <div class="py-4 flex-0">
                            <h2 class="text-bold text-slate-900">{{ $t("Amount Summary") }}</h2>
                        </div>
                        <div class="flex justify-between flex-1 px-6">
                            <div class="flex flex-col flex-1 p-2">
                                <dd class="order-1 font-semibold text-center xl:text-lg text-slate-900 ">
                                    {{ $filters.currency(totalRemaining) }}
                                </dd>
                                <dt class="order-2 text-xs font-semibold text-center md:text-sm text-slate-500">
                                    {{ $t("Remaining") }}
                                </dt>
                            </div>

                            <div class="flex flex-col flex-1 p-2">
                                <dd class="order-1 font-semibold text-center xl:text-lg text-slate-900">
                                    {{ $filters.currency(totalDistributed) }}
                                </dd>
                                <dt class="order-2 text-xs font-semibold text-center md:text-sm text-slate-500">
                                    {{ $t("Distributed") }}
                                </dt>
                            </div>

                            <div class="flex flex-col flex-1 p-2">
                                <dd class="order-1 font-semibold text-center xl:text-lg text-slate-900 ">
                                    {{ $filters.currency(budgetSummary) }}
                                </dd>
                                <dt class="order-2 text-xs font-semibold text-center md:text-sm text-slate-500">
                                    {{ $t("Awarded") }}
                                </dt>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 space-y-6 bg-white sm:px-6">
                        <div class="">
                            <div class="flex items-center justify-between">
                                <div class="">
                                    <h2 class="leading-6 text-slate-900">{{ $t("My Proposals") }}</h2>
                                </div>
                                <div class="flex items-center justify-between w-1/3 flex-wrap lg:flex-nowrap">
                                    <div class="mr-4">
                                        <Toggle onLabel="Funded proposals " offLabel="All proposals"
                                            v-model="filtersRef.funded" :classes="{
                                                container: 'inline-block rounded-xl outline-none focus:ring focus:ring-teal-500 focus:ring-opacity-30 w-32',
                                                toggle: 'flex w-full h-4 rounded-xl relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                                toggleOn: 'bg-teal-500 border-teal-500 justify-start font-semibold text-white',
                                                toggleOff: 'bg-slate-200 border-slate-200 justify-end font-semibold text-slate-700',
                                                handle: 'inline-block bg-white w-4 h-4 top-0 rounded-xl absolute transition-all',
                                                handleOn: 'left-full transform -translate-x-full',
                                                handleOff: 'left-0',
                                                handleOnDisabled: 'bg-slate-100 left-full transform -translate-x-full',
                                                handleOffDisabled: 'bg-slate-100 left-0',
                                                label: 'text-center w-auto px-2 border-box whitespace-nowrap select-none',
                                            }" />
                                    </div>
                                    <FundPicker v-model="filters.funds" class="border border-1 border-slate-300" />
                                </div>
                            </div>

                            <div
                                class="mt-8 -mx-4 overflow-hidden ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-sm">
                                <table class="min-w-full divide-y divide-slate-300">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">
                                                {{ $t("Title") }}
                                            </th>
                                            <th scope="col"
                                                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-slate-900 sm:table-cell">
                                                $ {{ $t("Remaining") }}
                                            </th>
                                            <th scope="col"
                                                class="hidden px-3 py-3.5 text-left text-sm font-semibold text-slate-900 lg:table-cell">
                                                $ {{ $t("Distributed") }}
                                            </th>

                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">
                                                {{ $t("Total Budget") }}
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">
                                                {{ $t("Fund Project ID") }}
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                <span class="sr-only">{{ $t("Edit") }}</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200 text-slate-900">
                                        <tr v-for="proposal in proposals?.data" :class="{
                                            'text-slate-500': proposal.funding_status !== 'funded' && proposal.fund.status !== 'governance',
                                            'text-teal-800 font-semibold': proposal.fund.status == 'governance',
                                            'font-bold': proposal.funding_status === 'funded'
                                        }">
                                            <td
                                                class="w-full py-4 pl-4 pr-3 text-sm max-w-0 sm:w-auto sm:max-w-none sm:pl-6">
                                                {{ proposal.title }}
                                                <dl class="font-normal lg:hidden">
                                                    <dt class="sr-only">{{ $t("Distributed") }}</dt>
                                                    <dd class="mt-1 truncate text-slate-700">
                                                        {{ $filters.currency(proposal.amount_received, proposal.currency) }}
                                                    </dd>
                                                    <dt class="sr-only sm:hidden">{{ $t("Remaining") }}</dt>
                                                    <dd class="mt-1 truncate text-slate-500 sm:hidden">
                                                        {{
                                                            $filters.currency(proposal.amount_requested -
                                                                proposal.amount_received, proposal.currency)
                                                        }}
                                                    </dd>
                                                </dl>
                                            </td>

                                            <!-- Remaining -->
                                            <td class="hidden px-3 py-4 text-sm sm:table-cell">
                                                <span v-if="proposal.funding_status === 'funded'">
                                                    {{
                                                        $filters.currency(proposal.amount_requested - proposal.amount_received,
                                                            proposal.currency)
                                                    }}
                                                </span>
                                                <span v-else>{{ proposal.fund.status !== 'governance' ? $t("Not funded") :
                                                    $t("-") }}</span>
                                            </td>

                                            <td class="hidden px-3 py-4 text-sm lg:table-cell">
                                                <span v-if="proposal.funding_status === 'funded'">
                                                    {{ $filters.currency(proposal.amount_received, proposal.currency) }}
                                                </span>
                                                <span v-else>{{ proposal.fund.status !== 'governance' ? $t("Not funded") :
                                                    $t("-") }}</span>
                                            </td>

                                            <td class="px-3 py-4 text-sm">
                                                {{ $filters.currency(proposal.amount_requested, proposal.currency) }}
                                            </td>
                                            <td class="px-3 py-4 text-sm">
                                                {{ proposal.meta_data.iog_hash }}
                                            </td>
                                            <td class="py-4 pl-3 pr-4 text-sm text-right sm:pr-6">
                                                <Link
                                                    :href="$utils.localizeRoute(`catalyst-explorer/my/proposals/${proposal.id}`)"
                                                    class="text-teal-600 hover:text-teal-900">{{ $t("Manage") }}<span
                                                    class="sr-only">{{ proposal.title }}</span></Link>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <div class="flex justify-between w-full gap-16 my-16 xl:gap-24">
                                    <div class="flex-1 w-full px-6">
                                        <Pagination :links="props.proposals.links" :per-page="props.perPage"
                                            :total="props.proposals?.total" :from="props.proposals?.from"
                                            :to="props.proposals?.to" @perPageUpdated="(payload) => perPageRef = payload"
                                            @paginated="(payload) => currPageRef = payload" />
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
import { Link, router, usePage } from '@inertiajs/vue3';
import Toggle from '@vueform/toggle'
import Filters from "../../models/filters";
import { VARIABLES } from "../../models/variables";
import { watch, ref, inject } from "vue";
import Pagination from "../../Shared/Components/Pagination.vue";
import FundPicker from "../../modules/funds/FundPicker.vue";

const $utils: any = inject('$utils');
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
        proposals: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Proposal[]
        };
    }>(), {});

let filtersRef = ref(props.filters);
let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);
let filters = ref<Filters>(props.filters);


watch([filtersRef], () => {
    query();
}, { deep: true });

watch([currPageRef, perPageRef], () => {
    query();
});

function query() {
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
    if (filtersRef.value?.funds) {
        data[VARIABLES.FUNDS] = Array.from(filtersRef.value?.funds);
    }

    router.get(
        `${usePage().props.base_url}/catalyst-explorer/my/proposals`,
        data,
        { preserveState: true, preserveScroll: true }
    );
}


</script>
