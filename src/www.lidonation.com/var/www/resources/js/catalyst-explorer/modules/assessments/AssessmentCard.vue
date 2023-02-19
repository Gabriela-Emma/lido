<template>
    <div
        class="w-full bg-white rounded-sm relative flex flex-col justify-start bg-white shadow-sm mb-4 relative break-inside-avoid drip">
        <div class="p-5 break-long-words break-words">
            <div v-html="$filters.markdown(assessment.rationale)"></div>
        </div>

        <div class="mt-16 divide-y divide-teal-300 border-t border-teal-300 specs p-5">
<!--            <div class="flex flex-row gap-4 justify-between items-center py-4 spec-amount-received">-->
<!--                <div class="text-teal-800 opacity-50 text-sm">Disbursed to Date</div>-->
<!--                <div class="text-teal-800 font-bold text-base">-->
<!--                    {{ $filters.currency(assessment.proposal.amount_received) }}-->
<!--                </div>-->
<!--            </div>-->

            <div class="flex flex-row gap-4 justify-between items-center py-4 spec-title">
                <div class="text-teal-800 opacity-50 text-sm">Proposal</div>
                <a class="text-teal-800 font-medium inline-flex text-base hover:text-yellow-500"
                   target="_blank" :href="$utils.localizeRoute(`proposals/${assessment?.proposal?.slug}`)">
                    {{ assessment.proposal.title }}
                </a>
            </div>

<!--            <div class="flex flex-row gap-4 justify-between items-center py-4">-->
<!--                <div class="text-teal-800 opacity-50 text-sm">Status</div>-->
<!--                <div class="text-teal-800 font-medium text-base">-->
<!--                    {{ assessment.project_status || '-' }}-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="flex flex-row gap-4 justify-between items-center py-4">-->
<!--                <div class="text-teal-800 opacity-50 text-sm">-->
<!--                    Completion Target-->
<!--                </div>-->
<!--                <div class="text-teal-800 font-medium text-base">-->
<!--                    {{ assessment.completion_target || '-' }}-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</template>

<script lang="ts" setup>
import {computed, Ref, ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import User from "../../models/user";
import Assessment from "../../models/assessment";


const props = withDefaults(
    defineProps<{
        locale?: string,
        assessment: Assessment
    }>(),
    {
        assessment: () => {
            return {} as Assessment;
        },
    },
);

const user = computed(() => usePage().props?.user as User);
</script>
