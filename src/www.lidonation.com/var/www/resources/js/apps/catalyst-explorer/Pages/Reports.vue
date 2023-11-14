<template>
    <header-component titleName0="catalyst" titleName1="Monthly Reports"
                      subTitle="Catalyst Funded Projects Monthly Reporting"/>

    <main class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search
                        :search="search"
                        @search="(term) => ( search = term || null)"></Search>
                </div>
            </div>
        </section>

        <section class="py-8">
            <div class="container">
                <div class="mt-6 columns-1 sm:columns-2 xl:columns-3 gap-4 monthly-reports">
                    <div v-for="report in props.reports?.data">
                        <ReportCard :report="report"/>
                    </div>
                </div>
                <div class="flex my-16 gap-16 xl:gap-24 justify-between items-start w-full">
                    <div class="flex-1">
                        <Pagination :links="props.reports.links"
                                    :per-page="props.perPage"
                                    :total="props.reports?.total"
                                    :from="props.reports?.from"
                                    :to="props.reports?.to"
                                    @perPageUpdated="(payload) => perPageRef = payload"
                                    @paginated="(payload) => currPageRef = payload"/>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script lang="ts" setup>
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import ReportCard from "@apps/catalyst-explorer/modules/reports/ReportCard.vue";
import Search from "@apps/catalyst-explorer/Components/Global/Search.vue";
import Pagination from "@apps/catalyst-explorer/Components/Global/Pagination.vue";
import {VARIABLES} from "@apps/catalyst-explorer/models/variables";
import Report from "@apps/catalyst-explorer/models/report";

const props = withDefaults(
    defineProps<{
        search?: string,
        currPage?: number,
        perPage?: number,
        reports: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Report[]
        }
    }>(), {
        currPage: 1,
        perPage: 24,
    });

let search = ref<string | null>(props.search ?? null);
let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);

watch([search], () => {
    return query();
}, {deep: true});

watch([currPageRef, perPageRef], () => {
    query();
});

function query() {
    const data = {} as any;
    if (search?.value && search.value?.length > 0) {
        data[VARIABLES.SEARCH] = search.value;
    }
    if (currPageRef.value) {
        data[VARIABLES.PAGE] = currPageRef.value;
    }
    if (perPageRef.value) {
        data[VARIABLES.PER_PAGE] = perPageRef.value;
    }

    router.get(
        route('catalyst-explorer.reports'),
        data,
        {preserveState: true, preserveScroll: true}
    );

    //@ts-ignore
    if (typeof window?.fathom !== 'undefined') {
        // @ts-ignore
        window?.fathom?.trackGoal(VARIABLES.TRACKER_ID_MONTHLY_REPORT, 0);
    }
}
</script>
