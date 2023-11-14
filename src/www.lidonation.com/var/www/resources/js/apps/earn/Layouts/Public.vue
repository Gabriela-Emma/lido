<template>
    <div v-if="user">
        <LearnNav :crumbs=crumbs />
    </div>

    <section class="">
        <slot></slot>
        <Modal />
    </section>
</template>

<script lang="ts" setup>
import { Modal } from "momentum-modal"
import {usePage} from '@inertiajs/vue3';
import {computed} from "vue";
import User from '@/global/models/user';
import LearnNav from "../modules/learn/components/LearnNav.vue";

const props = withDefaults(
    defineProps<{
        crumbs: []
    }>(), {});

const user = computed(() => usePage().props.user as User)
</script>
