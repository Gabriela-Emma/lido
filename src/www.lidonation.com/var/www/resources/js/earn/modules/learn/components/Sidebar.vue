<template>
    <section class="sticky flex flex-col w-full gap-8 top-1">
        <div class="p-4 border-8 rounded-sm border-labs-red">
            <LearnerWelcomeWidget :user="user" />

            <div class="p-2 mt-4 rounded-sm bg-labs-black hover:bg-labs-red"
                v-if="!learnerData.wallet_address || !learnerData.wallet_stake_address">
                <AddWalletWidget :user="user" class="flex flex-col items-center justify-center gap-3 text-white">
                    <Link as="button" :href="route('earn.wallet.add')">
                    Add a wallet to withdraw rewards
                    </Link>

                </AddWalletWidget>
            </div>
            <div v-if="learnerData?.totalRewardSum / 1000000 > 5 && !learnerData.active_pool_id">
                <Delegate>
                    <template v-slot:button-title>
                        <button class="mt-3 rounded-sm px-3 py-1.5 bg-labs-black text-white text-sm">
                            Delegate to LIDO
                        </button>
                    </template>
                </Delegate>
            </div>


        </div>

        <div class="p-4 text-white border-8 rounded-sm border-labs-red bg-labs-red" :class="{
            'opacity-5 h-44': !(nextLessonAt || learnerData?.nextLesson),
            'opacity-100': (nextLessonAt || learnerData?.nextLesson)
        }">
            <countdown :time="nextLessonAt" v-slot="{ days, hours, minutes, seconds }" class="text-center"
                v-if="nextLessonAt">
                <small class="block xs text-slate-100">{{ $t('nextLessonStart') }}:</small>
                <div class="font-bold" v-if="locale !== 'sw'">
                    {{ hours }} {{ $t('hours') }}, {{ minutes }} {{ $t('minutes') }}, {{ seconds }} {{ $t('seconds') }}.
                </div>
                <div class="font-bold" v-if="locale === 'sw'">
                    {{ $t('hours') }} {{ hours }}, {{ $t('minutes') }} {{ minutes }}, {{ $t('seconds') }} {{ seconds }}.
                </div>
            </countdown>
            <div v-if="learnerData?.nextLesson" class="flex flex-col gap-4 px-2 py-3 mt-4 border-t border-labs-black/20">
                <div class="flex flex-col">
                    <small class="text-xs font-semibold text-labs-black">{{ $t('Next Lesson') }} </small>
                    <div class="text-sm font-bold text-white xl:text-md">
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

        <Promo />

        <div class="flex items-center gap-2 p-4 rounded-sm bg-slate-100 text-labs-black">
            <LifebuoyIcon class="w-5 h-5"></LifebuoyIcon>
            <div>
                {{ $t('Need help?') }}: &nbsp; <span class="font-bold">msaada@lidonation.com</span>
            </div>
        </div>

        <a :href="route('delegators') + '#everyEpoch'" class="flex flex-col gap-4 p-4 border-8 border-labs-black round-sm">
            <span class="block mb-2 text-lg lg:text-xl xl:text-2xl text-labs-black">More ways to earn</span>

            <img class="block" src="/img/every-epoch-logo.png" alt="Every Epoch logo">

            <span class="block text-xl text-center xl:text-3xl">
                Every Epoch
            </span>

            <span
                class="block text-xs font-normal text-center md:text-base text-slate-500 hover:text-slate-500">
                Learn + Earn. Every 5 days!
            </span>

            <span
                class="flex flex-col gap-1 text-xs font-normal text-center md:text-base text-slate-500 hover:text-slate-500">
                <span>$PHUFFY</span>
                <span>$HOSKY</span>
                <span>$NMKR</span>
            </span>
        </a>

    </section>
</template>
<script setup lang="ts">
import { computed, inject, ref, watch, defineAsyncComponent } from "vue";
import { usePage } from "@inertiajs/vue3";
import User from "../../../../global/Shared/Models/user";
import Countdown from "../../../../global/Shared/Components/countdown";
import moment from "moment-timezone";
import { Link } from "@inertiajs/vue3";
import { useLearnerDataStore } from "../../../store/learner-data-store";
import { storeToRefs } from "pinia";
import LearnerWelcomeWidget from "./LearnerWelcomeWidget.vue";
import AddWalletWidget from "./AddWalletWidget.vue";
import { LifebuoyIcon } from "@heroicons/vue/20/solid";
import LayoutWithSidebar from "../../../Shared/LayoutWithSidebar.vue";


const Promo = defineAsyncComponent(() => import('../../../../global/Shared/Components/Promo.vue'));
const Delegate = defineAsyncComponent(() => import("../../../../global/Shared/Components/Delegate.vue"));


const user = computed(() => usePage().props.user as User);
const $utils: any = inject('$utils');
let locale = computed(() => usePage().props.locale);

let learnerDataStore = useLearnerDataStore();
learnerDataStore.getLearnerData();
const { learnerData } = storeToRefs(learnerDataStore);

let nextLessonAt = ref(null);
watch(learnerData, (newValue) => {
    const nextLesson = moment(learnerData.value?.nextLessonAt).tz('Africa/Nairobi').startOf('day')
        .diff(
            moment().tz('Africa/Nairobi')
        );
    if (nextLesson > 0) {
        nextLessonAt.value = nextLesson
    }
})

</script>
