<script lang="ts">
import LayoutWithSidebar from "../Layouts/LayoutWithSidebar.vue";

export default {
    layout: LayoutWithSidebar,
};
</script>
<template>
    <div class="mx-auto divide-y divide-slate-900/10">
        <div>
            <h2 class="text-2xl font-bold leading-10 tracking-tight text-center xl:text-4xl text-slate-900">
                {{ learningModule.title }}
            </h2>
        </div>
        <dl class="mt-10 divide-y divide-slate-900/10">
            <Disclosure as="div" v-for="(topic, index) in learningModule.topics" :key="topic.id"
                        :default-open="index === 0"
                        v-slot="{ open }">
                <dt :class="{'bg-slate-100': open }" @click="getLessons(topic.id,index)">
                    <DisclosureButton
                        class="flex items-start justify-between w-full py-5 text-left text-slate-900"
                        :class="{
                        'hover:bg-slate-100': !open
                        }" >
                        <div class="">
                                <span class="px-4 font-semibold leading-7 xl:text-2xl">{{
                                        $t(topic.title)
                                    }}</span>
                            <p class="px-4 text-base leading-7 text-slate-700" v-if="open">
                                {{ $t(topic.content) }}
                            </p>
                        </div>
                        <div class="flex items-center ml-6 h-7">
                            <PlusSmallIcon v-if="!open" class="w-6 h-6" aria-hidden="true"/>
                            <MinusSmallIcon v-else class="w-6 h-6" aria-hidden="true"/>
                        </div>
                    </DisclosureButton>
                </dt>
                <DisclosurePanel as="dd" class="" :class="{ 'bg-slate-100 px-4': open }">
                    <ul role="list" class="relative z-0 divide-y divide-white" v-if="topic?.lessons">
                        <li v-for="(lesson, index) in topic.lessons" :key="topic.id" >
                            <div class="flex flex-row justify-between w-full px-3 py-4">
                                <div class="flex gap-1">
                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="flex items-center gap-1">
                                            <NewspaperIcon class="w-4 h-4"/>
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
                                                             class="w-5 h-5 text-labs-green"/>
                                        <CheckBadgeIcon v-else class="w-5 h-5 text-slate-400"/>
                                    </span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <div>
                                            <ClockIcon class="w-4 h-4"/>
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
import {inject, ref} from "vue";
import {Link, usePage} from '@inertiajs/vue3';
import {MinusSmallIcon, PlusSmallIcon, ClockIcon, CheckBadgeIcon, NewspaperIcon} from '@heroicons/vue/24/outline';
import {CheckBadgeIcon as CheckBadgeIconSolid} from '@heroicons/vue/24/solid';
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import LearningModuleData = App.DataTransferObjects.LearningModuleData;
import {useSpinnerStore} from '@/global/stores/spinner-store'
import axios from '@/global/utils/axios'

const $utils: any = inject('$utils');

const props = withDefaults(
    defineProps<{
        locale: string,
        module: LearningModuleData
    }>(), {});

const spinnerStore = useSpinnerStore();
let learningModule = ref(props.module);

let getLessons = (id,index) => {
    const baseUrl = usePage().props?.ziggy?.url;
    let hasLessons = learningModule?.value?.topics?.[index]?.lessons != null;
    if(!hasLessons){
        spinnerStore.showSpinner('fill-labs-red');
        axios.get(`${baseUrl}/api/earn/topics/${id}/lessons`)
        .then((res) => {
            spinnerStore.stopSpinner();
            learningModule.value.topics[index].lessons = res?.data
        })
    }
}
getLessons(learningModule?.value?.topics?.[0]?.id,0)

</script>
<style scoped></style>
