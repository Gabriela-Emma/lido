<template>
    <section class="py-4 sm:py-4 md:pb-20 md:pt-8 pb-16 xl:pb-24 xl:pt-16 bg-opacity-5 text-white overflow-visible z-5"
             style="background: url('/img/ngong-road-learn.svg') 0% 35% / 100%; background-size: 100% auto;">
        <div class="container">
            <div class="text-center flex flex-col gap-1 sm:gap-2 xl:gap-3">
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
    <section class="py-8">
        <div class="container text-xl xl:text-2xl">
            <div class="mx-auto divide-y divide-slate-900/10">
                <div>
                    <h2 class="text-2xl xl:text-4xl font-bold leading-10 tracking-tight text-slate-900 text-center">
                        {{ learningModule.title }}
                    </h2>
                </div>
                <dl class="mt-10 divide-y divide-slate-900/10">
                    <Disclosure as="div" v-for="topic in learningModule.topics" :key="topic.id"
                                v-slot="{ open }">
                        <dt :class="{
                                    'bg-slate-100': open
                                }">
                            <DisclosureButton
                                class="flex w-full items-start justify-between text-left text-slate-900 py-5" :class="{
                                    'hover:bg-slate-100': !open
                                }">
                                <div class="">
                                    <span class="xl:text-2xl font-semibold leading-7 px-4">{{ $t(topic.title) }}</span>
                                    <p class="leading-7 text-base text-slate-700 px-4" v-if="open">
                                        {{ $t(topic.content) }}
                                    </p>
                                </div>
                                <span class="ml-6 flex h-7 items-center">
                              <PlusSmallIcon v-if="!open" class="h-6 w-6" aria-hidden="true"/>
                              <MinusSmallIcon v-else class="h-6 w-6" aria-hidden="true"/>
                            </span>
                            </DisclosureButton>
                        </dt>
                        <DisclosurePanel as="dd" class="" :class="{
                                    'bg-slate-100 px-4': open
                                }">
                            <ul role="list" class="relative z-0 divide-y divide-white" v-if="topic?.lessons">
                                <li v-for="lesson in topic.lessons" :key="topic.id" class="">
                                    <div class="w-full flex flex-row justify-between px-3 py-4">
                                        <div>
                                            <p class="text-sm font-medium">
                                                {{ lesson?.title }}
                                            </p>
                                        </div>
                                        <div class="flex gap-2 text-sm">
                                            <div class="flex items-center gap-1">
                                                <span>
                                                    <ClockIcon class="h-4 w-4"/>
                                                </span>
                                                <span>
                                                    {{
                                                        new Date(lesson?.length * 1000).toISOString().substring(14, 19)
                                                    }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </DisclosurePanel>
                    </Disclosure>
                </dl>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {inject, ref} from "vue";
import {Link} from '@inertiajs/vue3';
import LearningModuleCard from "../modules/learn/components/LearningModuleCard.vue";
import {MinusSmallIcon, PlusSmallIcon, ClockIcon} from '@heroicons/vue/24/outline';
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import LearningModuleData = App.DataTransferObjects.LearningModuleData;

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        locale: string,
        module: LearningModuleData
    }>(), {});

let learningModule = ref(props.module);
</script>


<style scoped>

</style>
