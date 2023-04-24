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
            <div class="grid grid-cols-7 gap-8">
                <div class="col-span-7 md:col-span-4 xl:col-span-5 border-8 border-labs-red p-8 rounded-sm">
                    <div class="mx-auto divide-y divide-slate-900/10">
                        <div>
                            <h2 class="text-2xl xl:text-4xl font-bold leading-10 tracking-tight text-slate-900 text-center">
                                {{ learningModule.title }}
                            </h2>
                        </div>
                        <div class="font-bold flex justify-center lg:text-lg xl:text-xl mt-3" v-if="nextQuestionRetry">
                            <countdown :time="nextQuestionRetry" v-slot="{ days, hours, minutes, seconds }">
                                <span class="text-slate-500"> You reached your daily limit, try again in: </span>
                                {{ hours }} hours, {{ minutes }} minutes, {{ seconds }} seconds.
                            </countdown>
                        </div>
                        <dl class="mt-10 divide-y divide-slate-900/10">
                            <Disclosure as="div" v-for="(topic, index) in learningModule.topics" :key="topic.id"
                                        :default-open="index === 0"
                                        v-slot="{ open }">
                                <dt :class="{'bg-slate-100': open }">
                                    <DisclosureButton
                                        class="flex w-full items-start justify-between text-left text-slate-900 py-5"
                                        :class="{
                                    'hover:bg-slate-100': !open
                                }">
                                        <div class="">
                                            <span class="xl:text-2xl font-semibold leading-7 px-4">{{
                                                    $t(topic.title)
                                                }}</span>
                                            <p class="leading-7 text-base text-slate-700 px-4" v-if="open">
                                                {{ $t(topic.content) }}
                                            </p>
                                        </div>
                                        <div class="ml-6 flex h-7 items-center">
                                          <PlusSmallIcon v-if="!open" class="h-6 w-6" aria-hidden="true"/>
                                          <MinusSmallIcon v-else class="h-6 w-6" aria-hidden="true"/>
                                        </div>
                                    </DisclosureButton>
                                </dt>
                                <DisclosurePanel as="dd" class="" :class="{ 'bg-slate-100 px-4': open }">
                                    <ul role="list" class="relative z-0 divide-y divide-white" v-if="topic?.lessons">
                                        <li v-for="lesson in topic.lessons" :key="topic.id" class="">
                                            <div class="w-full flex flex-row justify-between px-3 py-4">
                                                <div class="flex gap-1">
                                                    <div class="flex gap-2 items-center text-sm">
                                                        <div class="flex items-center gap-1">
                                                            <NewspaperIcon class="h-4 w-4"/>
                                                        </div>
                                                    </div>
                                                    <Link :href="lesson.link" class="text-sm font-medium">
                                                        {{ lesson?.title }}
                                                    </Link>
                                                </div>
                                                <div class="flex gap-2 text-sm">
                                                    <div class="flex items-center gap-1">
                                                <span>
                                                    <CheckBadgeIconSolid v-if="lesson.completed"
                                                                         class="h-5 w-5 text-labs-green"/>
                                                    <CheckBadgeIcon v-else class="h-5 w-5 text-slate-400"/>
                                                </span>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <div>
                                                            <ClockIcon class="h-4 w-4"/>
                                                        </div>
                                                        <div>
                                                            {{
                                                                new Date(lesson?.length * 1000).toISOString().substring(14, 19)
                                                            }}
                                                        </div>
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
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import {computed, inject, ref} from "vue";
import {Link} from '@inertiajs/vue3';
import {MinusSmallIcon, PlusSmallIcon, ClockIcon, CheckBadgeIcon, NewspaperIcon} from '@heroicons/vue/24/outline';
import {CheckBadgeIcon as CheckBadgeIconSolid} from '@heroicons/vue/24/solid';
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import LearningModuleData = App.DataTransferObjects.LearningModuleData;
import Countdown from "../../global/Shared/Components/countdown";
import moment from "moment-timezone";

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        locale: string,
        module: LearningModuleData
        userRetryLimit:string,
    }>(), {});

let learningModule = ref(props.module);

const currentDay = moment()
            .tz('Africa/Nairobi')
            .day();

let nextQuestionRetry = computed(() => {
    const nextRetry = moment(props.userRetryLimit).tz('Africa/Nairobi')
            .diff(
                moment().tz('Africa/Nairobi')
            );
    if (nextRetry > 0){
       return nextRetry
    }
    return null
});

</script>


<style scoped></style>
