<template>
    <div class="flex w-full items-center justify-end space-x-0.5 mt-4 gap-2">
        <div v-if="chartsProposalsOptions" class="text-xs w-[240px] lg:w-[330px] lg:text-base">
            <Multiselect placeholder="Funding types" value-prop="value" label="label" v-model="selectedTypeRef"
                         :options="chartsProposalsOptions" :classes="{
                        container: 'multiselect border-0 p-0.5 flex-wrap',
                        containerActive: 'shadow-none shadow-transparent box-shadow-none',
                    }"/>
        </div>
    </div>
</template>
<script lang="ts" setup>
import Multiselect from '@vueform/multiselect';
import {useChartsWidgetStore} from "../../stores/chart-widgets-store";
import {storeToRefs} from "pinia";
import {ref, watch} from "vue";

const chartWidgets = useChartsWidgetStore();
const {chartsProposalsOptions, selectedValue} = storeToRefs(chartWidgets);

let selectedTypeRef = ref(selectedValue)

watch(
    () => selectedTypeRef,
    () => {
        chartWidgets.updateSelectedValue(selectedTypeRef.value);
    }
);
</script>
