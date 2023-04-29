<template>
    <section class="w-full flex flex-col gap-8">
        <div class="border-labs-red border-8 rounded-sm p-4 flex flex-col gap-2">
            <div class="text-sm">{{$t('welcomeBack')}} <b class="text-labs-black">{{ user.name }}</b></div>
            <div class="flex flex-row flex-wrap gap-3 text-xs 2xl:text-sm">
                <div class="flex gap-1">
                    <div class="text-slate-400">{{$t('awarded')}}</div>
                    <div class="text-md" :class="{
                        'text-labs-green font-bold': totalEarned > 0,
                        'text-slate-400': totalEarned <= 0
                    }">{{ totalEarned || '-' }} <span v-if="totalEarned">₳</span></div>
                </div>
            </div>
        </div>
        <div class="border-labs-red bg-labs-red text-white border-8 rounded-sm p-4">
            <countdown :time="nextLessonAt" v-slot="{ days, hours, minutes, seconds }">
                <span class="text-slate-100 text-sm text-center block">{{$t('nextLessonStart')}}:</span>
                <div class="font-bold" v-if="locale !== 'sw'">
                    {{ hours }} {{$t('hours')}}, {{ minutes }} {{$t('minutes')}}, {{ seconds }} {{$t('seconds')}}.
                </div>
                <div class="font-bold" v-if="locale == 'sw'" >
                     {{$t('hours')}} {{ hours }}, {{$t('minutes')}} {{ minutes }},  {{$t('seconds')}} {{ seconds }}.
                </div>
            </countdown>
        </div>
    </section>
</template>
<script setup lang="ts">
import {computed, inject, ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import User from "../../global/Shared/Models/user";
import Countdown from "../../global/Shared/Components/countdown";
import moment from "moment-timezone";
import axios from "axios";

const user = computed(() => usePage().props.user as User);
const $utils: any = inject('$utils');
let locale = computed(() => usePage().props.locale);

let nextLessonAt = ref(null);
axios.get(`${usePage().props.base_url}/api/earn/learn/next-lesson-at`)
    .then((res) => {
        if (res && res?.data) {
            const nextRetry = moment(res?.data).tz('Africa/Nairobi')
                .diff(
                    moment().tz('Africa/Nairobi')
                );
            if (nextRetry > 0) {
                nextLessonAt.value = nextRetry;
            }
        }
    });

let totalEarned = ref(null);
axios.get(`${usePage().props.base_url}/api/earn/learn/rewards/sum`)
    .then((res) => totalEarned.value = res?.data ? res?.data / 1000000 : 0);
</script>
