<template>
    <dl class="flex flex-col justify-between h-full text-white">
        <dd>
            <div class="text-4xl font-semibold lg:text-5xl 2xltext-6xl">
                Coming Soon
            </div>
        </dd>
        <dt class="mt-3 text-lg font-medium truncate">
            ₳ registered but didn't vote
        </dt>
    </dl>
</template>

<script setup lang="ts">
import { watch } from 'vue';
import { VARIABLES } from '../../../models/variables'; 

const props = defineProps<{
    fundId: number
}>()

function getQueryData() {
    const data = {};
    if (props.fundId) {
        data[VARIABLES.FUNDS] = props.fundId;
    }

    return data;
}

let query = () => {
    let params = getQueryData()
    // request
}

watch(() => props.fundId, () => {
    query();
})
query();
</script>