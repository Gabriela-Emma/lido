<template>
    <header-component titleName0="Catalyst" titleName1="Monthly Reports" subTitle="Catalyst Funded Projects Monthly Reporting"/>

    <main class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search
                        :search="search"
                        @search="(term) => search=term"></Search>
<!--                    <div class="h-full">-->
<!--                        <button @click="showFilters = !showFilters"-->
<!--                                class="h-full text-xs lg:text-base hover:text-yellow-500 focus:outline-none flex flex-nowrap gap-1 items-center px-0.5 lg:px-2 border border-white border-l-0"-->
<!--                                :class="{-->
<!--                                    'bg-slate-200 text-slate-600': !showFilters && !filtering,-->
<!--                                    'border-teal-500': !showFilters && search,-->
<!--                                    'border-white': !showFilters && !search,-->
<!--                                    'border-teal-500 bg-teal-500 text-white': showFilters || filtering-->
<!--                                }"-->
<!--                        >-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"-->
<!--                                 stroke="currentColor" class="w-4 lg:w-6 w-4 lg:h-6">-->
<!--                                <path stroke-linecap="round" stroke-linejoin="round"-->
<!--                                      d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5"/>-->
<!--                            </svg>-->
<!--                            <span>Filters</span>-->
<!--                        </button>-->
<!--                    </div>-->
                </div>
            </div>
        </section>

        <section class="py-8">
            <div class="container">
                <div class="mt-6 columns-1 sm:columns-2 xl:columns-3 gap-4 monthly-reports">
                    <div v-for="report in props.reports?.data">
                        <ReportCard :report="report" />
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script lang="ts" setup>
import Report from "../models/report";
import ReportCard from "../modules/reports/ReportCard.vue";
import Search from "../Shared/Components/Search.vue";
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import {VARIABLES} from "../models/variables";

const props = withDefaults(
    defineProps<{
        search?: string,
        reports: {
            links: [],
            data: Report[]
        }
    }>(), {});

let search = ref(props.search);

watch([search],() => {
    return query();
}, {deep: true});

function query() {
    const data = {};
    if (search.value?.length > 0) {
        data[VARIABLES.SEARCH] = search.value;
    }

    router.get(
        "/catalyst-explorer/reports",
        data,
        {preserveState: true, preserveScroll: true}
    );

    //@ts-ignore
    if (typeof window?.fathom !== 'undefined') {
        // @ts-ignore
        window?.fathom?.trackGoal(VARIABLES.MONTHLY_REPORT_TRACKER_ID, 0);
    }
}
</script>
