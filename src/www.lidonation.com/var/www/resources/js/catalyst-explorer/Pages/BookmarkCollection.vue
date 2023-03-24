<template>
    <header-component titleName0="Bookmark" :titleName1="bookmarkCollection?.title"
                      :subTitle="`Created ${$filters.timeAgo(bookmarkCollection.created_at)}. Has ${bookmarkCollection?.items_count} items${bookmarkCollection?.items_count > 1 ? 's' : ''}.`" />
<!--    <section class="container pb-4 bg-white">-->
<!--        -->
<!--    </section>-->

    <main class="flex flex-col gap-2 bg-primary-20 py-8">
        <div class="container">
            <section
                class="relative flex flex-row justify-between items-end p-6 object-cover shadow-xs rounded-tl-2xl rounded-r-xs"
                :style="{backgroundColor: bookmarkCollection?.color}">

                <div class="flex flex-row justify-end items-center absolute right-0 top-1/3 z-0">
<!--                    <div class="relative inline-block w-full pointer-events-none overflow-visible mb-2 ml-auto">-->
                        <h2 class="text-xl font-bold tracking-tight text-slate-100 sm:text-2xl inline box-border box-decoration-clone bg-white py-4 pl-3 pr-32 rounded-l-lg text-slate-800">
                            {{ bookmarkCollection?.title }}
                        </h2>
<!--                    </div>-->
                </div>

                <div class="flex z-10 pt-20">
                    <Link :href="$utils.localizeRoute('catalyst-explorer/bookmarks')"
                          class="inline-flex items-center gap-x-0.5 rounded-sm border border-slate-800 py-1 px-1.5 text-xs font-semibold text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                        <ArrowUturnLeftIcon class="mr-0.5 h-3 w-3" aria-hidden="true"/>
                        {{ $t("All Bookmarks") }}
                    </Link>
                </div>
            </section>

            <section class="rounded-bl-2xl rounded-r-xs py-16 border-t shadow-md bg-white">
                <div class="">
                    <h2 class="text-2xl lg:text-3xl xl:text-4xl px-4 py-4 sm:px-6">
                        Proposals
                    </h2>
                    <ul role="list" class="divide-y divide-gray-200">
                        <li v-for="item in bookmarkCollection.items" :key="item.id">
                            <div class="block hover:bg-gray-50">
                                <div class="flex items-center px-4 py-4 sm:px-6">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div class="truncate">
                                            <div class="flex text-sm">
                                                <h3 class="truncate font-medium text-xl xl:text-2xl">
                                                    {{ item.title }}
                                                </h3>
                                            </div>
                                            <div class="mt-1">
                                                <div class="flex flex-row items-center gap-5 text-sm text-slate-500">
                                                    <div class="flex gap-1 items-center">
                                                        <div>{{  $t("Budget") }}</div>
                                                        <div class="text-slate-700">
                                                            {{$filters.currency(item?.model?.amount_requested)}}
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div>{{  $t("Fund") }}</div>
                                                        <div class="text-slate-700">{{item?.model?.fund?.parent?.title}}</div>
                                                    </div>
                                                    <div class="flex gap-1 items-center">
                                                        <div>{{  $t("Challenge") }}</div>
                                                        <div class="text-slate-700">
                                                            {{item?.model?.fund?.title}}
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
import { Link } from '@inertiajs/vue3';
import BookmarkCollection from "../models/bookmark-collection";
import { ChevronRightIcon, ArrowUturnLeftIcon } from '@heroicons/vue/20/solid';

const props = withDefaults(
    defineProps<{
        bookmarkCollection: BookmarkCollection
    }>(), {});

</script>
