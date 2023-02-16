<template>
    <div class="overflow-hidden bg-white sm:rounded-sm">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg xl:text-xl font-medium leading-6 text-slate-900">
                {{group.name}} - <span class="font-black font-bold text-sm">Coming soon</span>
            </h3>
            <div class="flex gap-4 text-slate-400">
                <div class="flex gap-1 ">
                    <div>Total Proposals</div>
                    <div class="font-semibold">-</div>
                </div>
                <div class="flex gap-1">
                    <div>Total Awarded</div>
                    <div class="font-semibold">-</div>
                </div>
                <div class="flex gap-1">
                    <div>Total Received</div>
                    <div class="font-semibold">-</div>
                </div>
                <div class="flex gap-1">
                    <div>Funding Remaining</div>
                    <div class="font-semibold">-</div>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate-500">
                        Admin
                    </dt>
                    <dd class="mt-1 text-md text-slate-900">
                        {{group?.owner?.name}}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate-500">
                        Group Name
                    </dt>
                    <dd class="mt-1 text-md text-slate-900">
                        {{group.name}}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-slate-500">
                        Website
                    </dt>
                    <dd class="mt-1 text-md text-slate-900">
                        {{group.website}}
                    </dd>
                </div>

                <div class="flex gap-8 sm:col-span-2 w-full relative">
                     <div class="absolute block left-3 -top-1.5 bg-white rounded-sm text-xs px-2">
                        Community & Support Links
                    </div>
                    <div class="border divide-x space-x-8 flex gap-8 p-2 sm:col-span-2 w-full">
                        <div class="flex flex-col flex-1 justify-center p-2 pl-3">
                            <dt class="text-sm font-medium text-slate-500">twitter</dt>
                            <dd class="mt-1 text-md text-slate-900">
                                {{group.twitter || '-' }}
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-8">
                            <dt class="text-sm font-medium text-slate-500">discord</dt>
                            <dd class="mt-1 text-md text-slate-900">
                                {{group.discord || '-' }}
                            </dd>
                        </div>
                        <div class="flex flex-col flex-1 justify-center p-2 pl-8">
                            <dt class="text-sm font-medium text-slate-500">github org</dt>
                            <dd class="mt-1 text-md text-slate-900">
                                {{group.github || '-' }}
                            </dd>
                        </div>
                    </div>
                </div>



                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-slate-500">About</dt>
                    <dd class="mt-1 text-sm text-slate-900 pr-16 xl:pr-20">
                        {{group.bio}}
                    </dd>
                </div>


                <div class="sm:col-span-2 hidden">
                    <dt class="text-sm font-medium text-slate-500">Attachments</dt>
                    <dd class="mt-1 text-sm text-slate-900">
                        <ul role="list" class="divide-y divide-slate-200 rounded-md border border-slate-200">
                            <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                <div class="flex w-0 flex-1 items-center">
                                    <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-slate-400" aria-hidden="true" />
                                    <span class="ml-2 w-0 flex-1 truncate">resume_back_end_developer.pdf</span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                </div>
                            </li>
                            <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                <div class="flex w-0 flex-1 items-center">
                                    <PaperClipIcon class="h-5 w-5 flex-shrink-0 text-slate-400" aria-hidden="true" />
                                    <span class="ml-2 w-0 flex-1 truncate">coverletter_back_end_developer.pdf</span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                </div>
                            </li>
                        </ul>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Group from '../../models/group';
import { PaperClipIcon } from '@heroicons/vue/20/solid';

const props=withDefaults(
    defineProps<{
        group: Group;
    }>(),
    {
        group:() =>{
            return {} as Group;
        }
    }
)

</script>
