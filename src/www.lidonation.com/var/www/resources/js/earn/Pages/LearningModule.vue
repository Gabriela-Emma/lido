<template>
    <section class="py-4 sm:py-4 md:pb-20 md:pt-8 pb-16 xl:pb-36 xl:pt-16 bg-opacity-5 text-white overflow-visible z-5"
             style="background: url('/img/ngong-road-learn.svg') #C02025 0% 25% / 100%; background-size: 100% auto;">
        <div class="container">
            <div class="text-center flex flex-col gap-1 sm:gap-2 xl:gap-4">
                <div class="text-xl sm:text-2xl md:text-4xl xl:text-6xl font-bold">
                    {{ $t("Learn2earn") }}
                </div>
                <div class="text-sm sm:text-md md:text-lg xl:text-xl flex gap-2 justify-center">
                    <span class="after:content-['.'] after:text-2xl">
                        {{ $t("Learn") }}
                    </span>
                    <span class="after:content-['.'] after:text-2xl">
                        {{ $t("Take a Quiz") }}
                    </span>
                    <span class="after:content-['.'] after:text-2xl">
                        {{ $t("Earn") }}
                    </span>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-labs-red">
        <div class="container text-xl xl:text-2xl">
            <nav class="h-full overflow-y-auto" aria-label="Directory">
                <div v-for="topic in learningModule.topics" :key="topic?.id" class="relative">
                    <div class="sticky top-0 z-10 border-b border-t border-gray-200 px-6 py-1 text-sm font-medium text-gray-500">
                        <h3>{{ letter }}</h3>
                    </div>
                    <ul role="list" class="relative z-0 divide-y divide-gray-200" v-if="topic?.lessons">
                        <li v-for="lesson in topic.lessons" :key="topic.id" class="">
                            <div class="relative flex items-center space-x-3 px-6 py-5 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                                <div class="flex-shrink-0">
<!--                                    <img class="h-10 w-10 rounded-full" :src="person.imageUrl" alt="" />-->
                                </div>
                                <div class="min-w-0 flex-1">
                                    <a href="#" class="focus:outline-none">
                                        <!-- Extend touch target to entire panel -->
                                        <span class="absolute inset-0" aria-hidden="true" />
                                        <p class="text-sm font-medium text-gray-900">{{ topic?.name }}</p>
                                        <p class="truncate text-sm text-gray-500">{{ topic?.role }}</p>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {inject, ref} from "vue";
import {Link} from '@inertiajs/vue3';
import LearningModule from "../../catalyst-explorer/models/learning-module";
import LearningModuleCard from "../modules/learn/components/LearningModuleCard.vue";

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        locale: string,
        module:  LearningModule
    }>(), {});

let learningModule = ref(props.module);
</script>


<style scoped>

</style>
