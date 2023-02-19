<template>
    <div
        class="w-full bg-white rounded-sm relative flex flex-col justify-start bg-white shadow-sm mb-4 relative break-inside-avoid drip">
        <div class="p-5 break-long-words break-words">
            <div v-html="$filters.markdown(assessment.rationale)"></div>
        </div>

        <div class="mt-16 divide-y divide-teal-300 specs p-5">
            <div class="flex flex-row gap-4 justify-between border-t border-teal-300 items-center py-4 spec-amount-received">
                <div class="text-teal-800 opacity-50 text-sm">Assessor</div>
                <div class="text-teal-800 font-bold text-base">
                    {{ assessment.assessor }}
                </div>
            </div>
            <div class="flex flex-row gap-4 justify-between items-center py-4 spec-amount-received">
                <div class="text-teal-800 opacity-50 text-sm">Rating</div>
                <div>
                    <Rating :modelValue="assessment.rating" :stars="5" :readonly="true" :cancel="false">
                        <template #onicon>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                 class="w-4 h-4 text-teal-500">
                                <path
                                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                            </svg>
                        </template>
                        <template #officon>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                            </svg>
                        </template>
                    </Rating>
                </div>
            </div>

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
import Rating from 'primevue/rating';


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
