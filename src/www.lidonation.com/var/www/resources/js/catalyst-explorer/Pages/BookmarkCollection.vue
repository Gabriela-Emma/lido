<template>
    <header-component titleName0="Bookmark" :titleName1="bookmarkCollection?.title"
                      :subTitle="`Created ${$filters.timeAgo(bookmarkCollection.created_at)}. Has ${bookmarkCollection?.items_count} item${bookmarkCollection?.items_count > 1 ? 's' : ''}.`"/>

    <main class="flex flex-col gap-2 bg-primary-20 py-8">
        <div class="container">
            <section
                class="relative flex flex-row justify-between items-end p-6 object-cover shadow-xs rounded-tl-2xl rounded-r-xs"
                :class="[textColor$]"
                :style="{backgroundColor: bookmarkCollection?.color}">

                <div class="flex flex-row justify-end items-center absolute right-0 top-1/3 z-0">
                    <h2 class="text-xl font-bold tracking-tight text-slate-100 sm:text-2xl inline box-border box-decoration-clone bg-white py-4 pl-3 pr-32 rounded-l-lg text-slate-800">
                        {{ bookmarkCollection?.title }}
                    </h2>
                </div>

                <div class="flex z-10 pt-20 gap-3">
                    <Link :href="$utils.localizeRoute('catalyst-explorer/bookmarks')"
                          :class="[textColor$, borderColor$]"
                          class="inline-flex items-center gap-x-0.5 rounded-sm border py-1 px-1.5 text-xs font-semibold text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                        <ArrowUturnLeftIcon class="mr-0.5 h-3 w-3" aria-hidden="true"/>
                        {{ $t("All Bookmarks") }}
                    </Link>
                    <button @click="download"
                            type="button" 
                            :class="[textColor$, borderColor$]"
                            class="inline-flex items-center gap-x-0.5 rounded-sm border py-1 hover:text-teal-600 px-1.5 text-xs font-semibold text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                        <ArrowDownTrayIcon class="mr-0.5 h-3 w-3" aria-hidden="true"/>
                        {{ $t("Export") }} 
                    </button>
                </div>
            </section>

            <section class="rounded-bl-2xl rounded-r-xs py-16 border-t shadow-md bg-white">
                <div class="">
                    <h2 class="text-xl lg:text-2xl xl:text-3xl px-4 sm:px-6">
                        Proposals
                    </h2>
                    <ul role="list" class="divide-y divide-gray-200">
                        <li v-for="item in bookmarkCollection.items" :key="item.id">
                            <div class="block hover:bg-gray-50">
                                <div class="flex items-center px-4 py-4 sm:px-6">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div class="truncate">
                                            <div class="flex flex-col text-lg">
                                                <h3 class="truncate font-medium text-xl xl:text-2xl">
                                                    {{ item.title }}
                                                </h3>
                                                <p v-if="item?.content" class="italic">
                                                    {{item?.content}}
                                                </p>
                                            </div>
                                            <div class="mt-1">
                                                <div class="flex flex-row items-center gap-5 text-sm text-slate-500">
                                                    <div class="flex gap-1 items-center">
                                                        <div>{{ $t("Budget") }}</div>
                                                        <div class="text-slate-700 font-semibold">
                                                            {{ $filters.currency(item?.model?.amount_requested) }}
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div>{{ $t("Fund") }}</div>
                                                        <div class="text-slate-700 font-semibold">
                                                            {{ item?.model?.fund_name }}
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div>{{ $t("Challenge") }}</div>
                                                        <div class="text-slate-700 font-semibold">
                                                            {{ item?.model?.challenge_name }}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                            <!--                                                <div class="flex -space-x-1 overflow-hidden">-->
                                            <!--                                                    <img v-for="applicant in item.applicants" :key="applicant.email" class="inline-block h-6 w-6 rounded-full ring-2 ring-white" :src="applicant.imageUrl" :alt="applicant.name" />-->
                                            <!--                                                </div>-->
                                        </div>
                                    </div>
                                    <div class="ml-5 flex-shrink-0">
                                        <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
        </div>


    </main>
</template>

<script lang="ts" setup>
import {Link, usePage} from '@inertiajs/vue3';
import BookmarkCollection from "../models/bookmark-collection";
import {ChevronRightIcon, ArrowUturnLeftIcon, ArrowDownTrayIcon} from '@heroicons/vue/20/solid';
import {computed, inject} from "vue";
import axios from 'axios';

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        bookmarkCollection: BookmarkCollection
    }>(), {});
const textColor$ = computed<string>(() =>
    $utils?.contrastColor(props.bookmarkCollection?.color) === 'light' ? 'text-white' : 'text-black'
);
const borderColor$ = computed<string>(() =>
    $utils?.contrastColor(props.bookmarkCollection?.color) === 'light' ? 'border-white' : 'border-black'
);


const download = () => {
    const data = {};
    data['locale'] = usePage().props.locale;
    data['hash'] = props.bookmarkCollection.hash;
    const fileName = `${props.bookmarkCollection.title}-proposals.csv`;

    const res = axios.get(`/${usePage().props.locale}/catalyst-explorer/export/bookmarked-proposals`, {
        responseType: 'blob',
        params: data,
    });
    res.then(function(res) {
        const url = window.URL.createObjectURL(new Blob([res.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', fileName);
        document.body.appendChild(link);
        link.click();
    });
}

</script>
