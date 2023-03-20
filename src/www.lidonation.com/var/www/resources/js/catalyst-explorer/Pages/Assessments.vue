<template>
    <header-component titleName0="catalyst" titleName1="Proposal Assessments" subTitle="Catalyst Proposal Assessments"/>

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
                <div class="flex-1 pb-16 mt-10">
                    <Pagination :links="props.assessments.links"
                                :per-page="props.perPage"
                                :total="props.assessments?.total"
                                :from="props.assessments?.from"
                                :to="props.assessments?.to"
                                @perPageUpdated="(payload) => perPageRef = payload"
                                @paginated="(payload) => currPageRef = payload"/>
                </div>
            </div>
        </section>
    </main>
</template>

<script lang="ts" setup>
import Search from "../Shared/Components/Search.vue";
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import {VARIABLES} from "../models/variables";
import AssessmentCard from "../modules/assessments/AssessmentCard.vue";
import Assessment from "../models/assessment";
import Pagination from "../Shared/Components/Pagination.vue";

const props = withDefaults(
    defineProps<{
        search?: string,
        currPage?: number,
        perPage?: number,
        assessments: {
            links: [],
            total: number,
            to: number,
            from: number,
            data: Assessment[]
        }
    }>(), {});

let search = ref(props.search);
let currPageRef = ref<number>(props.currPage);
let perPageRef = ref<number>(props.perPage);

watch([search], () => {
    return query();
}, {deep: true});

watch([currPageRef, perPageRef], () => {
    query();
});

function query() {
    const data = {};
    if (search.value?.length > 0) {
        data[VARIABLES.SEARCH] = search.value;
    }
    if (currPageRef.value) {
        data[VARIABLES.PAGE] = currPageRef.value;
    }
    if (perPageRef.value) {
        data[VARIABLES.PER_PAGE] = perPageRef.value;
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
