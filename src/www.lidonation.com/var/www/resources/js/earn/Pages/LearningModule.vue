<script lang="ts">
import LayoutWithSidebar from "../Shared/LayoutWithSidebar.vue";
import axios from "axios";

export default {
    layout: LayoutWithSidebar
};
</script>
<template>
    <div class="mx-auto divide-y divide-slate-900/10">
        <div>
            <h2 class="text-2xl xl:text-4xl font-bold leading-10 tracking-tight text-slate-900 text-center">
                {{ learningModule.title }}
            </h2>
        </div>
        <dl class="mt-10 divide-y divide-slate-900/10">
            <Disclosure as="div" v-for="(topic, index) in learningModule.topics" :key="topic.id"
                        :default-open="index === 0"
                        v-slot="{ open }">
                <dt :class="{'bg-slate-100': open }" @click="getLessons(topic.id,index)">
                    <DisclosureButton
                        class="flex w-full items-start justify-between text-left text-slate-900 py-5"
                        :class="{
                        'hover:bg-slate-100': !open
                        }" >
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
                        <li v-for="(lesson, index) in topic.lessons" :key="topic.id" >
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
</template>
<script setup lang="ts">
import {inject, Ref, ref} from "vue";
import {Link, usePage} from '@inertiajs/vue3';
import {MinusSmallIcon, PlusSmallIcon, ClockIcon, CheckBadgeIcon, NewspaperIcon} from '@heroicons/vue/24/outline';
import {CheckBadgeIcon as CheckBadgeIconSolid} from '@heroicons/vue/24/solid';
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import LearningModuleData = App.DataTransferObjects.LearningModuleData;
import LearningLessonsData  = App.DataTransferObjects.LearningLessonData;

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        locale: string,
        module: LearningModuleData
    }>(), {});

let learningModule = ref(props.module);

let getLessons = (id,index) => {
    let hasLessons = learningModule?.value?.topics[index]?.lessons != null;
    if(!hasLessons){
        axios.get(`${usePage().props.base_url}/api/earn/topic/${id}/lessons`)
        .then((res) => {
            learningModule.value.topics[index].lessons = res?.data
        })
    }
}
getLessons(learningModule?.value?.topics[0]?.id,0)

</script>
<style scoped></style>
