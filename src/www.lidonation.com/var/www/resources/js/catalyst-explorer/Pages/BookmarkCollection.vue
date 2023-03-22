<template>
    <header-component titleName0="Bookmark" :titleName1="bookmarkCollection?.title"
                      :subTitle="`Created ${$filters.timeAgo(bookmarkCollection.created_at)}. Has ${bookmarkCollection?.items_count} items${bookmarkCollection?.items_count > 1 ? 's' : ''}.`"/>

    <main class="flex flex-col gap-2 bg-primary-20 py-8">
        <div class="container">
            <section
                class="relative flex flex-col items-center px-3 py-16 object-cover shadow-xs rounded-tl-2xl rounded-r-xs"
                :style="{backgroundColor: bookmarkCollection?.color}">
                <div class="w-full flex flex-col justify-center relative">
                    <div class="relative inline-block w-full pointer-events-none overflow-visible mb-2 ml-auto">
                        <h2 class="text-xl font-bold tracking-tight text-slate-100 sm:text-2xl inline box-border box-decoration-cloe bg-white py-4 pl-3 pr-32 mb-3 rounded-l-lg text-slate-800 absolute -right-3">
                            {{ bookmarkCollection?.title }}
                        </h2>
                    </div>
                </div>
            </section>

            <section class="rounded-bl-2xl rounded-r-xs py-16 border-t shadow-md bg-white">
                <div class="">
                    <ul role="list" class="divide-y divide-gray-200">
                        <li v-for="item in bookmarkCollection.items" :key="item.id">
                            <a href="#" class="block hover:bg-gray-50">
                                <div class="flex items-center px-4 py-4 sm:px-6">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div class="truncate">
                                            <div class="flex text-sm">
                                                <p class="truncate font-medium text-indigo-600">{{ item.title }}</p>
                                                <p class="ml-1 flex-shrink-0 font-normal text-gray-500">in
                                                    {{ item.id }}</p>
                                            </div>
                                            <div class="mt-2 flex">
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <CalendarIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                                                                  aria-hidden="true"/>
                                                    <p>
                                                        Closing on
                                                        {{ ' ' }}
                                                        <time :datetime="item.created_at">{{
                                                                item.created_at
                                                            }}
                                                        </time>
                                                    </p>
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
                            </a>
                        </li>
                    </ul>
                </div>
            </section>
        </div>


    </main>
</template>

<script lang="ts" setup>
import BookmarkCollection from "../models/bookmark-collection";
import { CalendarIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'

const props = withDefaults(
    defineProps<{
        bookmarkCollection: BookmarkCollection
    }>(), {});

    console.log('bookmarkCollection::', props.bookmarkCollection)
</script>
