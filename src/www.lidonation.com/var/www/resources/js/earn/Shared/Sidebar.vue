<template>
    <section class="sticky flex flex-col w-full gap-8 top-1">
        <div class="flex flex-col gap-2 p-4 border-8 rounded-sm border-labs-red">
            <div class="text-sm">{{ $t('welcomeBack') }} <b class="text-labs-black">{{ user.name }}</b></div>
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
        <div class="p-4 text-white border-8 rounded-sm border-labs-red bg-labs-red"
             :class="{
                'opacity-5 h-44': !(nextLessonAt || learnerData?.nextLesson),
                'opacity-100': (nextLessonAt || learnerData?.nextLesson)
        }">
            <countdown :time="nextLessonAt" v-slot="{ days, hours, minutes, seconds }" class="text-center" v-if="nextLessonAt">
                <small class="block xs text-slate-100">{{ $t('nextLessonStart') }}:</small>
                <div class="font-bold" v-if="locale !== 'sw'">
                    {{ hours }} {{ $t('hours') }}, {{ minutes }} {{ $t('minutes') }}, {{ seconds }} {{ $t('seconds') }}.
                </div>
                <div class="font-bold" v-if="locale == 'sw'">
                    {{ $t('hours') }} {{ hours }}, {{ $t('minutes') }} {{ minutes }}, {{ $t('seconds') }} {{ seconds }}.
                </div>
            </countdown>
            <div v-if="learnerData?.nextLesson" class="border-t border-labs-black/20 px-2 py-3 flex flex-col gap-4 mt-4">
                <div class="flex flex-col">
                    <small class="text-xs text-labs-black font-semibold">{{ $t('Next Lesson') }} </small>
                    <div class="text-sm xl:text-md text-white font-bold">
                        {{ learnerData?.nextLesson?.title }}
                    </div>
                </div>
                <div class="flex justify-center text-lg">
                    <Link class="rounded-sm px-3 py-1.5 bg-labs-black text-white hover:text-labs-red-light text-sm"
                          :href="learnerData?.nextLesson?.link">{{ $t('View Lesson') }}
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup lang="ts">
import {computed, inject, ref, watch} from "vue";
import {usePage} from "@inertiajs/vue3";
import User from "../../global/Shared/Models/user";
import Countdown from "../../global/Shared/Components/countdown";
import moment from "moment-timezone";
import {Link} from "@inertiajs/vue3";
import {useLearnerDataStore} from "../store/learner-data-store";
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
