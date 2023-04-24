<template>
    <section class="w-full flex flex-col gap-8">
        <div class="border-labs-red border-8 rounded-sm p-4">
            <div class="text-sm">Welcome back <b class="text-labs-black">{{ user.name }}</b></div>
        </div>
    </section>
</template>
<script lang="ts" setup>
import {computed, inject} from "vue";
import {usePage} from "@inertiajs/vue3";
import User from "../../global/Shared/Models/user";

const user = computed(() => usePage().props.user as User);
const $utils: any = inject('$utils');
const props = withDefaults(
    defineProps<{
        locale?: string
    }>(), {});
</script>
