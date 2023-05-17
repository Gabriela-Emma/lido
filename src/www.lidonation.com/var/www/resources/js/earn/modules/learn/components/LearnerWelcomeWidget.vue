<template>
    <div class="flex flex-col gap-2">
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
</template>
<script lang="ts" setup>
import User from "../../../../global/Shared/Models/user";
import {useLearnerDataStore} from "../../../store/learner-data-store";
import {storeToRefs} from "pinia";
import {ref, watch} from "vue";

let learnerDataStore = useLearnerDataStore();
learnerDataStore.getLearnerData();
const {learnerData} = storeToRefs(learnerDataStore);

let totalEarned = ref(null);
watch(learnerData, (newValue) => {
    totalEarned.value = learnerData.value?.totalRewardSum ? learnerData.value?.totalRewardSum / 1000000 : 0
})

withDefaults(
    defineProps<{
        user: User
    }>(), {});
</script>
