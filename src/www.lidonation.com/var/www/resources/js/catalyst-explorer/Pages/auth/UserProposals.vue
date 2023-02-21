<template>
    <header-component titleName0="My Catalyst" titleName1="Proposals" subTitle=""/>

    <section class="py-16 bg-primary-20">
        <div class="container">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="py-6 px-2 sm:px-6 lg:col-span-3 xl:col-span-2 lg:py-0 lg:px-0">
                    <UserNav/>
                </aside>

                <div class="lg:col-span-9 xl:col-span-10">
                    <div class="flex flex-row  w-full justify-between items-center bg-white  mb-4 py-2 px-6 ">
                        <div class="flex-0 py-4">
                            <h2 class="text-bold text-slate-900">Amount Summary</h2>
                        </div>
                        <div class="flex justify-between flex-1 px-6">
                            <div class="flex flex-1 flex-col p-2">
                                <dd class="order-1 text-center xl:text-lg font-semibold text-slate-900">
                                    {{ $filters.currency(totalDistributed) }}
                                </dd>
                                <dt class="order-2 text-xs  text-center md:text-sm font-semibold text-slate-500">
                                    Distributed
                                </dt>
                            </div>
                            <div class="flex flex-1 flex-col p-2">
                                <dd class="order-1 text-center xl:text-lg font-semibold text-slate-900 ">
                                    {{ $filters.currency(totalRemaining) }}
                                </dd>
                                <dt class="order-2 text-xs text-center md:text-sm  font-semibold text-slate-500">
                                    Remaining
                                </dt>
                            </div>
                            <div class="flex flex-1 flex-col p-2">
                                <dd class="order-1 text-center xl:text-lg font-semibold text-slate-900 ">
                                    {{ $filters.currency(budgetSummary) }}
                                </dd>
                                <dt class="order-2 text-center text-xs md:text-sm  font-semibold text-slate-500">
                                    Awarded
                                </dt>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6 sm:px-6  bg-white p-6">
                        <div class="">
                            <div>
                                <h2 class="leading-6 text-slate-900">My Proposals</h2>
                            </div>

                            <div
                                class="-mx-4 mt-8 overflow-hidden ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-sm">
                                <table class="min-w-full divide-y divide-slate-300">
                                    <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 sm:pl-6">
                                            Title
                                        </th>
                                        <th scope="col"
                                            class="hidden px-3 py-3.5 text-left text-sm font-semibold text-slate-900 lg:table-cell">
                                            $ Distributed
                                        </th>
                                        <th scope="col"
                                            class="hidden px-3 py-3.5 text-left text-sm font-semibold text-slate-900 sm:table-cell">
                                            $ Remaining
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">
                                            Total Budget
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                    <tr v-for="proposal in proposals?.data">
                                        <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-slate-900 sm:w-auto sm:max-w-none sm:pl-6">
                                            {{ proposal.title }}
                                            <dl class="font-normal lg:hidden">
                                                <dt class="sr-only">Distributed</dt>
                                                <dd class="mt-1 truncate text-slate-700">
                                                    {{ $filters.currency(proposal.amount_received) }}
                                                </dd>
                                                <dt class="sr-only sm:hidden">Remaining</dt>
                                                <dd class="mt-1 truncate text-slate-500 sm:hidden">
                                                    {{
                                                        $filters.currency(proposal.amount_requested - proposal.amount_received)
                                                    }}
                                                </dd>
                                            </dl>
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-slate-500 lg:table-cell">
                                            {{ $filters.currency(proposal.amount_received) }}
                                        </td>
                                        <td class="hidden px-3 py-4 text-sm text-slate-500 sm:table-cell">
                                            {{
                                                $filters.currency(proposal.amount_requested - proposal.amount_received)
                                            }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-slate-500">
                                            {{ $filters.currency(proposal.amount_requested) }}
                                        </td>
                                        <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <Link
                                                :href="$utils.localizeRoute(`catalyst-explorer/my/proposals/${proposal.id}`)"
                                                class="text-teal-600 hover:text-teal-900">Manage<span
                                                class="sr-only">{{ proposal.title }}</span></Link>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
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
<<<<<<< HEAD
import {Link, router} from '@inertiajs/vue3';
import {computed, ref, watch} from "vue";
import Filters from "../../models/filters";
import {VARIABLES} from "../../models/variables";


=======
import {Link, useForm} from '@inertiajs/vue3';
import {computed, ref} from "@vue/reactivity";
>>>>>>> 2eaadc6fe2024657d247679e2ffd903d032ce12f

const props = withDefaults(
    defineProps<{
        locale: string,
        filters:Filters,
        totalDistributed: number,
        totalRemaining: number,
        budgetSummary: number,
        proposals: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Proposal[]
        };
    }>(), {});


<<<<<<< HEAD
const filtering = computed(() => {
return getFiltering();
});

let filtersRef = ref<Filters>(props.filters);

watch([filtersRef],() =>{
    query();
}, {deep: true});

function getFiltering()
{
    if (!!props.filters.fundingStatus) {
        return true; 
    }
    return false ;
}

function query()
{
    const data = {};
    if (filtersRef.value?.fundingStatus) {
        data[VARIABLES.FUNDING_STATUS] = filtersRef.value?.fundingStatus;
    }

    router.get(
        `/${props.locale}/catalyst-explorer/myProposals`,
        data,
        {preserveState: true, preserveScroll:true}
    );
    
}

=======
>>>>>>> 2eaadc6fe2024657d247679e2ffd903d032ce12f

</script>
