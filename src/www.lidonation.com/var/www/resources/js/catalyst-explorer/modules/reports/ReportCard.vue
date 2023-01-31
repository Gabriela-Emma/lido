<template>
    <div
        class="p-5 w-full bg-white rounded-sm relative flex flex-col justify-start bg-white shadow-sm mb-4 relative break-inside-avoid drip">
        <div class="break-long-words break-words">
            <div v-html="$filters.markdown(report.content)"></div>
        </div>

        <div class="mt-16 divide-y divide-teal-300 border-t border-teal-300 specs">
            <div class="flex flex-row gap-4 justify-between items-center py-4 spec-amount-received">
                <div class="text-teal-800 opacity-50 text-sm">Disbursed to Date</div>
                <div class="text-teal-800 font-bold text-base">
                    {{ $filters.currency(report.proposal.amount_received) }}
                </div>
            </div>

            <div class="flex flex-row gap-4 justify-between items-center py-4 spec-title">
                <div class="text-teal-800 opacity-50 text-sm">Proposal</div>
                <a class="text-teal-800 font-medium inline-flex text-base hover:text-yellow-500"
                   target="_blank" :href="$utils.localizeRoute(`proposals/${report?.proposal?.slug}`)">
                    {{ report.proposal.title }}
                </a>
            </div>
            <div class="flex flex-row gap-4 justify-between items-center py-4">
                <div class="text-teal-800 opacity-50 text-sm">Status</div>
                <div class="text-teal-800 font-medium text-base">
                    {{ report.project_status || '-' }}
                </div>
            </div>
            <div class="flex flex-row gap-4 justify-between items-center py-4">
                <div class="text-teal-800 opacity-50 text-sm">
                    Completion Target
                </div>
                <div class="text-teal-800 font-medium text-base">
                    {{ report.completion_target || '-' }}
                </div>
            </div>
        </div>

        <!--                        @if(report.attachments->isNotEmpty())-->
        <!--                        <div class="flex flex-row gap-4 justify-between items-center py-4">-->
        <!--                            <div class="text-teal-800 opacity-50 text-sm">Attachment(s)</div>-->
        <!--                            <div class="text-teal-800 font-medium text-right text-base">-->
        <!--                                @foreach(report.attachments as $attachment)-->
        <!--                                <a target="_blank" class="font-medium hover:text-yellow-500 px-1 py-0.5 border border-teal-600 rounded-sm text-xs inline-flex flex-row flex-nowrap gap-2 hover:bg-teal-600" href="{{$attachment}}">-->
        <!--                                    <span class="inline-flex">Evidence {{$loop->iteration}}</span>-->
        <!--                                    <span class="inline-flex">-->
        <!--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">-->
        <!--                                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />-->
        <!--                                </svg>-->
        <!--                            </span>-->
        <!--                                </a>-->
        <!--                                @endforeach-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                        @endif-->
    </div>
</template>

<script lang="ts" setup>
import {computed} from "vue";
import Report from "../../models/report";

const props = withDefaults(
    defineProps<{
        report: Report
    }>(),
    {
        report: () => {
            return {} as Report;
        },
    },
);

// computer properties
// const authors = computed(() => {
//     return props.proposal.users?.reverse().map((user) => {
//         return {
//             ...user,
//             avatar: user.media?.length > 0 ? user.media[0]?.original_url : user.profile_photo_url
//         }
//     })
// });

</script>
