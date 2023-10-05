<template>
    <li class="flex flex-row justify-center px-6 py-8 text-center rounded-sm bg-primary-10 xl:px-8 xl:text-left">
        <div class="flex flex-col justify-between w-full space-y-6 xl:space-y-10">
            <a :href="catalystGroup.link"
                class="w-32 h-32 mx-auto rounded-full shadow-md shadow-inner lg:w-32 lg:h-32 xl:w-44 xl:h-44">
                <img class="w-full h-full rounded-full" :src="catalystGroup.gravatar ?? catalystGroup.thumbnail_url" alt={{catalystGroup.name}} />
            </a>
            <div class="items-end w-full space-y-2 xl:flex xl:items-center xl:justify-between">
                <div class="space-y-1 text-lg font-medium leading-6">
                    <h3 class="">
                        <a :href="catalystGroup.link"
                            class="text-gray-800 hover:text-teal-700">
                            {{ catalystGroup.name }}
                        </a>
                    </h3>
                    <div>
                        <div class="flex flex-col justify-center gap-2 itemscenter">
                            <div class="flex flex-row gap-2">
                                <div v-if="!!catalystGroup.amount_awarded_ada" class="flex flex-row gap-2">
                                    <span class="text-xl font-semibold text-teal-600">
                                        ₳{{ $filters.shortNumber(catalystGroup.amount_awarded_ada, 1) }}
                                    </span>
                                </div>
                                <div v-if="!!catalystGroup.amount_awarded_ada && !!catalystGroup.amount_awarded_usd">
                                    <span class="flex items-center justify-between ">
                                        <PlusIcon class="-ml-1 font-bold text-black w-7 h-7" aria-hidden="true" />
                                    </span>
                                </div>
                                <div v-if="!!catalystGroup.amount_awarded_usd">
                                    <span class="text-xl font-semibold text-teal-600">
                                        ${{ $filters.shortNumber(catalystGroup.amount_awarded_usd, 1) }}
                                    </span>
                                </div>

                            </div>
                            <span class="text-xs text-gray-500">{{ $t('Awarded') }}</span>
                        </div>
                    </div>
                </div>

                <ul role="list" class="relative flex flex-wrap items-center justify-start max-w-xs space-x-2 xl:top-4">
                    <li v-if="catalystGroup.twitter">
                        <a :href="`https://twitter.com/${catalystGroup.twitter}`" target="_blank"
                            class="text-gray-400 hover:text-gray-300">
                            <span class="sr-only">{{ $t('Twitter') }}</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path
                                    d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </li>

                    <li v-if="catalystGroup.discord">
                        <a :href="catalystGroup.discord" target="_blank" class="text-gray-400 hover:text-gray-300">
                            <span class="sr-only">{{ $t('Discord Server Url') }}</span>
                            <svg role="img" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5" fill="none">
                                <path
                                    d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.4189-2.1568 2.4189Z" />
                            </svg>
                        </a>
                    </li>

                    <li v-if="catalystGroup.website">
                        <a :href="catalystGroup.website" target="_blank" class="text-gray-400 hover:text-gray-300">
                            <span class="sr-only">{{ $t('Website') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </a>
                    </li>

                    <li v-if="catalystGroup.github">
                        <a :href="catalystGroup.github" target="_blank" class="text-gray-400 hover:text-gray-300">
                            <span class="sr-only">{{ $t('Github') }}</span>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </li>
</template>

<script lang="ts" setup>
import Group from '../../models/group';
import { inject } from "vue";
import { PlusIcon } from '@heroicons/vue/20/solid';


const $utils: any = inject('$utils');
const props = withDefaults(
    defineProps<{
        catalystGroup: Group
    }>(),
    {}
)

</script>
