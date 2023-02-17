<template>
    <div
        class="w-full bg-white rounded-sm relative flex flex-col justify-start bg-white shadow-sm mb-4 relative break-inside-avoid drip">
        <div class="p-5 break-long-words break-words">
            <div v-html="$filters.markdown(report.content)"></div>
        </div>

        <div class="mt-16 divide-y divide-teal-300 border-t border-teal-300 specs p-5">
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

        <div class="w-full mx-auto bg-slate-100 px-4">
            <div class="flex justify-between items-center py-4">
                <div class="text-teal-800 opacity-75 text-sm inline-flex gap-2 items-center h-full">
                    <span class="bold text-xl">Comments </span>
                    <span>4</span>
                    <span class="font-thin">- coming soon</span>
                </div>

                <button id="message-type" name="message-type"
                        @click="toggleShowComments()" v-html="showComments ? '-' :'+' "
                        class="text-2xl font-medium text-teal-800 hover:text-yellow-600">
                </button>
            </div>

            <div v-show="showComments" class="border-t border-slate-400 border-dashed pb-4">
                <ul x-if="comments">
                    <template v-for="(comment, index) in comments" class="boarder-b-2 ">
                        <li v-text="index"></li>
                    </template>
                </ul>
                <p class="py-4" v-if="!comments?.length">
                    Be the first to leave a comment!
                </p>
                <form class="border-t border-slate-400 border-dashed pt-2" @submit.prevent="addComment">
                    <div class="mb-2">
                        <label for="name" class="block text-sm font-medium text-slate-600">Name </label>
                        <div class="mt-1">
                            <input v-model="commentForm.name" name="name" type="text" autocomplete="name" required
                                    class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="block text-sm font-medium text-slate-600">Email </label>
                        <div class="mt-1">
                            <input  v-model="commentForm.email" name="email" type="email" autocomplete="email" required
                                    class="block w-full appearance-none rounded-sm border border-slate-400 px-3 py-2 placeholder-slate-400 shadow-sm focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">
                        </div>
                    </div>

                    <textarea v-model="commentForm.comment" name="comment" class="border-slate-200" type="text" row="3" placeholder="Give feedback or ask team a question." required></textarea>

                    <button type="submit" class="text-white text-xs px-2 bg-teal-300 hover:bg-teal-800 ml-auto">Post</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {computed, Ref, ref} from "vue";
import Report from "../../models/report";
import {useForm, usePage} from "@inertiajs/vue3";

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

const baseUrl = usePage().props.base_url;
let comments: Ref<Comment[]> = ref([]);
let showComments = ref(false);
let commentForm = useForm({
    name:'',
    email:'',
    comment:'',
});

function toggleShowComments() {
    showComments.value = !showComments.value;
    if (!comments.value?.length) {
        loadComments().then();
    }
}

function addComment() {
    commentForm.post(`${baseUrl}/api/catalyst-explorer/reports/comments/${props.report.id}`);
}

async function loadComments() {
    if (!!comments.value?.length) {
        return;
    }

    await window.axios.get(`${baseUrl}/api/catalyst-explorer/reports/comments/${props.report.id}`, {})
        .then((res) => {
            console.log({res});
            comments.value = [...res.data];
        });
}

</script>
