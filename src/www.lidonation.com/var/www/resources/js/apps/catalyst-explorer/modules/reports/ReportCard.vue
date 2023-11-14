<template>
    <div
        class="relative flex flex-col justify-start w-full mb-4 bg-white rounded-sm shadow-sm break-inside-avoid drip"
    >
        <div class="p-5 break-words break-long-words ">
            <div v-html="$filters.markdown(report.content)"></div>
        </div>

        <div class="p-5 mt-16 divide-y divide-teal-300 specs">
            <div v-if="user$" class="py-4 border-t border-teal-300">
                <ul class="flex flex-row items-center justify-end gap-3">
                    <div v-for="(reaction, index) in Object.keys(reactionsCount)" :key="index">
                        <li
                            class="flex flex-row gap-1 p-1 text-xs border rounded-sm cursor-pointer border-slate-600 hover:border-green-500"
                            @click.prevent="addReaction(reaction)"
                        >
                            <button
                                v-html="reaction"
                            ></button>
                            <span class=""
                                  v-html="reactionsCount[reaction]"></span>
                        </li>
                    </div>
                </ul>
            </div>

            <div
                class="flex flex-row items-center justify-between gap-4 py-4 spec-amount-received"
            >
                <div class="text-sm text-teal-800 opacity-50">
                    {{ $t('Disbursed to Date') }}
                </div>
                <div class="text-base font-bold text-teal-800">
                    {{ $filters.currency(report.proposal.amount_received) }}
                </div>
            </div>

            <div
                class="flex flex-row items-center justify-between gap-4 py-4 spec-title"
            >
                <div class="text-sm text-teal-800 opacity-50">{{ $t('Proposal') }}</div>
                <a
                    class="inline-flex text-base font-medium text-teal-800 hover:text-yellow-500"
                    target="_blank"
                    :href="
                        $utils.localizeRoute(
                            `proposals/${report?.proposal?.slug}`
                        )
                    "
                >
                    {{ report.proposal.title }}
                </a>
            </div>

            <div class="flex flex-row items-center justify-between gap-4 py-4">
                <div class="text-sm text-teal-800 opacity-50">Status{{ $t('') }}</div>
                <div class="text-base font-medium text-teal-800">
                    {{ report.project_status || "-" }}
                </div>
            </div>

            <div class="flex flex-row items-center justify-between gap-4 py-4">
                <div class="text-sm text-teal-800 opacity-50">
                    {{ $t('Completion Target') }}
                </div>
                <div class="text-base font-medium text-teal-800">
                    {{ report.completion_target || "-" }}
                </div>
            </div>

            <!--                        @if(report.attachments->isNotEmpty())-->
            <!--                        <div class="flex flex-row items-center justify-between gap-4 py-4">-->
            <!--                            <div class="text-sm text-teal-800 opacity-50">Attachment(s)</div>-->
            <!--                            <div class="text-base font-medium text-right text-teal-800">-->
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

        <div class="w-full px-4 mx-auto bg-slate-100">
            <div class="flex items-center justify-between py-4">
                <div
                    class="inline-flex items-center h-full gap-2 text-sm text-teal-800 opacity-75"
                >
                    <span class="text-xl bold">{{ $t('Comments') }} </span>
                    <span>{{ report.comments_count }}</span>
                </div>

                <button
                    id="message-type"
                    name="message-type"
                    @click="toggleShowComments()"
                    v-html="showComments ? '-' : '+'"
                    class="text-2xl font-medium text-teal-800 hover:text-yellow-600"
                ></button>
            </div>

            <div v-show="showComments" class="pb-4">
                <ul x-if="comments" class="divide-y divide-slate-100">
                    <template v-for="comment in comments">
                        <li
                            v-if="comment.text != ''"
                            :key="comment?.id"
                            class="relative px-4 py-5 bg-white focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 hover:bg-gray-50"
                        >
                            <div
                                class="flex justify-between space-x-3 text-sm font-medium text-gray-600"
                            >
                                <div class="flex-1 min-w-0">
                                    <span
                                        class="absolute inset-0"
                                        aria-hidden="true"
                                    />
                                    <p class="truncate">
                                        {{ comment.commentator?.name }}
                                    </p>
                                </div>
                                <timeago
                                    class=""
                                    :datetime="comment.created_at"
                                />
                            </div>
                            <div class="mt-1">
                                <p
                                    class="text-gray-700 text-md"
                                    v-html="comment.text"
                                ></p>
                            </div>
                        </li>
                    </template>
                </ul>
                <div>
                    <form class="" @submit.prevent="addComment" v-if="user$">
                        <div v-if="!commentPosted">
                            <p class="pt-4">
                                <span v-if="!comments?.length">
                                    {{ $t('Be the first to leave a comment') }}!
                                </span>
                                <span
                                    class="relative text-xs font-bold top-1"
                                    v-else
                                >{{ $t('Leave a Comment') }}</span
                                >
                            </p>

                            <!--                        <div class="mb-2">-->
                            <!--                            <label for="name" class="block text-sm font-medium text-slate-600">Name </label>-->
                            <!--                            <div class="mt-1">-->
                            <!--                                <input v-model="commentForm.name" name="name" type="text" autocomplete="name" required-->
                            <!--                                       class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">-->
                            <!--                            </div>-->
                            <!--                        </div>-->

                            <!--                        <div class="mb-2">-->
                            <!--                            <label for="email" class="block text-sm font-medium text-slate-600">Email </label>-->
                            <!--                            <div class="mt-1">-->
                            <!--                                <input v-model="commentForm.email" name="email" type="email" autocomplete="email"-->
                            <!--                                       required-->
                            <!--                                       class="block w-full px-3 py-2 border rounded-sm shadow-sm appearance-none border-slate-400 placeholder-slate-400 focus:border-teal-500 focus:outline-none focus:ring-teal-500 sm:text-sm">-->
                            <!--                            </div>-->
                            <!--                        </div>-->

                            <textarea
                                v-model="commentForm.comment"
                                name="comment"
                                class="mt-0"
                                rows="4"
                                placeholder="Give feedback or ask the team a question."
                                required
                            ></textarea>

                            <button
                                type="submit"
                                class="px-2 ml-auto text-xs text-white bg-teal-300 hover:bg-teal-800"
                            >
                                {{ $t('Post') }}
                            </button>
                        </div>
                        <div v-if="commentPosted">
                            <div class="p-4 bg-teal-100 rounded-sm">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <CheckCircleIcon
                                            class="w-5 h-5 text-green-400"
                                            aria-hidden="true"
                                        />
                                    </div>
                                    <div class="ml-3">
                                        <p
                                            class="text-sm font-medium text-green-800"
                                        >
                                            {{ $t('Successfully Submitted') }}
                                        </p>
                                    </div>
                                    <div class="pl-3 ml-auto">
                                        <div class="-mx-1.5 -my-1.5">
                                            <button
                                                type="button"
                                                class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50"
                                            >
                                                <CheckCircleIcon
                                                    class="w-5 h-5"
                                                ></CheckCircleIcon>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div
                        v-else
                        class="p-2 mt-2 space-y-2 text-center bg-white/50"
                    >
                        <p>{{ $t('Login or Register to leave a comment') }}!</p>
                        <div class="flex items-center justify-center gap-3">
                            <Link
                                :href="$utils.localizeRoute(`catalyst-explorer/auth/login`)"
                                class="font-bold text-teal-600 hover:text-teal-500"
                            >
                                {{ $t('Sign in') }}
                            </Link>
                            <Link
                                href="/catalyst-explorer/register"
                                class="font-bold text-teal-600 hover:text-teal-500"
                            >
                                {{ $t('Register') }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";
import {Ref, ref, reactive, inject} from "vue";
import Report from "../../models/report";
import Comment from "../../models/comment";
import {useForm, usePage} from "@inertiajs/vue3";
import {CheckCircleIcon} from "@heroicons/vue/20/solid";
import { storeToRefs } from "pinia";
import { useUserStore } from "@/global/stores/user-store";

const $utils: any = inject('$utils');
const props = withDefaults(
    defineProps<{
        locale?: string;
        report: Report;
    }>(),
    {
        report: () => {
            return {} as Report;
        },
    }
);

const userStore = useUserStore();
const {user$} = storeToRefs(userStore);
const baseUrl = usePage().props.base_url;
let comments: Ref<Comment[]> = ref([]);
let showComments = ref(false);
let showCommentsInitialized = false;
let commentPosted = ref(false);
let commentForm = useForm({
    name: "",
    email: "",
    comment: "",
});

function toggleShowComments() {
    showComments.value = !showComments.value;
    if (!showCommentsInitialized) {
        loadComments().then();
    }
}

let reactionsCount = reactive({
    "❤️": props.report.hearts_count,
    "👍": props.report.thumbs_up_count,
    "🎉": props.report.party_popper_count,
    "🚀": props.report.rocket_count,
    "👎": props.report.thumbs_down_count,
    "👀": props.report.eyes_count
})

function addComment() {
    commentForm.post(
        `${baseUrl}/api/catalyst-explorer/reports/comments/${props.report.id}`,
        {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => (commentPosted.value = true),
        }
    );
}

async function loadComments() {
    if (showCommentsInitialized) {
        return;
    }

    await window.axios
        .get(
            `${baseUrl}/api/catalyst-explorer/reports/comments/${props.report.id}`,
            {}
        )
        .then((res) => {
            showCommentsInitialized = true;
            comments.value = [...res.data];
        });
}

async function addReaction(reaction) {
    let data = {
        comment: reaction,
    };
    const res = await window.axios.post(`${baseUrl}/api/catalyst-explorer/react/report/${props.report.id}`,data);

    reactionsCount["❤️"] = res.data.hearts_count;
    reactionsCount["👍"] = res.data.thumbs_up_count;
    reactionsCount["🎉"] = res.data.party_popper_count;
    reactionsCount["🚀"] = res.data.rocket_count;
    reactionsCount["👎"] = res.data.thumbs_down_count;
    reactionsCount["👀"] = res.data.eyes_count;
}

</script>
