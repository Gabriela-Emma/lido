<template>
    <Head title="Catalyst Assessments" />

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
                <div class="gap-4 mt-6 columns-1 sm:columns-2 xl:columns-3 monthly-reports">
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
import {ref, watch} from "vue";
import {Head, router} from "@inertiajs/vue3";
import route from "ziggy-js";
import Assessment from "@apps/catalyst-explorer/models/assessment";
import {VARIABLES} from "@apps/catalyst-explorer/models/variables";
import Pagination from "@apps/catalyst-explorer/Components/Global/Pagination.vue";
import AssessmentCard from "@apps/catalyst-explorer/modules/assessments/AssessmentCard.vue";
import Search from "@apps/catalyst-explorer/Components/Global/Search.vue";

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
let currPageRef = ref<number|null>(props.currPage);
let perPageRef = ref<number|null>(props.perPage);

watch([search], () => {
    return query();
}, {deep: true});

watch([currPageRef, perPageRef], () => {
    query();
});

function query() {
    const data = {} as any;
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
        route('catalyst-explorer.assessments'),
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
