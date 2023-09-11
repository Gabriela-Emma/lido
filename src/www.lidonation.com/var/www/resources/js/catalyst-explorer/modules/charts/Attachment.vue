<template>
    <div v-if="attachementLink" class="flex items-center gap-2">
        <a :href="attachementLink"
            type="button"
            class="px-2 py-1 text-xs font-semibold text-gray-900 bg-white rounded-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
            Download raw snapshot
        </a>
    </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { usePage } from '@inertiajs/vue3';
import axios from "axios";

const props = withDefaults(
    defineProps<{
        fundId?: number
    }>(),
    {},
);

const baseUrl = usePage().props.base_url;
const fundId = ref<number>(props.fundId);
const attachementLink = ref<string>('');

getTallies();

function getTallies() {
    axios.get(`${usePage().props.base_url}/catalyst-explorer/charts/attachment/link`,
            {
                params: {
                    "fund-id": fundId?.value
                }
            }
        )
        .then((res) => attachementLink.value = res?.data)
        .catch((error) => {
            console.error(error);
        });

}


</script>
