<template>
    <header-component titleName0="Catalyst" titleName1="Proposal Assessments" subTitle="Catalyst Proposal Assessments"/>

    <main class="flex flex-col gap-2 bg-primary-20">
        <section class="py-8">
            <div class="container">
                <div class="flex items-center w-full h-10 lg:h-16">
                    <Search
                        :search="search"
                        @search="(term) => search=term"></Search>
                </div>
            </div>
        </section>

        <section class="py-8">
            <div class="container">
                <div class="mt-6 columns-1 sm:columns-2 xl:columns-3 gap-4 monthly-reports">
                    <div v-for="assessment in props.assessments?.data">
                        <AssessmentCard :assessment="assessment"/>
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
import AssessmentCard from "../modules/assessments/AssessmentCard.vue";
import Assessment from "../models/assessment";

const props = withDefaults(
    defineProps<{
        search?: string,
        assessments: {
            links: [],
            data: Assessment[]
        }
    }>(), {});

let search = ref(props.search);

watch([search], () => {
    return query();
}, {deep: true});

function query() {
    const data = {};
    if (search.value?.length > 0) {
        data[VARIABLES.SEARCH] = search.value;
    }

    router.get(
        "/catalyst-explorer/assessments",
        data,
        {preserveState: true, preserveScroll: true}
    );

    // @ts-ignore
    if (typeof window?.fathom !== 'undefined') {
        // @ts-ignore
        window?.fathom?.trackGoal(VARIABLES.TRACKER_ID_PA, 0);
    }
}
</script>
