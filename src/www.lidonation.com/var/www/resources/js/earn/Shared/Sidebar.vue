<template>
    <section class="sticky flex flex-col w-full gap-8 top-1">
        <div class="flex flex-col gap-2 p-4 border-8 rounded-sm border-labs-red">
            <div class="text-sm">{{$t('welcomeBack')}} <b class="text-labs-black">{{ user.name }}</b></div>
            <div class="flex flex-row flex-wrap gap-3 text-xs 2xl:text-sm">
                <div class="flex gap-1">
                    <div class="text-slate-400">{{ $t('awarded') }}</div>
                    <div class="text-md" :class="{
                        'text-labs-green font-bold': totalEarned > 0,
                        'text-slate-400': totalEarned <= 0
                    }">{{ totalEarned || '-' }} <span v-if="totalEarned">₳</span></div>
                </div>
            </div>
        </div>
        <div class="p-4 text-white border-8 rounded-sm border-labs-red bg-labs-red">
            <countdown :time="nextLessonAt" v-slot="{ days, hours, minutes, seconds }" class="text-center">
                <span class="block text-sm text-slate-100">{{$t('nextLessonStart')}}:</span>
                <span class="block text-sm text-slate-100">{{ $t('nextLessonStart') }}:</span>
                <div class="font-bold" v-if="locale !== 'sw'">
                    {{ hours }} {{ $t('hours') }}, {{ minutes }} {{ $t('minutes') }}, {{ seconds }} {{ $t('seconds') }}.
                </div>
                <div class="font-bold" v-if="locale == 'sw'">
                    {{ $t('hours') }} {{ hours }}, {{ $t('minutes') }} {{ minutes }}, {{ $t('seconds') }} {{ seconds }}.
                </div>
            </countdown>
        </div>
    </section>
</template>
<script setup lang="ts">
import {Ref, computed, inject, ref, watch} from "vue";
import {usePage} from "@inertiajs/vue3";
import User from "../../global/Shared/Models/user";
import Countdown from "../../global/Shared/Components/countdown";
import moment from "moment-timezone";
import axios from "axios";
import {useLearnerDataStore} from "../store/learner-data-store";
import LearnerData = App.DataTransferObjects.LearnerData
import {storeToRefs} from "pinia";


const user = computed(() => usePage().props.user as User);
const $utils: any = inject('$utils');
let locale = computed(() => usePage().props.locale);

let learnerDataStore = useLearnerDataStore();
learnerDataStore.getLearnerData();
const {learnerData} = storeToRefs(learnerDataStore);

let nextLessonAt = ref(null);
let totalEarned = ref(null);
watch(learnerData, (newValue) => {
    const nextLesson = moment(learnerData.value?.nextLessonAt).tz('Africa/Nairobi').startOf('day')
        .diff(
            moment().tz('Africa/Nairobi')
        );
    if (nextLesson > 0) {
        nextLessonAt.value = nextLesson
    }

    totalEarned.value = learnerData.value?.totalRewardSum ? learnerData.value?.totalRewardSum / 1000000 : 0
})

</script>
